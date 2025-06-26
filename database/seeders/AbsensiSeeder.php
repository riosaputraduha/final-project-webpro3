<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil tanggal awal dan akhir untuk rentang waktu
        $startDate = Carbon::createFromDate(2025, 2, 1);
        $endDate = Carbon::createFromDate(2025, 5, 5);

        // Mengambil semua kelas
        $semuaKelas = Kelas::all();

        if ($semuaKelas->isEmpty()) {
            // Jika belum ada kelas, buat dulu
            $this->command->info('Tidak ada kelas ditemukan. Buat kelas terlebih dahulu.');
            return;
        }

        // Loop untuk setiap kelas
        foreach ($semuaKelas as $kelas) {
            // Mengambil semua siswa di kelas tersebut
            $siswaKelas = Siswa::where('kelas_id', $kelas->id)->get();

            if ($siswaKelas->isEmpty()) {
                $this->command->info("Tidak ada siswa di kelas {$kelas->nama_kelas}. Melanjutkan ke kelas berikutnya.");
                continue;
            }

            // Untuk setiap hari dalam rentang tanggal (kecuali hari Sabtu dan Minggu)
            $currentDate = clone $startDate;
            while ($currentDate->lessThanOrEqualTo($endDate)) {
                // Skip weekend (6 = Saturday, 0 = Sunday)
                if ($currentDate->dayOfWeek == 0 || $currentDate->dayOfWeek == 6) {
                    $currentDate->addDay();
                    continue;
                }

                // Untuk setiap siswa di kelas tersebut
                foreach ($siswaKelas as $siswa) {
                    // Cek apakah absensi sudah ada untuk siswa dan tanggal ini
                    $absensiExists = Absensi::where([
                        'kelas_id' => $kelas->id,
                        'siswa_id' => $siswa->id,
                        'tanggal' => $currentDate->format('Y-m-d')
                    ])->exists();

                    if (!$absensiExists) {
                        // Tentukan status kehadiran (80% hadir, 7% izin, 8% sakit, 5% alpha)
                        $randStatus = rand(1, 100);

                        if ($randStatus <= 80) {
                            Absensi::factory()->hadir()->create([
                                'kelas_id' => $kelas->id,
                                'siswa_id' => $siswa->id,
                                'tanggal' => $currentDate->format('Y-m-d'),
                            ]);
                        } elseif ($randStatus <= 87) {
                            Absensi::factory()->izin()->create([
                                'kelas_id' => $kelas->id,
                                'siswa_id' => $siswa->id,
                                'tanggal' => $currentDate->format('Y-m-d'),
                            ]);
                        } elseif ($randStatus <= 95) {
                            Absensi::factory()->sakit()->create([
                                'kelas_id' => $kelas->id,
                                'siswa_id' => $siswa->id,
                                'tanggal' => $currentDate->format('Y-m-d'),
                            ]);
                        } else {
                            Absensi::factory()->alpha()->create([
                                'kelas_id' => $kelas->id,
                                'siswa_id' => $siswa->id,
                                'tanggal' => $currentDate->format('Y-m-d'),
                            ]);
                        }
                    }
                }

                $currentDate->addDay();
            }
        }

        $this->command->info('Data absensi berhasil ditambahkan dari 1 Februari 2025 sampai 5 Mei 2025');
    }
}
