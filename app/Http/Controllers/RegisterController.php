<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Menampilkan Form Register Akun Dasar (GET /register)
     */
    public function showRegisterForm()
    {
        return view('pendaftaran.form'); 
    }

    /**
     * Memproses pembuatan Akun Dasar (POST /register)
     */
    public function createAccount(Request $request)
    {
        // 1. Validasi HANYA input dasar
        $validatedData = $request->validate([
            'nim' => 'required|string|max:15|unique:pendaftar,nim',
            'nama_lengkap' => 'required|string|max:150',
            'email_kampus' => 'required|email|max:100|unique:pendaftar,email_kampus',
            'password' => 'required|min:8|confirmed', // Pastikan ada input password_confirmation di blade
        ]);

        // 2. SIMPAN KE DATABASE
        // Pastikan 'status_pendaftaran' sudah ada di $fillable pada Model Pendaftar
        $pendaftar = Pendaftar::create([
            'nim'           => $validatedData['nim'],
            'nama_lengkap'  => $validatedData['nama_lengkap'],
            'email_kampus'  => $validatedData['email_kampus'],
            'password_hash' => Hash::make($request->password), 
            'tgl_registrasi' => now(),
            'status_pendaftaran' => 'belum_daftar', // Mengatasi error "Field doesn't have a default value"
        ]);

        // 3. Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan Login untuk melengkapi data seleksi.');
    }
}