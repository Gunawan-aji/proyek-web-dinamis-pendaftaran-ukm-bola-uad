<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'user_admin';

    protected $primaryKey = 'id_user'; 
    
    // ===================================================================
    // KODE PERBAIKAN UNTUK MENGATASI SESSION ERROR (STRING ID)
    // ===================================================================
    
    // 1. Beri tahu Eloquent bahwa Primary Key BUKAN integer (karena ID Anda string/VARCHAR, misal 'adminuad')
    public $incrementing = false; 

    // 2. Beri tahu Eloquent bahwa Primary Key bertipe string (VARCHAR)
    protected $keyType = 'string'; 
    
    // ===================================================================
    
    /**
     * Kolom-kolom yang boleh diisi
     */
    protected $fillable = [
        'username',
        'password_hash',
        'nama_pengguna',
        'level',
    ];

    /**
     * Kolom yang harus disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password_hash', 
        'remember_token', 
    ];
    
    /**
     * Override method: Tentukan kolom mana di DB yang menyimpan password.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Override method: Tentukan kolom mana di DB yang digunakan sebagai identifier unik saat login.
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }
    
    /**
     * Definisi Relasi: Admin/Pelatih dapat membuat banyak Penilaian
     */
    public function penilaian()
    {
        // Admin/Pelatih memiliki relasi One-to-Many dengan Penilaian
        return $this->hasMany(Penilaian::class, 'id_penilai', 'id_user');
    }
}