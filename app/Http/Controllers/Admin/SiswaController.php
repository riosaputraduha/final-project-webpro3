<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::orderBy('nama')->paginate(20);
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $title = 'Data Siswa';

        return view('pages.admin.siswa.index', compact('siswa', 'kelas', 'title'));
    }

    public function filterKelas($idKelas)
    {
        $selectedKelas = Kelas::findOrFail($idKelas);
        $siswa = Siswa::orderBy('nama')
            ->where('kelas_id', $idKelas)
            ->paginate(20);
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $title = 'Data Siswa Kelas ' . $selectedKelas->nama_kelas;

        return view('pages.admin.siswa.index', compact('siswa', 'kelas', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Siswa';
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('pages.admin.siswa.create', compact('title', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required',
            'kelas_id' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'nama_orang_tua' => 'required',
            'no_hp' => 'required',
        ], [
            'nis.required' => 'NIS harus diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama.required' => 'Nama Lengkap harus diisi',
            'kelas_id.required' => 'Kelas harus diisi',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus diisi',
            'jenis_kelamin' => 'Jenis Kelamin harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'nama_orang_tua.required' => 'Nama Orang Tua harus diisi',
            'no_hp.required' => 'No HP harus diisi',
        ]);

        Siswa::create($validated);

        return redirect()->route('siswa.filter', $request->kelas_id)
            ->with('success', 'Data Siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = 'Detail Siswa';
        $siswa = Siswa::findOrFail($id);
        $qrCode = QrCode::size(200)->generate($siswa->nis);
        return view('pages.admin.siswa.show', compact('title', 'siswa', 'qrCode'));
    }

    public function qrCodedownload($id)
    {
        $siswa = Siswa::findOrFail($id);
        $qrCodeContent = QrCode::format('png')->size(300)->generate($siswa->nis);
        $fileName = 'qr-code-' . $siswa->nama . '-' . $siswa->nis . '.png';

        return response($qrCodeContent)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Edit Siswa';
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $siswa = Siswa::findOrFail($id);
        return view('pages.admin.siswa.edit', compact('title', 'kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $id,
            'nama' => 'required',
            'kelas_id' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'nama_orang_tua' => 'required',
            'no_hp' => 'required',
        ], [
            'nis.required' => 'NIS harus diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama.required' => 'Nama Lengkap harus diisi',
            'kelas_id.required' => 'Kelas harus diisi',
            'tempat_lahir.required' => 'Tempat Lahir harus diisi',
            'tanggal_lahir.required' => 'Tanggal Lahir harus diisi',
            'jenis_kelamin' => 'Jenis Kelamin harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'nama_orang_tua.required' => 'Nama Orang Tua harus diisi',
            'no_hp.required' => 'No HP harus diisi',
        ]);

        Siswa::findOrFail($id)->update($validated);

        return redirect()->route('siswa.filter', $request->kelas_id)
            ->with('success', 'Data Siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelasId = $siswa->kelas_id;
        $siswa->delete();

        return redirect()->route('siswa.filter', $kelasId)
            ->with('success', 'Data Siswa berhasil dihapus');
    }

    public function kartuPelajarDownload($id)
    {
        $siswa = Siswa::findOrFail($id);
        $pengaturan = Pengaturan::first();

        if ($pengaturan->logo) {
            $logoPath = public_path('storage/' . $pengaturan->logo);
        } else {
            $logoPath = public_path('images/logo.png');
        }

        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
        }

        $photo = base64_encode(file_get_contents(public_path('images/user.png')));

        $qrCodeBase64 = base64_encode(QrCode::format('png')
            ->size(150)
            ->margin(1)
            ->generate($siswa->nis));

        $data = [
            'siswa' => $siswa,
            'qrCode' => $qrCodeBase64,
            'pengaturan' => $pengaturan,
            'logo' => $logoBase64,
            'photo' => $photo
        ];

        $pdf = Pdf::loadView('kartu-pelajar', $data);
        $pdf->setPaper('A4', 'portrait');

        $fileName = 'kartu-pelajar-' . $siswa->nama . '-' . $siswa->nis . '.pdf';
        return $pdf->download($fileName);
    }
}
