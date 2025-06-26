<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapKehadiranController extends Controller
{
    public function kehadiran()
    {
        $kelas = Kelas::with(['waliKelas', 'siswa'])->get();
        $title = 'Semua Kelas';

        return view('pages.admin.kehadiran.index', compact('title', 'kelas'));
    }

    public function showKehadiran($id)
    {
        $kelas = Kelas::findOrFail($id);
        $title = 'Catatan Kehadiran Kelas ' . $kelas->nama_kelas;
        $absensi = Absensi::where('kelas_id', $id)
            ->select('tanggal')
            ->orderBy('tanggal', 'desc')
            ->distinct()
            ->paginate(10);

        return view('pages.admin.kehadiran.show', compact('title', 'kelas', 'absensi'));
    }

    public function detailKehadiran($id, $tanggal)
    {
        $kelas = Kelas::findOrFail($id);
        $title = 'Detail Kehadiran Kelas ' . $kelas->nama_kelas . ' Tanggal ' . Carbon::parse($tanggal)->translatedFormat('d F Y');
        $absensi = Absensi::where('kelas_id', $id)
            ->where('tanggal', $tanggal)
            ->with(['siswa'])
            ->get();

        return view('pages.admin.kehadiran.detail', compact('title', 'kelas', 'absensi'));
    }

    public function rekap()
    {
        $title = 'Rekap Absensi';
        $kelas = Kelas::get();

        return view('pages.admin.rekap.index', compact('title', 'kelas'));
    }

    public function showRekap($id, Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $kelas = Kelas::findOrFail($id);

        $title = 'Rekap Absensi Kelas ' . $kelas->nama_kelas . ' Bulan ' . $bulan . ' Tahun ' . $tahun;
        return view('pages.admin.rekap.show', compact('title', 'kelas', 'bulan', 'tahun'));
    }
}
