<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan Form Pendaftaran Lengkap (GET /register)
     */
    public function showRegistrationForm()
    {
        // Akan merender view: resources/views/pendaftaran/form.blade.php
        return view('pendaftaran.form');
    }

    /**
     * Memproses data Form Pendaftaran (POST /register)
     */
    public function processRegistration(Request $request)
    {
        // 1. VALIDASI DATA (Sangat detail sesuai skema DB Anda)
        $validatedData = $request->validate([
            'nim' => 'required|string|max:15|unique:pendaftar,nim',
            'nama_lengkap' => 'required|string|max:150',
            'email_kampus' => 'required|email|max:100|unique:pendaftar,email_kampus',
            'password' => 'required|min:8|confirmed', // Harus ada input password_confirmation
            'no_telepon' => 'required|string|max:20',
            'prodi' => 'required|string|max:100',
            'semester_saat_ini' => 'required|integer|min:1|max:14',
            'tgl_lahir' => 'required|date|before_or_equal:' . now()->subYears(17)->format('Y-m-d'), // Minimal 17 tahun
            
            'tinggi_badan_cm' => 'required|integer|min:100|max:250',
            'berat_badan_kg' => 'required|integer|min:30|max:200',
            'posisi_pilihan' => ['required', Rule::in(['GK', 'DF', 'MF', 'FW'])],
            'kaki_dominan' => ['required', Rule::in(['kanan', 'kiri', 'keduanya'])],
            'riwayat_cedera' => 'nullable|string|max:255',
            
            // DOKUMEN UPLOAD
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
            'ktm' => 'required|file|mimes:pdf,jpg,png|max:5000', // max 5MB
            'sk_sehat' => 'required|file|mimes:pdf,jpg,png|max:5000',
            'sertifikat' => 'nullable|file|mimes:pdf|max:5000',
        ]);
        
        // 2. UNGGAH FILE (Lebih aman menggunakan Storage Facade Laravel)
        $paths = [];
        try {
            $paths['path_foto'] = $request->file('foto')->store('dokumen/foto', 'public');
            $paths['path_ktm'] = $request->file('ktm')->store('dokumen/ktm', 'public');
            $paths['path_sk_sehat'] = $request->file('sk_sehat')->store('dokumen/sk_sehat', 'public');
            
            // Sertifikat adalah opsional
            if ($request->hasFile('sertifikat')) {
                $paths['path_sertifikat'] = $request->file('sertifikat')->store('dokumen/sertifikat', 'public');
            } else {
                $paths['path_sertifikat'] = null;
            }

        } catch (\Exception $e) {
            // Handle error upload file
            return back()->withInput()->with('error', 'Gagal mengunggah dokumen.')->withErrors(['upload' => 'Error: ' . $e->getMessage()]);
        }
        
        // 3. SIMPAN KE DATABASE (Menggunakan Eloquent Mass Assignment)
        Pendaftar::create([
            ...$validatedData, // Memasukkan semua data yang sudah divalidasi
            ...$paths,          // Menambahkan path file yang sudah diunggah
            
            // Hash Password
            'password_hash' => Hash::make($request->password), 
            
            // Status Awal
            'status_pendaftaran' => 'Menunggu Verifikasi Adm.',
            'tgl_registrasi' => now(),
        ]);

        // 4. Redirect
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login (NIM & Password) untuk memantau status Anda.');
    }
}