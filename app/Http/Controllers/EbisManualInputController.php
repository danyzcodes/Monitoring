<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EbisManualInput;
use App\Models\EbisPlanningOrder;
use App\Helpers\DropdownHelper;
use App\Models\EbisPlanningProgressLog;
use App\Models\MasterDatel;
use App\Models\MasterSto;
use App\Models\MasterMitra;
use Illuminate\Support\Facades\DB;
use App\Services\TelegramService;

class EbisManualInputController extends Controller
{
    
    public function index()
    {
        $datels = MasterDatel::orderBy('nama_datel')->pluck('nama_datel');
        $stos = MasterSto::orderBy('nama_sto')->pluck('nama_sto');
        $mitras = MasterMitra::orderBy('nama_mitra')->pluck('nama_mitra');

        $query = EbisManualInput::query();
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }
        $rows = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('deployment.input', compact('datels', 'stos', 'rows', 'mitras'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nde_jt' => 'nullable|string|max:255',
                'star_click_id' => 'required|string|max:50|unique:ebis_manual_inputs,star_click_id',
                'nomor_batch' => 'nullable|numeric',
                'nama_customer' => 'required|string|max:255',
                'nama_mitra' => 'required|string|max:255',
                'alamat_pelanggan' => 'nullable|string|max:255',
                'telepon_pelanggan' => 'nullable|string|max:30',
                'tikor_pelanggan' => 'nullable|string|max:50',
                'datel' => 'required|string|max:50',
                'sto' => 'required|string|max:50',
                'catatan' => 'nullable|string',
                'link_dokumen' => 'nullable|string',
            ],
            [
                'required' => 'attribute tidak boleh kosong',
                'unique' => ':attribute sudah digunakan. Silakan gunakan Starclick ID yang berbeda.',
            ],
            [
                'nde_jt' => 'Nomor NDE JT',
                'star_click_id' => 'Starclick ID / NCX',
                'nama_customer' => 'Nama Pelanggan',
                'nama_mitra' => 'Nama Mitra',
                'datel' => 'Datel',
                'sto' => 'STO',
            ],
        );

        $validated['user_id'] = auth()->id();
        $order = EbisManualInput::create($validated);

        
        defer(function () use ($order) {
            try {
                (new TelegramService())->notifyNewOrder($order);
            } catch (\Exception $e) {
                \Log::error('Telegram notif gagal (new order)', ['error' => $e->getMessage()]);
            }
        });

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    
    public function updateList(Request $request)
    {
        $user = auth()->user();
        // Cache key berdasarkan user id dan semua parameter request (filter + page)
        $cacheKey = 'update_list_' . $user->id . '_' . md5(http_build_query($request->except(['_token'])));

        $filters = DropdownHelper::getDynamicFilters();

        $rows = \Illuminate\Support\Facades\Cache::remember($cacheKey, 90, function () use ($request, $user) {

            $query = EbisManualInput::with('planning');

            if ($user->role !== 'admin') {
                $query->where('user_id', $user->id);
            }

            if ($request->filled('starclick')) {
                $query->where('star_click_id', $request->starclick);
            }

            if ($request->filled('nama_customer')) {
                $query->where('nama_customer', 'like', '%' . $request->nama_customer . '%');
            }

            if ($request->filled('sto')) {
                $stos = array_filter((array) $request->sto);
                if (!empty($stos)) $query->whereIn('ebis_manual_inputs.sto', $stos);
            }

            if ($request->filled('datel')) {
                $datels = array_filter((array) $request->datel);
                if (!empty($datels)) $query->whereIn('ebis_manual_inputs.datel', $datels);
            }

            if ($request->filled('progres')) {
                $progresses = array_filter((array) $request->progres);
                if (!empty($progresses)) $query->whereIn('ebis_manual_inputs.progres', $progresses);
            }

            if ($request->filled('nomor_batch')) {
                $batches = array_filter((array) $request->nomor_batch);
                if (!empty($batches)) $query->whereIn('ebis_manual_inputs.nomor_batch', $batches);
            }

            $hasRelFilter = $request->filled('status_order') || $request->filled('tipe_desain') || $request->filled('jenis_program') || $request->filled('cfu') || $request->filled('status_proyek');
            if ($hasRelFilter) {
                $query->whereHas('planning', function ($q) use ($request) {
                    if ($request->filled('status_order')) {
                        $vals = array_filter((array) $request->status_order);
                        if (!empty($vals)) $q->whereIn('status_order', $vals);
                    }
                    if ($request->filled('tipe_desain')) {
                        $vals = array_filter((array) $request->tipe_desain);
                        if (!empty($vals)) $q->whereIn('tipe_desain', $vals);
                    }
                    if ($request->filled('jenis_program')) {
                        $vals = array_filter((array) $request->jenis_program);
                        if (!empty($vals)) $q->whereIn('jenis_program', $vals);
                    }
                    if ($request->filled('cfu')) {
                        $vals = array_filter((array) $request->cfu);
                        if (!empty($vals)) $q->whereIn('cfu', $vals);
                    }
                    if ($request->filled('status_proyek')) {
                        $vals = array_filter((array) $request->status_proyek);
                        if (!empty($vals)) $q->whereIn('status_proyek', $vals);
                    }
                });
            }

            if ($request->usia == 'overdue') {
                $today = \Carbon\Carbon::now()->startOfDay()->format('Y-m-d');
                $query->whereHas('planning', function($q) {
                    $q->whereNotIn('status_order', ['Success', 'Gagal', 'Cancel']);
                })
                ->whereNotIn('ebis_manual_inputs.progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
                ->whereNotNull('data')
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.commitment_date')) IS NOT NULL")
                ->whereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.commitment_date')), '%Y-%m-%d') < ?", [$today]);
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            } elseif ($request->filled('start_date')) {
                $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
            } elseif ($request->filled('end_date')) {
                $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
            }

            if ($request->filled('search')) {
                $search = $request->search;
                if (str_contains($search, ',')) {
                    $values = array_filter(array_map('trim', explode(',', $search)));
                    $query->where(function ($q) use ($values) {
                        $q->whereIn('star_click_id', $values);
                        foreach ($values as $val) {
                            $q->orWhere('nama_customer', 'like', "%{$val}%");
                        }
                    });
                } else {
                    $query->where(function ($q) use ($search) {
                        $q->where('ebis_manual_inputs.star_click_id', 'like', "%{$search}%")
                          ->orWhere('ebis_manual_inputs.nde_jt', 'like', "%{$search}%")
                          ->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$search}%")
                          ->orWhere('ebis_manual_inputs.sto', 'like', "%{$search}%");
                    });
                }
            }

            $key    = $request->filter_key;
            $values = array_filter(array_map('trim', explode(',', $request->filter_values ?? '')));
            if ($key && !empty($values)) {
                $query->where(function ($q) use ($key, $values) {
                    foreach ($values as $val) {
                        if ($key === 'star_click_id') {
                            $q->orWhere('ebis_manual_inputs.star_click_id', $val);
                        } elseif ($key === 'sto') {
                            $q->orWhere('ebis_manual_inputs.sto', 'like', "%{$val}%");
                        } elseif ($key === 'nama_customer') {
                            $q->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$val}%");
                        }
                        if (in_array($key, ['ihld_lop_id', 'status_order', 'tipe_desain', 'jenis_program'])) {
                            $q->orWhereHas('planning', function ($p) use ($key, $val) {
                                if ($key === 'ihld_lop_id') {
                                    $p->where($key, $val);
                                } else {
                                    $p->where($key, 'like', "%{$val}%");
                                }
                            });
                        }
                    }
                });
            }

            return $query->paginate(10)->withQueryString();
        });

        if ($request->ajax()) {
            return view('deployment.partials.update-table', compact('rows'))->render();
        }

        return view('deployment.update', compact('rows', 'filters'));
    }

    
    public function edit($id)
    {
        $data = EbisManualInput::with(['planning.logs.user'])->findOrFail($id);

        $datels = MasterDatel::orderBy('nama_datel')->get();
        $stos = MasterSto::orderBy('nama_sto')->get();

        return view('deployment.edit', compact('data', 'datels', 'stos'));
    }

    
    public function update(Request $request, $id)
    {
        
        
        
        $manual = EbisManualInput::findOrFail($id);
        $allowedOptions = $manual->getAllowedProgressOptions(auth()->user());
        $existingData = is_array($manual->data) ? $manual->data : [];

        $rules = [
            'progres' => 'required|string|max:50|in:' . implode(',', $allowedOptions),
            'keterangan' => 'nullable|string',
            'commitment_date' => 'nullable|date',
        ];

        $messages = [
            'evidence_perijinan.required_without' => 'Evidence Perijinan berupa file gambar atau link dokumen harus diisi salah satu.',
            'link_evidence_perijinan.required_without' => 'Evidence Perijinan berupa file gambar atau link dokumen harus diisi salah satu.',
            'evidence_approved.required_without' => 'Evidence Approved berupa file gambar atau link dokumen harus diisi salah satu.',
            'link_evidence_approved.required_without' => 'Evidence Approved berupa file gambar atau link dokumen harus diisi salah satu.',
            'evidence_matdev.required_without' => 'Evidence Matdev berupa file gambar atau link dokumen harus diisi salah satu.',
            'link_evidence_matdev.required_without' => 'Evidence Matdev berupa file gambar atau link dokumen harus diisi salah satu.',
            'evidence_instalasi.required_without' => 'Evidence Instalasi berupa file gambar atau link dokumen harus diisi salah satu.',
            'link_evidence_instalasi.required_without' => 'Evidence Instalasi berupa file gambar atau link dokumen harus diisi salah satu.',
            'evidence_selesai_fisik.required_without' => 'Evidence Selesai Fisik berupa file gambar atau link dokumen harus diisi salah satu.',
            'link_evidence_selesai_fisik.required_without' => 'Evidence Selesai Fisik berupa file gambar atau link dokumen harus diisi salah satu.',
            
            'boq_on_desk.required' => 'BoQ On Desk tidak boleh kosong.',
            'boq_survey.required' => 'BoQ Survey tidak boleh kosong.',
            'boq_drm.required' => 'BoQ DRM tidak boleh kosong.',
            'status.required' => 'Status Uji Terima tidak boleh kosong.',
            'boq_rekon.required' => 'BoQ Rekon tidak boleh kosong.',
            
            'nama_odp.required' => 'Nama ODP Golive tidak boleh kosong.',
            'id_smallworld.required' => 'ID Smallworld tidak boleh kosong.',
            'nomor_order_ps.required' => 'Nomor Order PS tidak boleh kosong.',
            'tanggal_ps.required' => 'Tanggal PS tidak boleh kosong.',
            'jenis_kendala.required' => 'Jenis Kendala tidak boleh kosong.',
        ];

        if ($request->progres === 'ON DESK') {
            $rules['boq_on_desk'] = 'required|string|max:50';
        }

        if ($request->progres === 'SURVEY') {
            $rules['boq_survey'] = 'required|string|max:50';
        }

        if ($request->progres === 'DRM') {
            $rules['boq_drm'] = 'required|string|max:50';
        }

        if ($request->progres === 'UJI TERIMA') {
            $rules['status'] = 'required|string|max:50';
        }

        if ($request->progres === 'REKON') {
            $rules['boq_rekon'] = 'required|string|max:50';
        }

        if ($request->progres === 'PERIJINAN') {
            if (empty($existingData['evidence_perijinan']) && empty($existingData['link_evidence_perijinan'])) {
                $rules['evidence_perijinan'] = 'required_without:link_evidence_perijinan|nullable|image|max:2048';
                $rules['link_evidence_perijinan'] = 'required_without:evidence_perijinan|nullable|string';
            } else {
                $rules['evidence_perijinan'] = 'nullable|image|max:2048';
                $rules['link_evidence_perijinan'] = 'nullable|string';
            }
        }

        if ($request->progres === 'APPROVED BY EBIS') {
            if (empty($existingData['evidence_approved']) && empty($existingData['link_evidence_approved'])) {
                $rules['evidence_approved'] = 'required_without:link_evidence_approved|nullable|image|max:2048';
                $rules['link_evidence_approved'] = 'required_without:evidence_approved|nullable|string';
            } else {
                $rules['evidence_approved'] = 'nullable|image|max:2048';
                $rules['link_evidence_approved'] = 'nullable|string';
            }
        }

        if ($request->progres === 'MATDEV') {
            if (empty($existingData['evidence_matdev']) && empty($existingData['link_evidence_matdev'])) {
                $rules['evidence_matdev'] = 'required_without:link_evidence_matdev|nullable|image|max:2048';
                $rules['link_evidence_matdev'] = 'required_without:evidence_matdev|nullable|string';
            } else {
                $rules['evidence_matdev'] = 'nullable|image|max:2048';
                $rules['link_evidence_matdev'] = 'nullable|string';
            }
        }

        if ($request->progres === 'INSTALASI') {
            if (empty($existingData['evidence_instalasi']) && empty($existingData['link_evidence_instalasi'])) {
                $rules['evidence_instalasi'] = 'required_without:link_evidence_instalasi|nullable|image|max:2048';
                $rules['link_evidence_instalasi'] = 'required_without:evidence_instalasi|nullable|string';
            } else {
                $rules['evidence_instalasi'] = 'nullable|image|max:2048';
                $rules['link_evidence_instalasi'] = 'nullable|string';
            }
        }

        if ($request->progres === 'SELESAI FISIK') {
            if (empty($existingData['evidence_selesai_fisik']) && empty($existingData['link_evidence_selesai_fisik'])) {
                $rules['evidence_selesai_fisik'] = 'required_without:link_evidence_selesai_fisik|nullable|image|max:2048';
                $rules['link_evidence_selesai_fisik'] = 'required_without:evidence_selesai_fisik|nullable|string';
            } else {
                $rules['evidence_selesai_fisik'] = 'nullable|image|max:2048';
                $rules['link_evidence_selesai_fisik'] = 'nullable|string';
            }
        }

        if ($request->progres === 'GOLIVE') {
            $rules['nama_odp'] = 'required|string|max:100';
            $rules['id_smallworld'] = 'required|string|max:100';
        }

        if ($request->progres === 'PS') {
            $rules['nomor_order_ps'] = 'required|string|max:100';
            $rules['tanggal_ps'] = 'required|date';
        }

        if ($request->progres === 'KENDALA') {
            $rules['jenis_kendala'] = 'required|string|max:100';
        }

        $request->validate($rules, $messages);

        
        
        
        $planning = $manual->planning;

        if (!$planning) {
            $planning = new EbisPlanningOrder();
            $planning->star_click_id = $manual->star_click_id;
            $planning->nama_customer = $manual->nama_customer;
            $planning->progres = $request->progres;
            $planning->tanggal_update_progres = now();
            $planning->save();
        }

        
        
        
        $newData = $request->except(['_token', '_method', 'progres', 'keterangan']);
        
        
        if ($request->filled('commitment_date') && $request->commitment_date !== ($existingData['commitment_date'] ?? null)) {
            $newData['commitment_updated_by'] = auth()->id();
        }

        $data = array_merge($existingData, $newData);

        
        
        
        foreach ($request->allFiles() as $key => $file) {
            if ($file->isValid()) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('deployment/' . $request->progres, $filename, 'public');
                $data[$key] = $path;
                $newData[$key] = $path;
            }
        }

        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        $logData = array_filter($newData, function ($value) {
            return $value !== null && $value !== '';
        });

        
        
        
        $manual->update([
            'progres' => $request->progres,
            'keterangan' => $request->keterangan,
            'data' => $data,
            'tanggal_update_progres' => now(),
        ]);

        
        
        
        EbisPlanningProgressLog::create([
            'ebis_planning_order_id' => $planning->id,
            'user_id' => auth()->id(),
            'progres' => $request->progres,
            'keterangan' => $request->keterangan,
            'data' => $logData,
        ]);

        
        defer(function () use ($manual, $request) {
            try {
                $manual->refresh();
                (new TelegramService())->notifyProgressUpdate($manual, $request->progres, $request->keterangan);
            } catch (\Exception $e) {
                \Log::error('Telegram notif gagal (update progress)', ['error' => $e->getMessage()]);
            }
        });

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');

        // Hapus cache update list dan lihat data agar data terbaru langsung tampil setelah update
        $this->clearUpdateListCache();
        $this->clearLihatDataCache();

        return redirect()->route('deployment.update')->with('success', 'Progress deployment berhasil diperbarui');
    }

    private function clearUpdateListCache(): void
    {
        $userId = auth()->id();
        if (!$userId) return;

        \Illuminate\Support\Facades\Cache::forget('update_list_' . $userId . '_' . md5(''));
        for ($page = 1; $page <= 5; $page++) {
            \Illuminate\Support\Facades\Cache::forget('update_list_' . $userId . '_' . md5('page=' . $page));
        }
    }

    /**
     * Hapus cache lihat data untuk page 1-5 (yang paling sering dikunjungi).
     */
    private function clearLihatDataCache(): void
    {
        $userId = auth()->id();
        if (!$userId) return;

        \Illuminate\Support\Facades\Cache::forget('lihat_data_' . $userId . '_' . md5(''));
        for ($page = 1; $page <= 5; $page++) {
            \Illuminate\Support\Facades\Cache::forget('lihat_data_' . $userId . '_' . md5('page=' . $page));
        }
    }

    public function searchStarclick(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        
        $usedStarclicks = EbisManualInput::whereNotNull('star_click_id')
            ->where('star_click_id', '!=', '')
            ->pluck('star_click_id')
            ->toArray();

        $results = DB::table('ebis_planning_orders')
            ->where('star_click_id', '!=', '-')
            ->where('star_click_id', '!=', '')
            ->whereNotNull('star_click_id')
            ->whereNotIn('star_click_id', $usedStarclicks) 
            ->where(function ($q) use ($query) {
                $q->where('star_click_id', 'LIKE', "%{$query}%")
                  ->orWhere('nama_customer', 'LIKE', "%{$query}%");
            })
            ->select('star_click_id', 'nama_customer', 'datel', 'sto')
            ->limit(15)
            ->get()
            ->map(function ($item) {
                return [
                    'id'            => $item->star_click_id,
                    'text'          => $item->star_click_id . ' — ' . $item->nama_customer,
                    'nama_customer' => $item->nama_customer,
                    'datel'         => $item->datel,
                    'sto'           => $item->sto,
                ];
            })
            ->unique('id')
            ->values();

        return response()->json($results);
    }

    
    public function checkStarclickExists(Request $request)
    {
        $starclickId = $request->get('starclick_id', '');

        if (empty($starclickId)) {
            return response()->json(['exists' => false, 'message' => 'Starclick ID tidak boleh kosong']);
        }

        $exists = EbisManualInput::where('star_click_id', $starclickId)->exists();

        if ($exists) {
            return response()->json([
                'exists' => true,
                'message' => 'Starclick ID sudah digunakan. Silakan gunakan ID yang berbeda.'
            ]);
        }

        return response()->json(['exists' => false, 'message' => 'Starclick ID tersedia']);
    }
}
