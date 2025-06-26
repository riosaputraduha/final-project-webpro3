<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::first();

        if (!$tahunAjaran) {
            throw new \Exception('Data tahun ajaran belum tersedia.');
        }

        Kelas::insert([
            [
                'nama_kelas' => 'X IPA 1',
                'tahun_ajaran_id' => $tahunAjaran->id,
                'wali_kelas_id' => null, // atau isi jika ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kelas' => 'X IPA 2',
                'tahun_ajaran_id' => $tahunAjaran->id,
                'wali_kelas_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}