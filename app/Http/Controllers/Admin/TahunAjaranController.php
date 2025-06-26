<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    // Untuk menampilkan semua data tahun ajaran
    public function index()
    {
        $tahun_ajaran = TahunAjaran::orderBy('tahun_ajaran', 'DESC')->get();
        $title = 'Data Tahun Ajaran';
        return view('pages.admin.tahun-ajaran.index', compact('tahun_ajaran', 'title'));
    }

    // untuk menambah data tahun ajaran
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
        ], [
            'tahun_ajaran.required' => 'Tahun Ajaran harus diisi'
        ]);

        TahunAjaran::create($request->all());
        return redirect()->back()->with('success', 'Tahun Ajaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required'
        ], [
            'tahun_ajaran.required' => 'Tahun Ajaran harus diisi'
        ]);

        TahunAjaran::findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Tahun Ajaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        TahunAjaran::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Tahun Ajaran berhasil dihapus');
    }
}
