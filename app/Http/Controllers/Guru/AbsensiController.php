<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        $title = 'Absensi Kelas ' . $kelas->nama_kelas;
        return view('pages.guru.absensi', compact('title', 'kelas'));
    }

    public function storeQr(Request $request)
    {
        $siswa = Siswa::where('nis', $request->siswa_id)->first(); // udah dapat siswa
        $absensi = $siswa->absensi->where('tanggal', now()->format('Y-m-d'))->first(); // tidak ada data || NULL
        $pengaturan = Pengaturan::first();

        if (now()->format('H:i:s') >= $pengaturan->jam_pulang && $absensi != null) {
            if (Auth::user() && Auth::user()->role == 'admin') {
                return $next($request);
            }

            return redirect()->route('guru.dashboard');
            $absensi->update([
                'jam_pulang' => now()->format('H:i:s'),
            ]);
            $message = "Siswa dengan nama $siswa->nama sudah absen pulang pada jam " . now()->format('H:i:s') . "/n/n Terima kasih";
            $this->sendWhatsapp($message, $siswa->no_hp);
            return response()->json([
                'status' => 'error',
                'message' => 'pulang'
            ]);
        } else {
            $absensiMasuk = Absensi::create([
                'kelas_id' => $siswa->kelas_id,
                'siswa_id' => $siswa->id,
                'tanggal' => now()->format('Y-m-d'),
                'jam_masuk' => now()->format('H:i:s'),
                'status' => 'Hadir',
            ]);

            if ($absensi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'sudah absen'
                ]);
            }
            if (now()->format('H:i:s') > $pengaturan->jam_masuk) {
                $keterangan = 'Terlambat';
                $absensiMasuk->update([
                    'keterangan' => $keterangan,
                ]);
                $message = "Siswa dengan nama $siswa->nama sudah absen terlambat pada jam " . now()->format('H:i:s') . "/n/n Terima kasih";
                $this->sendWhatsapp($message, $siswa->no_hp);
                return response()->json([
                    'status' => 'success',
                    'message' => 'terlambat'
                ]);
            } else {
                $keterangan = 'Tepat Waktu';
                $absensiMasuk->update([
                    'keterangan' => $keterangan,
                ]);
                $message = "Siswa dengan nama $siswa->nama sudah absen pada jam " . now()->format('H:i:s') . "/n/n Terima kasih";
                $this->sendWhatsapp($message, $siswa->no_hp);
                return response()->json([
                    'status' => 'success',
                    'message' => 'tepat waktu'
                ]);
            }
        }
    }

    public function storeManual(Request $request)
    {
        $siswa = Siswa::findOrFail($request->siswa_id);
        $kelas = Kelas::findOrFail($siswa->kelas_id);
        $absensi = $siswa->absensi->where('tanggal', now()->format('Y-m-d'))->first();

        if ($absensi) {
            $absensi->update([
                'status' => $request->status,
            ]);
        } else {
            Absensi::create([
                'kelas_id' => $siswa->kelas_id,
                'siswa_id' => $siswa->id,
                'tanggal' => now()->format('Y-m-d'),
                'jam_masuk' => now()->format('H:i:s'),
                'status' => $request->status,
            ]);
        }

        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan');
    }

    public function sendWhatsapp($message, $phone)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $phone,
                'message' => $message,
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . env('WA_API_TOKEN') //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            echo $error_msg;
        }
    }
}
