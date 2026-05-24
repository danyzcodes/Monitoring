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
    /**
     * =============================
     * INPUT DATA (SEMUA MANUAL)
     * =============================
     */
    public function index()
    {
        $datels = MasterDatel::orderBy('nama_datel')->pluck('nama_datel');
        $stos = MasterSto::orderBy('nama_sto')->pluck('nama_sto');
        $mitras = MasterMitra::orderBy('nama_mitra')->pluck('nama_mitra');

        $rows = EbisManualInput::orderBy('created_at', 'desc')->paginate(10);

        return view('deployment.input', compact('datels', 'stos', 'rows', 'mitras'));
    }

    /**
     * =============================
     * SIMPAN DATA MANUAL
     * =============================
     */
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

        $order = EbisManualInput::create($validated);

        // Kirim notifikasi Telegram secara asinkron (dilatarbelakangi) agar input terasa instan
        defer(function () use ($order) {
            try {
                (new TelegramService())->notifyNewOrder($order);
            } catch (\Exception $e) {
                \Log::error('Telegram notif gagal (new order)', ['error' => $e->getMessage()]);
            }
        });

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * =============================
     * UPDATE DATA (LIST = REKAP)
     * =============================
     */
    public function updateList(Request $request)
    {
        /**
         * =============================
         * QUERY UTAMA
         * =============================
         */
        $rows = EbisManualInput::with('planning');

        /**
         * =============================
         * FILTER DARI FORM (DROPDOWN)
         * =============================
         */
        if ($request->filled('starclick')) {
            $rows->where('star_click_id', $request->starclick);
        }

        if ($request->filled('nama_customer')) {
            $rows->where('nama_customer', 'like', '%' . $request->nama_customer . '%');
        }

        if ($request->filled('sto')) {
            $stos = array_filter((array) $request->sto);
            if (!empty($stos)) $rows->whereIn('ebis_manual_inputs.sto', $stos);
        }

        if ($request->filled('datel')) {
            $datels = array_filter((array) $request->datel);
            if (!empty($datels)) $rows->whereIn('ebis_manual_inputs.datel', $datels);
        }

        if ($request->filled('progres')) {
            $progresses = array_filter((array) $request->progres);
            if (!empty($progresses)) $rows->whereIn('ebis_manual_inputs.progres', $progresses);
        }

        if ($request->filled('nomor_batch')) {
            $batches = array_filter((array) $request->nomor_batch);
            if (!empty($batches)) $rows->whereIn('ebis_manual_inputs.nomor_batch', $batches);
        }

        // FILTER DARI RELASI PLANNING
        $hasRelFilter = $request->filled('status_order') || $request->filled('tipe_desain') || $request->filled('jenis_program') || $request->filled('cfu') || $request->filled('status_proyek');
        if ($hasRelFilter) {
            $rows->whereHas('planning', function ($q) use ($request) {
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

        /**
         * =============================
         * FILTER KHUSUS (OVERDUE dll)
         * =============================
         */
        if ($request->usia == 'overdue') {
            $today = \Carbon\Carbon::now()->startOfDay()->format('Y-m-d');
            
            $rows->whereHas('planning', function($q) {
                // Ensure we only count active orders (not already finished)
                $q->whereNotIn('status_order', ['Success', 'Gagal', 'Cancel']);
            })
            ->whereNotIn('ebis_manual_inputs.progres', ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'])
            ->whereNotNull('data')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.commitment_date')) IS NOT NULL")
            ->whereRaw("STR_TO_DATE(JSON_UNQUOTE(JSON_EXTRACT(data, '$.commitment_date')), '%Y-%m-%d') < ?", [$today]);
        }

        /**
         * =============================
         * FILTER TANGGAL (CREATED AT)
         * =============================
         */
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $rows->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('start_date')) {
            $rows->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $rows->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        /**
         * =============================
         * SMART SEARCH (BULK / SINGLE)
         * =============================
         */
        if ($request->filled('search')) {
            $search = $request->search;
            if (str_contains($search, ',')) {
                // BULK SEARCH (Starclick ID OR Nama Customer)
                $values = array_filter(array_map('trim', explode(',', $search)));
                $rows->where(function ($q) use ($values) {
                    $q->whereIn('star_click_id', $values);
                    foreach ($values as $val) {
                        $q->orWhere('nama_customer', 'like', "%{$val}%");
                    }
                });
            } else {
                // SINGLE SEARCH (Wildcard)
                $rows->where(function ($q) use ($search) {
                    $q->where('ebis_manual_inputs.star_click_id', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.nde_jt', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.sto', 'like', "%{$search}%");
                });
            }
        }

        /**
         * =============================
         * CARI FILTERING (MULTIPLE)
         * =============================
         */
        $key = $request->filter_key;
        $values = array_filter(array_map('trim', explode(',', $request->filter_values ?? '')));

        if ($key && !empty($values)) {
            $rows->where(function ($q) use ($key, $values) {
                foreach ($values as $val) {
                    // FIELD MANUAL INPUT
                    if ($key === 'star_click_id') {
                        $q->orWhere('ebis_manual_inputs.star_click_id', $val); // exact match
                    } elseif ($key === 'sto') {
                        $q->orWhere('ebis_manual_inputs.sto', 'like', "%{$val}%");
                    } elseif ($key === 'nama_customer') {
                        $q->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$val}%");
                    }

                    // FIELD PLANNING (RELASI)
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

        // PAGINATION (HARUS PALING BAWAH)
        $rows = $rows->paginate(10)->withQueryString();

        /**
         * =============================
         * DROPDOWN FILTER DINAMIS
         * (DIAMBIL DARI DATA TABEL)
         * =============================
         */
        $filters = [
            'starclicks' => [],

            'nama_customers' => [],

            'stos' => \App\Models\MasterSto::orderBy('nama_sto')->pluck('nama_sto'),

            'datels' => \App\Models\MasterDatel::orderBy('nama_datel')->pluck('nama_datel'),

            'progresses' => EbisManualInput::select('progres')->whereNotNull('progres')->where('progres', '!=', '')->distinct()->orderBy('progres')->pluck('progres'),

            // dari relasi planning
            'status_orders' => EbisPlanningOrder::select('status_order')->whereNotNull('status_order')->distinct()->pluck('status_order'),

            'tipe_desains' => EbisPlanningOrder::select('tipe_desain')->whereNotNull('tipe_desain')->distinct()->pluck('tipe_desain'),

            'jenis_programs' => EbisPlanningOrder::select('jenis_program')->whereNotNull('jenis_program')->distinct()->pluck('jenis_program'),

            'cfus' => EbisPlanningOrder::select('cfu')->whereNotNull('cfu')->where('cfu', '!=', '')->distinct()->orderBy('cfu')->pluck('cfu'),

            'status_proyeks' => EbisPlanningOrder::select('status_proyek')->whereNotNull('status_proyek')->where('status_proyek', '!=', '')->distinct()->orderBy('status_proyek')->pluck('status_proyek'),

            'nomor_batches' => EbisManualInput::select('nomor_batch')->whereNotNull('nomor_batch')->where('nomor_batch', '!=', '')->distinct()->orderBy('nomor_batch')->pluck('nomor_batch'),
        ];

        if ($request->ajax()) {
            return view('deployment.partials.update-table', compact('rows'))->render();
        }

        return view('deployment.update', compact('rows', 'filters'));
    }

    /**
     * =============================
     * FORM EDIT DEPLOYMENT
     * =============================
     */
    public function edit($id)
    {
        $data = EbisManualInput::with('planning')->findOrFail($id);

        $datels = MasterDatel::orderBy('nama_datel')->get();
        $stos = MasterSto::orderBy('nama_sto')->get();

        return view('deployment.edit', compact('data', 'datels', 'stos'));
    }

    /**
     * =============================
     * UPDATE DATA DEPLOYMENT
     * (HANYA PLANNING)
     * =============================
     */
    public function update(Request $request, $id)
    {
        // =================================
        // 1️⃣ VALIDASI (DASAR + DINAMIS)
        // =================================
        $manual = EbisManualInput::findOrFail($id);
        $existingData = is_array($manual->data) ? $manual->data : [];

        $rules = [
            'progres' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
            'commitment_date' => 'nullable|date',
        ];

        // Evidence fields: required hanya kalau belum ada data sebelumnya
        if ($request->progres === 'PERIJINAN') {
            $rules['evidence_perijinan'] = empty($existingData['evidence_perijinan'])
                ? 'required|image|max:2048'
                : 'nullable|image|max:2048';
        }

        if ($request->progres === 'INSTALASI') {
            $rules['evidence_instalasi'] = empty($existingData['evidence_instalasi'])
                ? 'required|image|max:2048'
                : 'nullable|image|max:2048';
        }

        if ($request->progres === 'SELESAI FISIK') {
            $rules['evidence_selesai_fisik'] = empty($existingData['evidence_selesai_fisik'])
                ? 'required|image|max:2048'
                : 'nullable|image|max:2048';
        }

        if ($request->progres === 'APPROVED BY EBIS') {
            $rules['evidence_approved'] = empty($existingData['evidence_approved'])
                ? 'required|image|max:2048'
                : 'nullable|image|max:2048';
        }

        if ($request->progres === 'MATDEV') {
            $rules['evidence_matdev'] = empty($existingData['evidence_matdev'])
                ? 'required|image|max:2048'
                : 'nullable|image|max:2048';
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

        $request->validate($rules);

        // =================================
        // 2️⃣ AMBIL PLANNING
        // =================================
        $planning = $manual->planning;

        if (!$planning) {
            $planning = new EbisPlanningOrder();
            $planning->star_click_id = $manual->star_click_id;
            $planning->nama_customer = $manual->nama_customer;
            $planning->progres = $request->progres;
            $planning->tanggal_update_progres = now();
            $planning->save();
        }

        // =================================
        // 3️⃣ MERGE DATA: existing + new input
        // =================================
        $newData = $request->except(['_token', '_method', 'progres', 'keterangan']);
        
        // Cek jika ada update tanggal komitmen, simpan ID user yang melakukan update
        if ($request->filled('commitment_date') && $request->commitment_date !== ($existingData['commitment_date'] ?? null)) {
            $newData['commitment_updated_by'] = auth()->id();
        }

        $data = array_merge($existingData, $newData);

        // =================================
        // 4️⃣ HANDLE UPLOAD FILE
        // =================================
        foreach ($request->allFiles() as $key => $file) {
            if ($file->isValid()) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('deployment/' . $request->progres, $filename, 'public');
                $data[$key] = $path;
            }
        }


        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        // =================================
        // 5️⃣ UPDATE DATA TERAKHIR (STATUS SAAT INI)
        // =================================
        $manual->update([
            'progres' => $request->progres,
            'keterangan' => $request->keterangan,
            'data' => $data,
            'tanggal_update_progres' => now(),
        ]);

        // =================================
        // 6️⃣ SIMPAN RIWAYAT PROGRES (LOG 🔥)
        // =================================
        EbisPlanningProgressLog::create([
            'ebis_planning_order_id' => $planning->id,
            'user_id' => auth()->id(),
            'progres' => $request->progres,
            'keterangan' => $request->keterangan,
            'data' => $data,
        ]);

        // Kirim notifikasi Telegram secara asinkron (dilatarbelakangi) agar update terasa instan
        defer(function () use ($manual, $request) {
            try {
                $manual->refresh();
                (new TelegramService())->notifyProgressUpdate($manual, $request->progres, $request->keterangan);
            } catch (\Exception $e) {
                \Log::error('Telegram notif gagal (update progress)', ['error' => $e->getMessage()]);
            }
        });

        return redirect()->route('deployment.update')->with('success', 'Progress deployment berhasil diperbarui');
    }

    public function searchStarclick(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Get already used Starclick IDs from ebis_manual_inputs
        $usedStarclicks = EbisManualInput::whereNotNull('star_click_id')
            ->where('star_click_id', '!=', '')
            ->pluck('star_click_id')
            ->toArray();

        $results = DB::table('ebis_planning_orders')
            ->where('star_click_id', '!=', '-')
            ->where('star_click_id', '!=', '')
            ->whereNotNull('star_click_id')
            ->whereNotIn('star_click_id', $usedStarclicks) // Exclude already used IDs
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

    /**
     * =============================
     * CHECK IF STARCLICK ID EXISTS
     * =============================
     */
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
