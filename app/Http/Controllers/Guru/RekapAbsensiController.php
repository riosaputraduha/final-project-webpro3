<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    public function index()
    {
        $title = 'Rekap Absensi';

        return view('pages.guru.rekap.index', compact('title'));
    }

    public function show($id, Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $kelas = Kelas::findOrFail($id);

        $title = 'Rekap Absensi Kelas ' . $kelas->nama_kelas . ' Bulan ' . $bulan . ' Tahun ' . $tahun;
        return view('pages.guru.rekap.show', compact('title', 'kelas', 'bulan', 'tahun'));
    }
}
