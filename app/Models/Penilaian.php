<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';
    protected $fillable = [
        'id_pendaftar', 'skor_fisik', 'skor_teknik', 
        'skor_visi', 'skor_kerjasama', 'nilai_rata_rata', 'catatan_pelatih'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'id_pendaftar', 'id_pendaftar');
    }

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'id_pendaftar', 'id_pendaftar');
    }
}