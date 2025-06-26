<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        $title = 'Catatan Kehadiran Kelas ' . $kelas->nama_kelas;
        $absensi = Absensi::where('kelas_id', $id)
            ->select('tanggal')
            ->orderBy('tanggal', 'desc')
            ->distinct()
            ->paginate(10);

        return view('pages.guru.kehadiran.show', compact('title', 'kelas', 'absensi'));
    }

    public function detail($id, $tanggal)
    {
        $kelas = Kelas::findOrFail($id);
        $title = 'Detail Kehadiran Kelas ' . $kelas->nama_kelas . ' Tanggal ' . Carbon::parse($tanggal)->translatedFormat('d F Y');
        $absensi = Absensi::where('kelas_id', $id)
            ->where('tanggal', $tanggal)
            ->with(['siswa'])
            ->get();

        return view('pages.guru.kehadiran.detail', compact('title', 'kelas', 'absensi'));
    }
}
