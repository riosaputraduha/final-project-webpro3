<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = [
        'nama_kelas',
        'tahun_ajaran_id',
        'wali_kelas_id'
    ];

    public function tahunAjaran()
    {
        return $this->BelongsTo(TahunAjaran::class);
    }

    public function waliKelas()
    {
        return $this->BelongsTo(WaliKelas::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
