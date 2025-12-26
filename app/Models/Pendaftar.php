<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // PENTING: Import Authenticatable

class Pendaftar extends Authenticatable // PERBAIKAN PENTING #1: Ganti Model menjadi Authenticatable
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan
    protected $table = 'pendaftar';

    // Menentukan kunci utama kustom
    protected $primaryKey = 'id_pendaftar';

    // Kolom yang digunakan untuk autentikasi (Login)
    // Karena kita login menggunakan NIM, kita harus menimpa kolom default 'email'
    // Laravel akan mencari nilai input 'nim' yang dimasukkan di form login.
    public function getAuthIdentifierName()
    {
        return 'nim'; // PERBAIKAN PENTING #2: Menetapkan 'nim' sebagai kolom login
    }
    
    // PERBAIKAN PENTING #3: Menetapkan kolom yang menyimpan password
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
        'password_hash', // Dibiarkan sebagai nama kolom di DB
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
        'created_at', // Ditambahkan agar bisa diisi jika diperlukan (misalnya di seeder)
        'updated_at',
    ];

    /**
     * Kolom-kolom yang harus disembunyikan saat Model dikonversi ke array/JSON.
     */
    protected $hidden = [
        'password_hash', // PENTING: Jangan tampilkan hash password di API atau debug
    ];
    
    /**
     * Definisi Relasi: Pendaftar memiliki banyak Penilaian
     */
    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'id_pendaftar', 'id_pendaftar');
    }
}