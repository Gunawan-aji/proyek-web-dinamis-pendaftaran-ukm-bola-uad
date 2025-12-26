{{-- resources/views/admin/dashboard.blade.php --}}

@php
    // Ambil parameter 'page' dari URL (dilewatkan dari Controller)
    // Default: 'dashboard' jika tidak ada variabel $page dari Controller
    $page = $page ?? 'dashboard';

    // Tentukan judul halaman
    $title = "Dashboard Admin";
    switch ($page) {
        case 'peserta':
            $title = "Daftar Peserta";
            break;
        case 'penilaian':
            $title = "Penilaian Lapangan";
            break;
        case 'pengaturan':
            $title = "Pengaturan Seleksi";
            break;
    }

    // Asumsi: Variabel $admin diisi dengan data Admin yang sedang login
    $admin = Auth::guard('admin')->user();
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - UKM Sepak Bola UAD</title>
    {{-- Pastikan file CSS ini ada di public/css/admin.css --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="admin-body">

    <header class="admin-header">
        <div class="header-content">
            <h1 class="dashboard-title">{{ $title }}</h1>

            {{-- PERBAIKAN LOGOUT: Menggunakan Form POST dan @csrf --}}
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>

        <nav class="admin-nav">
            {{-- Mengganti link PHP native dengan helper route() Laravel --}}
            <a href="{{ route('admin.dashboard', ['page' => 'dashboard']) }}"
                class="nav-item {{ ($page == 'dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.dashboard', ['page' => 'peserta']) }}"
                class="nav-item {{ ($page == 'peserta') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Daftar Peserta
            </a>
            <a href="{{ route('admin.dashboard', ['page' => 'penilaian']) }}"
                class="nav-item {{ ($page == 'penilaian') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Penilaian Lapangan
            </a>
            <a href="{{ route('admin.dashboard', ['page' => 'pengaturan']) }}"
                class="nav-item {{ ($page == 'pengaturan') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Pengaturan Seleksi
            </a>
        </nav>
    </header>

    <main class="admin-main container">

        @if ($page == 'dashboard')
            {{-- --- KONTEN DASHBOARD --- (Menggunakan Blade) --}}
            <section class="stats-summary-grid">
                {{-- Data Statistik harus diambil dari Controller dan dilewatkan sebagai variabel (e.g., $totalPendaftar)
                --}}
                <div class="stat-card">
                    <span class="stat-label">Total Pendaftar</span>
                    <h2 class="stat-value">{{ $stats['total'] }}</h2>
                    <span class="stat-sub">Semua peserta</span>
                </div>

                <div class="stat-card">
                    <span class="stat-label">Diterima</span>
                    <h2 class="stat-value">{{ $stats['diterima'] }}</h2>
                    <span class="stat-sub">{{ $percentages['diterima'] }}% dari total</span>
                </div>
                {{-- ... Stat Cards lainnya ... --}}
                {{-- Bagian Statistik Dinilai --}}
                <div class="stat-card dinilai">
                    <i class="fas fa-edit"></i>
                    <h3>Dinilai</h3>
                    <p class="stat-value">{{ $stats['dinilai'] ?? 0 }}</p>
                    <span class="caption">{{ $percentages['dinilai'] ?? 0 }}% dari total</span>
                </div>

                {{-- Bagian Stat istik Menunggu --}}
                <div class="stat-card menunggu">
                    <i class="fas fa-hourglass-half"></i>
                    <h3>Menunggu</h3>
                    <p class="stat-value">{{ $stats['menunggu'] ?? 0 }}</p>
                    <span class="caption">{{ $percentages['menunggu'] ?? 0 }}% dari total</span>
                </div>
            </section>

            <section class="info-data-grid">
                {{-- ... Tabel dan Info lainnya (menggunakan @foreach jika data dinamis) ... --}}
                <div class="info-box blue-info-box">
                    <h2>Informasi Seleksi</h2>
                    <ul>
                        <li>
                            <p>Rata-rata Usia Peserta</p>
                            <strong>{{ number_format($rataRataUsia, 1) }} Tahun</strong>
                        </li>
                        <li>
                            <p>Tingkat Kelulusan</p>
                            <strong>{{ $infoSeleksi['kelulusan'] }}%</strong>
                        </li>
                        <li>
                            <p>Lokasi Seleksi</p>
                            <strong>{{ $infoSeleksi['lokasi'] }}</strong>
                        </li>
                        <li>
                            <p>Jadwal Seleksi Berikutnya</p>
                            <strong>{{ $infoSeleksi['jadwal'] }}</strong>
                        </li>
                    </ul>
                </div>
                <div class="info-box latest-data-box">
                    <h2>Pendaftar Terbaru</h2>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Posisi</th>
                                <th>Status</th> {{-- Logika Lolos/Gagal akan muncul di sini --}}
                                <th>Prodi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendaftarTerbaru as $p)
                                @php
                                    // Ambil nilai rata-rata jika ada
                                    $rataRata = $p->penilaian ? $p->penilaian->nilai_rata_rata : null;
                                @endphp
                                <tr>
                                    <td>{{ $p->nama_lengkap }}</td>
                                    <td>{{ $p->posisi_pilihan }}</td>
                                    <td>
                                        @if($p->penilaian)
                                            {{-- Jika sudah dinilai, cek nilai rata-ratanya --}}
                                            @if($rataRata >= 65)
                                                <span style="color: #28a745; font-weight: bold; font-size: 0.9em;">
                                                    <i class="fas fa-check-circle"></i> LOLOS
                                                </span>
                                            @else
                                                <span style="color: #dc3545; font-weight: bold; font-size: 0.9em;">
                                                    <i class="fas fa-times-circle"></i> GAGAL
                                                </span>
                                            @endif
                                        @else
                                            {{-- Jika belum dinilai, tampilkan status asli dari database --}}
                                            <span
                                                class="badge status-{{ str_replace([' ', '_'], '-', strtolower($p->status_pendaftaran)) }}">
                                                {{ ucwords(str_replace('_', ' ', $p->status_pendaftaran)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $p->prodi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

        @elseif ($page == 'peserta')
            <div class="content-card">
                <div class="card-header">
                    <h2>Tabel Data Seluruh Pendaftar</h2>
                    <div class="header-actions">
                        <span class="badge">Total: {{ $allPendaftar->total() }} Peserta</span>
                        <a href="{{ route('admin.export_pendaftar') }}" class="btn btn-secondary">
                            <i class="fas fa-download"></i> Export Data
                        </a>
                    </div>
                </div>

                {{-- Alert sukses pindah ke luar loop agar tidak duplikasi --}}
                @if(session('success'))
                    <div class="alert alert-success"
                        style="padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Posisi</th>
                                <th>Nilai Akhir</th> {{-- Kolom Baru Cara A --}}
                                <th>Tgl Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allPendaftar as $index => $pendaftar)
                                <tr>
                                    <td>{{ $allPendaftar->firstItem() + $index }}</td>
                                    <td>{{ $pendaftar->nim }}</td>
                                    <td>{{ $pendaftar->nama_lengkap }}</td>
                                    <td><strong>{{ $pendaftar->posisi_pilihan }}</strong></td>

                                    {{-- IMPLEMENTASI CARA A --}}
                                    <td>
                                        @if($pendaftar->penilaian)
                                            @php
                                                $rataRata = $pendaftar->penilaian->nilai_rata_rata;
                                            @endphp
                                            <div class="score-badge">
                                                <strong>{{ $rataRata }}</strong>
                                                <small style="display:block; font-size: 10px; color: #666;">Avg Score</small>
                                            </div>
                                        @else
                                            <span style="color: #ccc; font-style: italic;">Belum dinilai</span>
                                        @endif
                                    </td>


                                    {{-- Kolom Tanggal Daftar --}}
                                    <td>{{ $pendaftar->created_at->format('d/m/Y') }}</td>

                                    {{-- Kolom Status Kelulusan (Baris 240 ke bawah) --}}
                                    <td>
                                        @if($pendaftar->penilaian)
                                            @php
                                                // Definisikan variabel di sini agar tidak 'Undefined'
                                                $rataRata = $pendaftar->penilaian->nilai_rata_rata;
                                            @endphp

                                            @if($rataRata >= 65)
                                                <span style="color: #28a745; font-weight: bold; font-size: 1em;">
                                                    <i class="fas fa-check-circle"></i> LOLOS
                                                </span>
                                            @else
                                                <span style="color: #dc3545; font-weight: bold; font-size: 1em;">
                                                    <i class="fas fa-times-circle"></i> GAGAL
                                                </span>
                                            @endif
                                        @else
                                            {{-- Jika belum dinilai, tampilkan status asli dari database --}}
                                            <span
                                                class="badge status-{{ str_replace([' ', '_'], '-', strtolower($pendaftar->status_pendaftaran)) }}">
                                                {{ ucwords(str_replace('_', ' ', $pendaftar->status_pendaftaran)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.peserta.show', $pendaftar->id_pendaftar) }}"
                                                class="btn-action view" title="Detail"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.peserta.show', $pendaftar->id_pendaftar) }}#edit-status"
                                                class="btn-action edit" title="Edit Status"><i class="fas fa-edit"></i></a>

                                            <form action="{{ route('admin.peserta.destroy', $pendaftar->id_pendaftar) }}"
                                                method="POST" style="display:inline;"
                                                onsubmit="return confirm('Hapus peserta {{ $pendaftar->nama_lengkap }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-action delete" title="Hapus"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center;">Belum ada data pendaftar masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-laravel">
                    {{ $allPendaftar->links() }}
                </div>
            </div>

            {{-- Pagination Otomatis Laravel --}}
            <div class="pagination-laravel">
                {{ $allPendaftar->links() }}
            </div>
            </div>

        @elseif ($page == 'penilaian')
            {{-- --- KONTEN PENILAIAN LAPANGAN REAL-TIME --- --}}
            <div class="content-card">
                <h2>Input Penilaian Seleksi Fisik & Teknik</h2>
                <p class="subtitle">Cari peserta berdasarkan NIM dan masukkan nilai pada setiap kriteria.</p>

                <form action="{{ route('admin.dashboard') }}" method="GET" class="search-form">
                    <input type="hidden" name="page" value="penilaian">
                    <div class="form-group search-group">
                        <input type="text" name="nim" placeholder="Masukkan NIM Peserta" required
                            value="{{ request('nim') }}">
                        <button type="submit" class="btn btn-search"><i class="fas fa-search"></i> Cari Peserta</button>
                    </div>
                </form>

                @if ($peserta_data)
                    {{-- Tampilan Jika Peserta Ditemukan di Database --}}
                    <div class="peserta-detail-box">
                        <h3>Data Peserta Ditemukan</h3>
                        <p><strong>NIM:</strong> {{ $peserta_data->nim }}</p>
                        <p><strong>Nama:</strong> {{ $peserta_data->nama_lengkap }}</p>
                        <p><strong>Posisi:</strong> {{ $peserta_data->posisi_pilihan }}</p>
                        <p><strong>Prodi:</strong> {{ $peserta_data->prodi }}</p>
                    </div>

                    <form action="{{ route('admin.penilaian.store') }}" method="POST" class="form-penilaian">
                        @csrf
                        <input type="hidden" name="id_pendaftar" value="{{ $peserta_data->id_pendaftar }}">

                        <h3 class="input-title">Input Nilai Kriteria</h3>
                        <div class="penilaian-grid">
                            <div class="input-score-card">
                                <h4>Fisik</h4>
                                <input type="number" name="skor_fisik" min="0" max="100" required>
                            </div>
                            <div class="input-score-card">
                                <h4>Teknik</h4>
                                <input type="number" name="skor_teknik" min="0" max="100" required>
                            </div>
                            <div class="input-score-card">
                                <h4>Visi</h4>
                                <input type="number" name="skor_visi" min="0" max="100" required>
                            </div>
                            <div class="input-score-card">
                                <h4>Kerjasama</h4>
                                <input type="number" name="skor_kerjasama" min="0" max="100" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Simpan Penilaian</button>
                    </form>

                @elseif (request('nim'))
                    {{-- Tampilan Jika NIM tidak ada di DB --}}
                    <div class="alert-box alert-danger">NIM <strong>{{ request('nim') }}</strong> tidak ditemukan dalam data
                        pendaftar.</div>
                @else
                    <div class="alert-box alert-info">Silakan masukkan NIM di atas untuk memulai penilaian.</div>
                @endif
            </div>

        @elseif ($page == 'pengaturan')
            <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="form-pengaturan">
                @csrf

                <div class="pengaturan-grid">
                    {{-- SEKSI 1: JADWAL --}}
                    <div class="pengaturan-section">
                        <h4><i class="fas fa-calendar-day"></i> Jadwal Dashboard Peserta</h4>
                        <div class="form-group">
                            <label>Range Pendaftaran Online</label>
                            <input type="text" name="tgl_daftar_online" value="{{ $settings['tgl_daftar_online'] ?? '' }}"
                                placeholder="Contoh: 1 Nov - 30 Nov 2024">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Verifikasi Dokumen</label>
                            <input type="text" name="tgl_verifikasi" value="{{ $settings['tgl_verifikasi'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Seleksi Lapangan</label>
                            <input type="text" name="tgl_seleksi_lapangan"
                                value="{{ $settings['tgl_seleksi_lapangan'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengumuman Hasil</label>
                            <input type="text" name="tgl_pengumuman" value="{{ $settings['tgl_pengumuman'] ?? '' }}">
                        </div>
                    </div>

                    {{-- SEKSI 2: LOKASI & KUOTA --}}
                    <div class="pengaturan-section">
                        <h4><i class="fas fa-map-marked-alt"></i> Lokasi & Batas Kuota</h4>
                        <div class="form-group">
                            <label>Nama Lokasi Seleksi</label>
                            <input type="text" name="nama_lokasi_seleksi"
                                value="{{ $settings['nama_lokasi_seleksi'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap Lokasi</label>
                            <textarea name="alamat_lengkap_seleksi"
                                rows="2">{{ $settings['alamat_lengkap_seleksi'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Jam Operasional (Waktu)</label>
                            <input type="text" name="jam_seleksi" value="{{ $settings['jam_seleksi'] ?? '' }}"
                                placeholder="Contoh: 08:00 - 13:00 WIB">
                        </div>
                        <div class="form-group">
                            <label>Kuota Maksimum</label>
                            <input type="number" name="kuota_max" value="{{ $settings['kuota_max'] ?? '250' }}">
                        </div>
                        <div class="form-group">
                            <label>Pengumuman Seleksi Administrasi</label>
                            <input type="text" name="tgl_pengumuman_adm"
                                value="{{ $settings['tgl_pengumuman_adm'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Link Google Maps Stadion</label>
                            <input type="text" name="link_maps" value="{{ $settings['link_maps'] ?? '' }}">
                        </div>
                    </div>

                    {{-- SEKSI 3: SYARAT & DOKUMEN (Full Dinamis) --}}
                    <div class="pengaturan-section" style="grid-column: span 2;">
                        <h4><i class="fas fa-list-check"></i> Persyaratan & Dokumen (Pisahkan dengan Koma)</h4>
                        <div class="form-group">
                            <label>Persyaratan Umum</label>
                            <textarea name="syarat_umum" rows="3"
                                placeholder="Contoh: Mahasiswa Aktif, Sehat Jasmani, dll">{{ $settings['syarat_umum'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Dokumen yang Diperlukan</label>
                            <textarea name="dokumen_wajib" rows="3"
                                placeholder="Contoh: Scan KTM, Pas Foto, dll">{{ $settings['dokumen_wajib'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-save-large"><i class="fas fa-sync-alt"></i> Update Pengaturan</button>
            </form>

        @else
            {{-- Halaman 404 sederhana --}}
            <div class="content-card">
                <h2>404 Halaman Tidak Ditemukan</h2>
                <p>Konten yang Anda cari tidak tersedia. Silakan kembali ke <a
                        href="{{ route('admin.dashboard', ['page' => 'dashboard']) }}">Dashboard</a>.</p>
            </div>
        @endif

    </main>

    <footer class="admin-footer">
        <p>&copy; 2025 UKM Sepak Bola Universitas Ahmad Dahlan. All rights reserved.</p>
    </footer>

</body>

</html>