<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Kelas';
        $kelas = Kelas::with(['tahunAjaran', 'waliKelas'])->get();
        return view('pages.admin.kelas.index', compact('title', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahun_ajaran = TahunAjaran::orderBy('tahun_ajaran')->get();
        $wali_kelas = WaliKelas::orderBy('nama')->get();
        $title = 'Tambah Kelas';

        return view('pages.admin.kelas.create', compact('tahun_ajaran', 'wali_kelas', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required',
            'wali_kelas_id' => 'required',
            'nama_kelas' => 'required',
        ], [
            'tahun_ajaran_id.required' => 'Tahun Ajaran harus diisi',
            'wali_kelas_id.required' => 'Wali Kelas harus diisi',
            'nama_kelas.required' => 'Kelas harus diisi',
        ]);

        Kelas::create($validated);
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tahun_ajaran = TahunAjaran::orderBy('tahun_ajaran')->get();
        $wali_kelas = WaliKelas::orderBy('nama')->get();
        $kelas = Kelas::findOrFail($id);
        $title = 'Edit Kelas ' . $kelas->nama_kelas;

        return view('pages.admin.kelas.edit', compact('tahun_ajaran', 'wali_kelas', 'kelas', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required',
            'wali_kelas_id' => 'required',
            'nama_kelas' => 'required',
        ], [
            'tahun_ajaran_id.required' => 'Tahun Ajaran harus diisi',
            'wali_kelas_id.required' => 'Wali Kelas harus diisi',
            'nama_kelas.required' => 'Kelas harus diisi',
        ]);

        Kelas::findOrFail($id)->update($validated);
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus');
    }
}
