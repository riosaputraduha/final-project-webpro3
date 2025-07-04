<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';
    protected $fillable = [
        'nama_sekolah',
        'logo',
        'alamat',
        'jam_masuk',
        'jam_pulang'
    ];
}
