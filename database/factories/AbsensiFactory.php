<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absensi>
 */
class AbsensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Mengambil pengaturan jam sekolah
        $pengaturan = Pengaturan::first();
        $jamMasuk = $pengaturan ? $pengaturan->jam_masuk : '07:00:00';
        $jamPulang = $pengaturan ? $pengaturan->jam_pulang : '15:00:00';

        // Variasi jam masuk (terlambat atau tepat waktu)
        $jamMasukVariasi = Carbon::createFromFormat('H:i:s', $jamMasuk)
            ->addMinutes($this->faker->numberBetween(-15, 30))
            ->format('H:i:s');

        // Variasi jam pulang (pulang tepat waktu atau lebih awal/telat)
        $jamPulangVariasi = Carbon::createFromFormat('H:i:s', $jamPulang)
            ->addMinutes($this->faker->numberBetween(-20, 15))
            ->format('H:i:s');

        // Status kehadiran
        $status = $this->faker->randomElement(['Hadir', 'Izin', 'Sakit', 'Alfa']);

        // Keterangan berdasarkan status
        $keterangan = '';
        if ($status === 'Hadir') {
            if (Carbon::createFromFormat('H:i:s', $jamMasukVariasi) > Carbon::createFromFormat('H:i:s', $jamMasuk)) {
                $keterangan = 'Terlambat ' . Carbon::createFromFormat('H:i:s', $jamMasukVariasi)
                    ->diffInMinutes(Carbon::createFromFormat('H:i:s', $jamMasuk)) . ' menit';
            }
        } elseif ($status === 'Izin') {
            $keterangan = $this->faker->randomElement([
                'Acara keluarga',
                'Urusan pribadi',
                'Kegiatan ekstrakurikuler',
                'Lomba',
                'Izin pulang lebih awal'
            ]);
        } elseif ($status === 'Sakit') {
            $keterangan = $this->faker->randomElement([
                'Demam',
                'Flu',
                'Sakit perut',
                'Sakit kepala',
                'Kontrol ke dokter'
            ]);
        }

        // Jika status bukan Hadir, maka jam masuk dan pulang kosong
        if ($status !== 'Hadir') {
            $jamMasukVariasi = null;
            $jamPulangVariasi = null;
        }

        return [
            'kelas_id' => Kelas::inRandomOrder()->first()->id ?? Kelas::factory(),
            'siswa_id' => Siswa::inRandomOrder()->first()->id ?? Siswa::factory(),
            'tanggal' => $this->faker->dateTimeBetween('2025-02-01', '2025-05-05')->format('Y-m-d'),
            'jam_masuk' => $jamMasukVariasi,
            'jam_pulang' => $jamPulangVariasi,
            'status' => $status,
            'keterangan' => $keterangan,
        ];
    }

    /**
     * Indikasi siswa hadir di sekolah
     *
     * @return static
     */
    public function hadir()
    {
        return $this->state(function (array $attributes) {
            // Mengambil pengaturan jam sekolah
            $pengaturan = Pengaturan::first();
            $jamMasuk = $pengaturan ? $pengaturan->jam_masuk : '07:00:00';
            $jamPulang = $pengaturan ? $pengaturan->jam_pulang : '15:00:00';

            // Variasi jam masuk (terlambat atau tepat waktu)
            $jamMasukVariasi = Carbon::createFromFormat('H:i:s', $jamMasuk)
                ->addMinutes($this->faker->numberBetween(-15, 30))
                ->format('H:i:s');

            // Variasi jam pulang
            $jamPulangVariasi = Carbon::createFromFormat('H:i:s', $jamPulang)
                ->addMinutes($this->faker->numberBetween(-20, 15))
                ->format('H:i:s');

            // Keterangan jika terlambat
            $keterangan = '';
            if (Carbon::createFromFormat('H:i:s', $jamMasukVariasi) > Carbon::createFromFormat('H:i:s', $jamMasuk)) {
                $keterangan = 'Terlambat ' . Carbon::createFromFormat('H:i:s', $jamMasukVariasi)
                    ->diffInMinutes(Carbon::createFromFormat('H:i:s', $jamMasuk)) . ' menit';
            }

            return [
                'jam_masuk' => $jamMasukVariasi,
                'jam_pulang' => $jamPulangVariasi,
                'status' => 'Hadir',
                'keterangan' => $keterangan,
            ];
        });
    }

    /**
     * Indikasi siswa izin
     *
     * @return static
     */
    public function izin()
    {
        return $this->state(function (array $attributes) {
            return [
                'jam_masuk' => null,
                'jam_pulang' => null,
                'status' => 'Izin',
                'keterangan' => $this->faker->randomElement([
                    'Acara keluarga',
                    'Urusan pribadi',
                    'Kegiatan ekstrakurikuler',
                    'Lomba',
                    'Izin pulang lebih awal'
                ]),
            ];
        });
    }

    /**
     * Indikasi siswa sakit
     *
     * @return static
     */
    public function sakit()
    {
        return $this->state(function (array $attributes) {
            return [
                'jam_masuk' => null,
                'jam_pulang' => null,
                'status' => 'Sakit',
                'keterangan' => $this->faker->randomElement([
                    'Demam',
                    'Flu',
                    'Sakit perut',
                    'Sakit kepala',
                    'Kontrol ke dokter'
                ]),
            ];
        });
    }

    /**
     * Indikasi siswa alpha
     *
     * @return static
     */
    public function alpha()
    {
        return $this->state(function (array $attributes) {
            return [
                'jam_masuk' => null,
                'jam_pulang' => null,
                'status' => 'Alfa',
                'keterangan' => '',
            ];
        });
    }
}
