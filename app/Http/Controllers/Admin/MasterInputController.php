<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterDatel;
use App\Models\MasterSto;
use App\Models\MasterMitra;

class MasterInputController extends Controller
{
    public function index()
    {
        return view('admin.master-input.index', [
            'datels' => MasterDatel::orderBy('nama_datel')->get(),
            'stos'   => MasterSto::orderBy('nama_sto')->get(),
            'mitras' => MasterMitra::orderBy('nama_mitra')->get(),
        ]);
    }

    public function storeDatel(Request $request)
    {
        $request->validate([
            'nama_datel' => 'required|string|max:100|unique:master_datels,nama_datel'
        ]);

        MasterDatel::create([
            'nama_datel' => strtoupper($request->nama_datel)
        ]);

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');

        return back()->with('success', 'Datel berhasil ditambahkan');
    }

    public function storeSto(Request $request)
    {
        $request->validate([
            'nama_sto' => 'required|string|max:100|unique:master_stos,nama_sto'
        ]);

        MasterSto::create([
            'nama_sto' => strtoupper($request->nama_sto)
        ]);

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');

        return back()->with('success', 'STO berhasil ditambahkan');
    }

    public function storeMitra(Request $request)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:150|unique:master_mitras,nama_mitra'
        ]);

        MasterMitra::create([
            'nama_mitra' => strtoupper($request->nama_mitra)
        ]);

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');

        return back()->with('success', 'Mitra berhasil ditambahkan');
    }

    

    public function updateDatel(Request $request, $id)
    {
        $request->validate([
            'nama_datel' => 'required|string|max:100|unique:master_datels,nama_datel,' . $id
        ]);

        $datel = MasterDatel::findOrFail($id);
        $oldNama = $datel->nama_datel;
        $newNama = strtoupper($request->nama_datel);
        
        $datel->update(['nama_datel' => $newNama]);

        if ($oldNama !== $newNama) {
            \App\Models\EbisManualInput::where('datel', $oldNama)->update(['datel' => $newNama]);
            \App\Models\EbisPlanningOrder::where('datel', $oldNama)->update(['datel' => $newNama]);
        }

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');

        return back()->with('success', 'Datel berhasil diperbarui');
    }

    public function updateSto(Request $request, $id)
    {
        $request->validate([
            'nama_sto' => 'required|string|max:100|unique:master_stos,nama_sto,' . $id
        ]);

        $sto = MasterSto::findOrFail($id);
        $oldNama = $sto->nama_sto;
        $newNama = strtoupper($request->nama_sto);
        
        $sto->update(['nama_sto' => $newNama]);

        if ($oldNama !== $newNama) {
            \App\Models\EbisManualInput::where('sto', $oldNama)->update(['sto' => $newNama]);
            \App\Models\EbisPlanningOrder::where('sto', $oldNama)->update(['sto' => $newNama]);
        }

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');

        return back()->with('success', 'STO berhasil diperbarui');
    }

    public function updateMitra(Request $request, $id)
    {
        $request->validate([
            'nama_mitra' => 'required|string|max:150|unique:master_mitras,nama_mitra,' . $id
        ]);

        $mitra = MasterMitra::findOrFail($id);
        $oldNama = $mitra->nama_mitra;
        $newNama = strtoupper($request->nama_mitra);
        
        $mitra->update(['nama_mitra' => $newNama]);

        if ($oldNama !== $newNama) {
            \App\Models\EbisManualInput::where('nama_mitra', $oldNama)->update(['nama_mitra' => $newNama]);
            \App\Models\EbisPlanningOrder::where('nama_mitra', $oldNama)->update(['nama_mitra' => $newNama]);
        }

        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');

        return back()->with('success', 'Mitra berhasil diperbarui');
    }

    

    public function destroyDatel($id)
    {
        MasterDatel::findOrFail($id)->delete();
        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');
        return back()->with('success', 'Datel berhasil dihapus');
    }

    public function destroySto($id)
    {
        MasterSto::findOrFail($id)->delete();
        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');
        return back()->with('success', 'STO berhasil dihapus');
    }

    public function destroyMitra($id)
    {
        MasterMitra::findOrFail($id)->delete();
        \Illuminate\Support\Facades\Cache::forget('kpro_dynamic_filters');
        return back()->with('success', 'Mitra berhasil dihapus');
    }
}
