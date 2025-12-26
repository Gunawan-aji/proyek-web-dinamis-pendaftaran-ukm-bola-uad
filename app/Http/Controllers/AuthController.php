<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan Form Login (GET /login)
     */
    public function showLoginForm()
    {
        // Jika Admin sudah login, arahkan ke dashboard Admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        // JIKA PESERTA sudah login, arahkan ke dashboard Peserta (misalnya, '/pendaftar/dashboard')
        if (Auth::guard('peserta')->check()) { 
            return redirect()->route('pendaftar.dashboard'); // Asumsikan ada route ini
        }
        
        return view('auth.login');
    }

    /**
     * Memproses percobaan Login (POST /login)
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required', 
        ]);
        
        // 2. Kustomisasi Data untuk Peserta (Menggunakan kolom 'nim')
        // Guard 'peserta' (yang menggunakan Model Pendaftar) harus mencari berdasarkan 'nim'.
        $pesertaCredentials = [
            'nim' => $credentials['username'], // Kita asumsikan peserta login menggunakan NIM
            'password' => $credentials['password'],
        ];

        // 3. Coba Autentikasi sebagai PESERTA (Pendaftar)
        // *CATATAN PENTING: Guard 'peserta' dan Provider 'pendaftar' HARUS didefinisikan di config/auth.php!*
        if (Auth::guard('peserta')->attempt($pesertaCredentials, $request->boolean('remember'))) {
            
            $request->session()->regenerate();
            
            // Redirect ke Dashboard Peserta (Rute yang harus Anda buat)
            return redirect()->intended(route('pendaftar.dashboard')); 
        }

        // 4. Jika gagal sebagai Peserta, coba Autentikasi sebagai ADMIN
        // Guard 'admin' (yang menggunakan Model Admin) harus mencari berdasarkan 'username'.
        $adminCredentials = [
            'username' => $credentials['username'], // Admin login pakai username
            'password' => $credentials['password'], 
        ];
        
        if (Auth::guard('admin')->attempt($adminCredentials, $request->boolean('remember'))) {
            
            $request->session()->regenerate();

            // Redirect ke Admin Dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // 5. Jika gagal sebagai keduanya
        return back()->withErrors([
            'username' => 'Username atau Password tidak sesuai.',
        ])->onlyInput('username');
    }
    
    /**
     * Memproses Logout (POST /logout)
     * Kita harus log out dari semua guard yang mungkin.
     */
    public function logout(Request $request)
    {
        // Jika user adalah Admin, logout Admin.
        Auth::guard('admin')->logout(); 
        
        // Jika user adalah Peserta, logout Peserta.
        Auth::guard('peserta')->logout(); 
        
        // Logout dari Guard default (web) jika ada
        Auth::logout(); 

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}