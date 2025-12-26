<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiSeleksi extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'konfigurasi_seleksi';

    // Kunci utama defaultnya adalah 'id', jadi tidak perlu didefinisikan ulang
    // protected $primaryKey = 'id'; 

    /**
     * Kolom-kolom yang boleh diisi
     */
    protected $fillable = [
        'tgl_daftar_mulai',
        'tgl_daftar_akhir',
        'tgl_seleksi_lapangan',
        'lokasi_seleksi',
        'alamat_lokasi',
        'kuota_max',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Berguna agar tanggal dibaca sebagai objek Carbon.
     */
    protected $casts = [
        'tgl_daftar_mulai' => 'date',
        'tgl_daftar_akhir' => 'date',
        'tgl_seleksi_lapangan' => 'date',
    ];
}