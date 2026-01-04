<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pendaftar extends Authenticatable
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan
    protected $table = 'pendaftar';

    // Menentukan kunci utama kustom
    protected $primaryKey = 'id_pendaftar';

    // Kolom yang digunakan untuk autentikasi (Login)
    // Laravel akan mencari nilai input 'nim' yang dimasukkan di form login.
    public function getAuthIdentifierName()
    {
        return 'nim';
    }

    // Kolom yang menyimpan hash password di DB Anda adalah 'password_hash'
    public function getAuthPasswordName()
    {
        return 'password_hash'; // Laravel akan mengambil hash dari kolom ini
    }

    /**
     * Kolom-kolom yang boleh diisi melalui Mass Assignment.
     */
    protected $fillable = [
        // AKUN & DATA PRIBADI
        'nim',
        'nama_lengkap',
        'email_kampus',
        'password_hash',
        'no_telepon',
        'prodi',
        'semester_saat_ini',
        'tgl_lahir',

        // DATA FISIK & POSISI
        'tinggi_badan_cm',
        'berat_badan_kg',
        'posisi_pilihan',
        'kaki_dominan',
        'riwayat_cedera',

        // DOKUMEN (Path File)
        'path_foto',
        'path_ktm',
        'path_sk_sehat',
        'path_sertifikat',

        // STATUS & TIMESTAMPS
        'status_pendaftaran',
        'created_at',
        'updated_at',
    ];

    /**
     * Kolom-kolom yang harus disembunyikan saat Model dikonversi ke array/JSON.
     */
    protected $hidden = [
        'password_hash',
    ];

    /**
     * Definisi Relasi: Pendaftar memiliki banyak Penilaian
     */
    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'id_pendaftar', 'id_pendaftar');
    }
}