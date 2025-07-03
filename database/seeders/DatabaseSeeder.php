<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaliKelas;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\KelasSeeder;
use Database\Seeders\TahunAjaranSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TahunAjaranSeeder::class,
            KelasSeeder::class,
            // Example: OtherSeeder::class,
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administrator@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Guru',
            'email' => 'guru@absensi.com',
            'password' => Hash::make('guru12345'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        WaliKelas::create([
            'user_id' => 2,
            'nip' => '34220031',
            'nama' => 'Ayumi Susanti',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '1995-01-01',
            'tempat_lahir' => 'Jakarta Barat',
            'alamat' => 'Jakarta Barat',
        ]);
        WaliKelas::create([
            'user_id' => 2,
            'nip' => '34210232',
            'nama' => 'Bayu Andika Pratama',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1992-04-23',
            'tempat_lahir' => 'Sukabumi',
            'alamat' => 'Jakarta Timur',
        ]);

        Siswa::factory(120)->create();
        Pengaturan::create([
            'nama_sekolah' => 'SMA Negeri 1 Kota',
            'alamat' => 'Jl. Daan Mogot No. 1, Jakarta',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '13:00:00',
        ]);
    }
}
