<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Mengambil Judul dari view anak, defaultnya 'Dashboard Admin' --}}
    <title>@yield('title', 'Dashboard Admin') - UKM Sepak Bola UAD</title>
    
    {{-- Menghubungkan CSS menggunakan fungsi asset() Laravel --}}
    {{-- Pastikan admin.css ada di folder public/assets/css/ --}}
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    
    {{-- Font Awesome (sesuai yang Anda gunakan) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="admin-body">

    {{-- HEADER & NAVIGATION (sesuai admin.php lama) --}}
    <header class="admin-header">
        <div class="header-content">
            {{-- Blade: Menampilkan Judul --}}
            <h1 class="dashboard-title">@yield('title', 'Dashboard')</h1>
            
            {{-- Form Logout: Menggunakan rute POST Laravel, Wajib ada @csrf --}}
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf 
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>
        
        <nav class="admin-nav">
            {{-- Navigasi Dinamis menggunakan route() Laravel --}}
            <a href="{{ route('admin.dashboard') }}" 
               class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.pendaftar.index') }}" 
               class="nav-item {{ Request::routeIs('admin.pendaftar.index') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Daftar Peserta
            </a>
            <a href="{{ route('admin.penilaian.index') }}" 
               class="nav-item {{ Request::routeIs('admin.penilaian.index') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Penilaian Lapangan
            </a>
            <a href="{{ route('admin.konfigurasi.index') }}" 
               class="nav-item {{ Request::routeIs('admin.konfigurasi.index') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Pengaturan Seleksi
            </a>
        </nav>
    </header>

    {{-- KONTEN UTAMA: Area yang akan diisi oleh halaman spesifik (child view) --}}
    <main class="admin-main container">
        
        {{-- Area untuk Notifikasi Session (misal: success message setelah simpan data) --}}
        @if (session('success'))
            <div class="alert-box alert-info" style="background-color: #d4edda; color: #155724; border-color: #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="admin-footer">
        <p>&copy; 2025 UKM Sepak Bola Universitas Ahmad Dahlan. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>