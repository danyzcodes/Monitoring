<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\EbisPlanningImport;
use App\Exports\EbisPlanningExport;
use App\Exports\RekapExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EbisPlanningOrder;
use App\Models\EbisManualInput;
use App\Helpers\DropdownHelper;
use Maatwebsite\Excel\Validators\ValidationException;
use DB;

class EbisPlanningController extends Controller
{
    /**
     * =============================
     * IMPORT EXCEL (STRICT HEADER)
     * =============================
     */
    public function import(Request $request)
    {
        // ❌ Validasi: file harus ada
        if (!$request->hasFile('file')) {
            return redirect()->route('deployment.upload')->with('error', 'File tidak ditemukan! Silakan pilih file untuk diimport.');
        }

        // ❌ Validasi: hanya file Excel (.xlsx, .xls)
        $file = $request->file('file');
        $allowedMimes = ['xlsx', 'xls'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedMimes)) {
            return redirect()->route('deployment.upload')->with('error', 'Format file tidak didukung! Hanya file Excel (.xlsx, .xls) yang diperbolehkan.');
        }

        try {
            // ✅ Import dengan mode UPSERT (tidak hapus data lama)
            // - Data baru di Excel → INSERT
            // - Data sudah ada (cocok star_click_id) → UPDATE kolom dari Excel saja
            // - Data lama tidak ada di Excel → TETAP ada (tidak dihapus)
            Excel::import(new EbisPlanningImport(), $file);
        } catch (\Exception $e) {
            return redirect()
                ->route('deployment.upload')
                ->with('error', 'Tidak sesuai data yang ada');
        }

        // CEK APAKAH ADA DATA VALID
        $validData = EbisPlanningOrder::whereNotNull('star_click_id')->orWhereNotNull('track_id')->orWhereNotNull('ticket_id')->orWhereNotNull('nama_customer')->count();

        // ❌ JIKA TIDAK ADA DATA VALID
        if ($validData === 0) {
            return redirect()->route('deployment.upload')->with('error', 'Import ditolak! Data tidak sesuai dengan format yang diharapkan.');
        }

        // ✅ JIKA ADA DATA VALID
        return redirect()->route('deployment.upload')->with('success', 'Import berhasil. Data baru ditambahkan / diperbarui. Data lama tetap tersimpan.');
    }

    /**
     * =============================
     * EXPORT EXCEL
     * =============================
     */
    public function export()
    {
        return Excel::download(new EbisPlanningExport(), 'ebis_planning_export.xlsx');
    }

    /**
     * =============================
     * LIST DATA UPLOAD
     * =============================
     */
    public function index(Request $request)
    {
        $searchableColumns = ['star_click_id', 'track_id', 'ticket_id', 'nama_customer', 'status_order', 'tipe_desain', 'jenis_program', 'datel', 'sto', 'nama_pengguna_melakukan_alokasi_alpro', 'id_odp_alokasi_alpro', 'nama_odp_alokasi_alpro', 'reservation_id_alokasi_alpro', 'username_nik_melakukan_alokasi_alpro', 'sales_code', 'segment', 'cfu', 'source_app', 'regional', 'witel', 'witel_lama', 'wok', 'status_eproposal', 'status_tomps', 'status_sap', 'status_proyek', 'kode_program', 'nama_proyek', 'batch_program', 'kategori', 'tahun'];

        $rows = EbisPlanningOrder::query()
            
            // ❌ FILTER DUMMY RECORDS: Sembunyikan relasi fiktif yang terbuat dari Input Manual
            ->where(function($q) {
                $q->whereNotNull('sto')
                  ->orWhereNotNull('status_order')
                  ->orWhereNotNull('track_id');
            })

            // 🔍 GLOBAL SEARCH (SEMUA KOLOM)
            ->when($request->search, function ($query) use ($request, $searchableColumns) {
                $query->where(function ($q) use ($request, $searchableColumns) {
                    foreach ($searchableColumns as $column) {
                        $q->orWhere($column, 'like', '%' . $request->search . '%');
                    }
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        // ✅ AJAX → table saja
        if ($request->ajax()) {
            return view('deployment.partials.table', compact('rows'))->render();
        }

        // ✅ NORMAL → full page
        return view('deployment.upload', compact('rows'));
    }

    /**
     * =============================
     * LIST UPDATE DATA
     * =============================
     */
    public function updateList(Request $request)
    {
        $rows = EbisPlanningOrder::select(['id', 'star_click_id', 'nama_customer', 'datel', 'sto', 'status_order', 'tipe_desain', 'progres'])
            ->where(function ($q) {
                $q->whereNull('progres')->orWhere('progres', '-');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('deployment.update', compact('rows'));
    }

    /**
     * =============================
     * FORM EDIT
     * =============================
     */
    public function edit($id)
    {
        $data = EbisPlanningOrder::findOrFail($id);

        $datels = DropdownHelper::datels();
        $stos = DropdownHelper::stos();

        return view('deployment.edit', compact('data', 'datels', 'stos'));
    }

    /**
     * =============================
     * UPDATE DATA
     * =============================
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'track_id' => 'required|string|max:100',
            'datel' => 'required|string|max:50',
            'sto' => 'required|string|max:50',
            'status_order' => 'required|string|max:50',
            'tipe_desain' => 'required|string|max:50',
            'jenis_program' => 'nullable|string|max:50',
            'progres' => 'nullable|string|max:30',
            'tanggal_update_progres' => 'nullable|date',
        ]);

        EbisPlanningOrder::where('id', $id)->update($validated);

        return redirect()->route('deployment.update.list')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * =============================
     * LIHAT DATA (MANUAL + UPLOAD)
     * =============================
     */
    public function lihatData(Request $request)
    {
        $query = EbisManualInput::with('planning');

        /**
         * =============================
         * FILTER DROPDOWN ATAS
         * =============================
         */
        if ($request->filled('starclick')) {
            $query->where('star_click_id', $request->starclick);
        }

        if ($request->filled('nama')) {
            $query->where('nama_customer', 'like', '%' . $request->nama . '%');
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

        /**
         * =============================
         * FILTER TANGGAL (CREATED AT)
         * =============================
         */
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('ebis_manual_inputs.created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('ebis_manual_inputs.created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('ebis_manual_inputs.created_at', '<=', $request->end_date . ' 23:59:59');
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
                $query->where(function ($q) use ($values) {
                    $q->whereIn('ebis_manual_inputs.star_click_id', $values);
                    foreach ($values as $val) {
                        $q->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$val}%");
                    }
                });
            } else {
                // SINGLE SEARCH (Wildcard)
                $query->where(function ($q) use ($search) {
                    $q->where('ebis_manual_inputs.star_click_id', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$search}%")
                      ->orWhere('ebis_manual_inputs.nde_jt', 'like', "%{$search}%")
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
            $query->where(function ($q) use ($key, $values) {
                foreach ($values as $val) {
                    // FIELD MANUAL INPUT
                    if ($key === 'star_click_id') {
                        $q->orWhere('ebis_manual_inputs.star_click_id', $val); // exact match
                    } elseif ($key === 'sto') {
                        $q->orWhere('ebis_manual_inputs.sto', 'like', "%{$val}%");
                    } elseif ($key === 'nama_customer') {
                        $q->orWhere('ebis_manual_inputs.nama_customer', 'like', "%{$val}%");
                    }

                    // FIELD PLANNING
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

        /**
         * =============================
         * DROPDOWN FILTER DINAMIS
         * =============================
         */
        $filters = [
            'starclicks' => EbisManualInput::select('star_click_id')->whereNotNull('star_click_id')->distinct()->pluck('star_click_id'),

            'nama_customers' => EbisManualInput::select('nama_customer')->whereNotNull('nama_customer')->distinct()->pluck('nama_customer'),

            'stos' => \App\Models\MasterSto::orderBy('nama_sto')->pluck('nama_sto'),

            'datels' => \App\Models\MasterDatel::orderBy('nama_datel')->pluck('nama_datel'),

            'progresses' => EbisManualInput::select('progres')->whereNotNull('progres')->where('progres', '!=', '')->distinct()->orderBy('progres')->pluck('progres'),

            'status_orders' => EbisPlanningOrder::select('status_order')->whereNotNull('status_order')->distinct()->pluck('status_order'),

            'tipe_desains' => EbisPlanningOrder::select('tipe_desain')->whereNotNull('tipe_desain')->distinct()->pluck('tipe_desain'),

            'jenis_programs' => EbisPlanningOrder::select('jenis_program')->whereNotNull('jenis_program')->distinct()->pluck('jenis_program'),

            'cfus' => EbisPlanningOrder::select('cfu')->whereNotNull('cfu')->where('cfu', '!=', '')->distinct()->orderBy('cfu')->pluck('cfu'),

            'status_proyeks' => EbisPlanningOrder::select('status_proyek')->whereNotNull('status_proyek')->where('status_proyek', '!=', '')->distinct()->orderBy('status_proyek')->pluck('status_proyek'),

            'nomor_batches' => EbisManualInput::select('nomor_batch')->whereNotNull('nomor_batch')->where('nomor_batch', '!=', '')->distinct()->orderBy('nomor_batch')->pluck('nomor_batch'),
        ];

        /**
         * =============================
         * FINAL RESULT
         * =============================
         */
        $rows = $query
            ->leftJoin('ebis_planning_orders', 'ebis_manual_inputs.star_click_id', '=', 'ebis_planning_orders.star_click_id')
            ->select('ebis_manual_inputs.*')
            ->orderBy('ebis_planning_orders.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('deployment.partials.lihat-data-table', compact('rows'))->render();
        }

        return view('deployment.lihat_data', compact('rows', 'filters'));
    }

    /**
     * =============================
     * DETAIL LIHAT DATA
     * =============================
     */
    public function detailLihatData($id)
    {
        $data = EbisManualInput::with(['planning.logs' => function ($q) {
            $q->with('user')->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('deployment.detail_lihat', compact('data'));
    }

    /**
     * =============================
     * EXPORT REKAP KE EXCEL
     * =============================
     */
    public function exportLihatData(Request $request)
    {
        return Excel::download(new \App\Exports\RekapExport($request), 'lihat_data_b2b_' . date('Ymd_His') . '.xlsx');
    }
}
