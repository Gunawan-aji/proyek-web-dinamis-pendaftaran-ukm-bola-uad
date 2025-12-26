{{-- resources/views/admin/index.blade.php (Dashboard Peserta) --}}

@php
    // Ambil data peserta dari Controller (disimpan di $pendaftar)
    // Asumsi: $pendaftar sudah dilewatkan dari PendaftarDashboardController

    // Tentukan halaman aktif berdasarkan variabel yang dilewatkan (e.g., $page)
    // Jika tidak ada $page, default ke 'dashboard'
    $page = $page ?? 'dashboard';
    $status_pendaftaran = $pendaftar->status_pendaftaran ?? 'belum_daftar';

    // Tentukan judul halaman
    $title = "Dashboard Peserta";
    switch ($page) {
        case 'data_diri':
            $title = "Data Diri & Status";
            break;
        case 'form_pendaftaran':
            $title = "Formulir Pendaftaran";
            break;
    }
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - UKM Sepak Bola UAD</title>
    {{-- Pastikan file CSS ini ada di public/css/peserta.css --}}
    <link rel="stylesheet" href="{{ asset('css/peserta.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="peserta-body">

    <header class="peserta-header">
        <div class="header-content container">
            <h1 class="dashboard-title">Dashboard Peserta, {{ $pendaftar->nama_lengkap ?? 'Nama Peserta' }}</h1>

            {{-- PERBAIKAN LOGOUT: Menggunakan Form POST dan @csrf --}}
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div>

        <nav class="peserta-nav container">
            {{-- Navigasi ke Halaman Dashboard Utama --}}
            <a href="{{ route('pendaftar.dashboard', ['page' => 'dashboard']) }}"
                class="nav-item {{ $page == 'dashboard' ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>

            {{-- Navigasi ke Halaman Data Diri --}}
            <a href="{{ route('pendaftar.dashboard', ['page' => 'data_diri']) }}"
                class="nav-item {{ $page == 'data_diri' ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Status & Data Diri
            </a>

            {{-- Navigasi ke Halaman Form Pendaftaran --}}
            @if ($status_pendaftaran == 'belum_daftar' && $page != 'form_pendaftaran')
                <a href="{{ route('pendaftar.dashboard', ['page' => 'form_pendaftaran']) }}" class="btn-daftar-nav">
                    <i class="fas fa-file-signature"></i> Daftar Sekarang
                </a>
            @endif
        </nav>
    </header>

    <main class="peserta-main container">

        {{-- 3. Konten Utama: Tampilkan konten sesuai variabel $page --}}

        @if ($page == 'dashboard')
            {{-- --- KONTEN DASHBOARD (SEBELUM DAFTAR) --- --}}
            <section class="section-card hero-section">
                <h2>Siap Bergabung dengan Tim?</h2>
                <p>Kami membuka peluang untuk calon pemain berkualitas yang ingin bergabung dengan tim Sepak Bola UAD.</p>
            </section>

            <section class="jadwal-syarat-grid">
                <div class="left-column">
                    <div class="info-box blue-info-box">
                        <h3><i class="fas fa-calendar-alt"></i> Jadwal Seleksi</h3>
                        <ul>
                            <li>
                                <p>Pendaftaran Online</p>
                                <strong>{{ $settings['tgl_daftar_online'] ?? '1 November 2024 - 30 November 2024' }}</strong>
                            </li>
                            <li>
                                <p>Verifikasi Dokumen</p>
                                <strong>{{ $settings['tgl_verifikasi'] ?? '1 Desember 2024' }}</strong>
                            </li>
                            <li>
                                <p>Seleksi Lapangan</p>
                                <strong>{{ $settings['tgl_seleksi_lapangan'] ?? '10 Desember 2024' }}</strong>
                            </li>
                            <li>
                                <p>Pengumuman Hasil</p>
                                <strong>{{ $settings['tgl_pengumuman'] ?? '15 Desember 2024' }}</strong>
                            </li>
                        </ul>
                    </div>

                    <div class="syarat-dokumen-grid">
                        <div class="syarat-box">
                            <h3>Persyaratan Umum</h3>
                            <ul>
                                @php
                                    $syaratUmum = explode(',', $settings['syarat_umum'] ?? 'Mahasiswa Aktif UAD,Sehat Jasmani & Rohani,Mengisi formulir pendaftaran,Siap mengikuti semua tahapan');
                                @endphp
                                @foreach($syaratUmum as $syarat)
                                    <li><i class="fas fa-check-circle"></i> {{ trim($syarat) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="syarat-box">
                            <h3>Dokumen yang Diperlukan</h3>
                            <ul>
                                @php
                                    $dokumenWajib = explode(',', $settings['dokumen_wajib'] ?? 'Scan KTM/Kartu Mahasiswa,Foto berwarna terbaru 3x4,Surat keterangan sehat,Sertifikat prestasi (jika ada)');
                                @endphp
                                @foreach($dokumenWajib as $dokumen)
                                    <li><i class="fas fa-check-circle"></i> {{ trim($dokumen) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <div class="info-box yellow-info-box">
                        <h3><i class="fas fa-map-marker-alt"></i> Lokasi Seleksi</h3>
                        <p>{{ $settings['nama_lokasi_seleksi'] ?? 'Stadion Gelanggang Samudra' }}</p>
                        <small>{{ $settings['alamat_lengkap_seleksi'] ?? 'Jl. Ringroad Timur, Yogyakarta' }}</small>
                        <div class="jam-operasi">Waktu: {{ $settings['jam_seleksi'] ?? '08:00 - 13:00 WIB' }}</div>
                    </div>

                    <div class="action-box">
                        <p>{{ $settings['pesan_ajakan'] ?? 'Daftarkan diri Anda sekarang dan jadilah bagian dari pemain terbaik di Bola UAD.' }}
                        </p>
                        <a href="{{ route('pendaftar.dashboard', ['page' => 'form_pendaftaran']) }}"
                            class="btn btn-primary-lg">
                            <i class="fas fa-clipboard-list"></i> Daftar Sekarang
                        </a>
                    </div>
                </div>
            </section>

        @elseif ($page == 'form_pendaftaran')
            {{-- --- KONTEN FORMULIR PENDAFTARAN --- --}}
            <div class="section-card form-pendaftaran-card">
                <h2>Formulir Pendaftaran Calon Pemain</h2>
                <p class="subtitle">Mohon isi data di bawah ini dengan lengkap dan benar untuk proses verifikasi
                    administrasi.</p>

                {{-- PERBAIKAN: Gunakan route() untuk form action --}}
                <form action="{{ route('pendaftar.store_ukm') }}" method="POST" enctype="multipart/form-data">
                    @csrf {{-- Wajib ada token CSRF untuk POST --}}

                    <div class="form-section">
                        <h3>1. Data Pribadi</h3>
                        <div class="form-grid">
                            {{-- Menggunakan data dari $pendaftar untuk nilai default --}}
                            <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap"
                                    value="{{ $pendaftar->nama_lengkap ?? '' }}" placeholder="Nama sesuai KTM" required>
                            </div>
                            <div class="form-group"><label>NIM</label><input type="text" name="nim"
                                    value="{{ $pendaftar->nim ?? '' }}" placeholder="NIM Mahasiswa Aktif UAD" required
                                    readonly></div>
                            <div class="form-group"><label>Email</label><input type="email" name="email_kampus"
                                    value="{{ $pendaftar->email_kampus ?? '' }}" placeholder="Email aktif" required></div>
                            <div class="form-group"><label>Nomor Telepon/WA</label><input type="text" name="no_telepon"
                                    value="{{ $pendaftar->no_telepon ?? '' }}" placeholder="Contoh: 0812xxxx" required>
                            </div>
                            <div class="form-group"><label>Program Studi</label><input type="text" name="prodi"
                                    value="{{ $pendaftar->prodi ?? '' }}" placeholder="Misalnya: Teknik Informatika"
                                    required></div>
                            <div class="form-group"><label>Semester Saat Ini</label><input type="number"
                                    name="semester_saat_ini" value="{{ $pendaftar->semester_saat_ini ?? '' }}" min="1"
                                    max="14" required></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>2. Data Fisik & Posisi</h3>
                        <div class="form-grid">
                            <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir"
                                    value="{{ $pendaftar->tgl_lahir ?? '' }}" required></div>
                            <div class="form-group"><label>Tinggi Badan (cm)</label><input type="number"
                                    name="tinggi_badan_cm" value="{{ $pendaftar->tinggi_badan_cm ?? '' }}"
                                    placeholder="Contoh: 175" required></div>
                            <div class="form-group"><label>Berat Badan (kg)</label><input type="number"
                                    name="berat_badan_kg" value="{{ $pendaftar->berat_badan_kg ?? '' }}"
                                    placeholder="Contoh: 68" required></div>
                            <div class="form-group">
                                <label>Posisi Bermain Pilihan</label>
                                @php $posisi = $pendaftar->posisi_pilihan ?? ''; @endphp
                                <select name="posisi_pilihan" required>
                                    <option value="">-- Pilih Posisi Utama --</option>
                                    <option value="GK" {{ $posisi == 'GK' ? 'selected' : '' }}>Goalkeeper (GK)</option>
                                    <option value="DF" {{ $posisi == 'DF' ? 'selected' : '' }}>Defender (DF)</option>
                                    <option value="MF" {{ $posisi == 'MF' ? 'selected' : '' }}>Midfielder (MF)</option>
                                    <option value="FW" {{ $posisi == 'FW' ? 'selected' : '' }}>Forward (FW)</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Kaki Dominan</label>
                                @php $kaki = $pendaftar->kaki_dominan ?? ''; @endphp
                                <select name="kaki_dominan" required>
                                    <option value="kanan" {{ $kaki == 'kanan' ? 'selected' : '' }}>Kanan</option>
                                    <option value="kiri" {{ $kaki == 'kiri' ? 'selected' : '' }}>Kiri</option>
                                    <option value="keduanya" {{ $kaki == 'keduanya' ? 'selected' : '' }}>Keduanya
                                        (Ambidextrous)</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Riwayat Cedera Berat (Jika Ada)</label><input type="text"
                                    name="riwayat_cedera" value="{{ $pendaftar->riwayat_cedera ?? '' }}"
                                    placeholder="Contoh: Patah Kaki 2022 / Kosongkan"></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>3. Upload Dokumen (Maks. 2MB per file)</h3>
                        {{-- Catatan: Form ini hanya untuk upload, input file tidak bisa diisi value dari DB --}}
                        <div class="form-grid document-upload-grid">
                            <div class="form-group"><label>Foto Terbaru 3x4 (Wajib)</label><input type="file"
                                    name="path_foto" accept="image/*" required></div>
                            <div class="form-group"><label>Scan KTM (Wajib)</label><input type="file" name="path_ktm"
                                    accept=".pdf, image/*" required></div>
                            <div class="form-group"><label>Surat Keterangan Sehat (Wajib)</label><input type="file"
                                    name="path_sk_sehat" accept=".pdf, image/*" required></div>
                            <div class="form-group"><label>Sertifikat Prestasi (Opsional)</label><input type="file"
                                    name="path_sertifikat" accept=".pdf, image/*"></div>
                        </div>
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="persetujuan" name="persetujuan" required>
                        <label for="persetujuan">Saya menyatakan bahwa semua data yang diisi adalah benar dan siap mengikuti
                            seluruh tahapan seleksi.</label>
                    </div>

                    <button type="submit" class="btn btn-submit-form"><i class="fas fa-paper-plane"></i> Kirim Formulir
                        Pendaftaran</button>
                </form>
            </div>

        @elseif ($page == 'data_diri')
            {{-- --- KONTEN DASHBOARD (SETELAH DAFTAR/DATA DIRI) --- --}}
            <div class="status-header-box">
                <h2><i class="fas fa-info-circle"></i> Status Pendaftaran</h2>

                @if(isset($pendaftar) && $pendaftar->penilaian)
                    {{-- Logika Jika Nilai Sudah Keluar --}}
                    @php $rataRata = $pendaftar->penilaian->nilai_rata_rata; @endphp

                    @if($rataRata >= 65)
                        <span class="status-badge status-lolos-admin"
                            style="background-color: #28a745; color: white; padding: 5px 15px; border-radius: 20px; font-weight: 600;">
                            <i class="fas fa-check-circle"></i> LOLOS SELEKSI (Skor:
                            {{ number_format($rataRata, 1) }})
                        </span>
                    @else
                        <span class="status-badge status-tolak-adm"
                            style="background-color: #dc3545; color: white; padding: 5px 15px; border-radius: 20px; font-weight: 600;">
                            <i class="fas fa-times-circle"></i> GAGAL SELEKSI (Skor:
                            {{ number_format($rataRata, 1) }})
                        </span>
                    @endif

                @else
                    {{-- Logika Default Jika Belum Ada Nilai --}}
                    <span class="status-badge status-{{ str_replace([' ', '_'], '-', strtolower($status_pendaftaran)) }}">
                        {{ ucwords(str_replace('_', ' ', $status_pendaftaran)) }}
                    </span>
                @endif
            </div>

            <!-- <section class="info-data-grid-peserta">
                                {{-- Bagian Jadwal Detail --}}
                                <div class="info-box blue-info-box-peserta">
                                            <h3><i class="fas fa-clock"></i> Informasi Jadwal Detail</h3>
                                            <ul>
                                                <li>
                                                    <p>Tanggal Seleksi Lapangan</p>
                                                    <strong>
                                                        {{ isset($settings['tgl_seleksi']) ? \Carbon\Carbon::parse($settings['tgl_seleksi'])->translatedFormat('d F Y') : '10 Desember 2025' }}
                                                    </strong>
                                                </li>
                                                <li>
                                                    <p>Lokasi Seleksi</p>
                                                    <strong>{{ $settings['lokasi_seleksi'] ?? 'Stadion Gajah Mada' }}</strong>
                                                </li>
                                            </ul>
                                        </div>

                                {{-- Bagian Persiapan --}}
                                <div class="info-box yellow-info-box-peserta">
                                    <h3><i class="fas fa-exclamation-triangle"></i> Persiapan Mendatang</h3>
                                    <ul>
                                        <li>
                                            <p>Perlengkapan</p>
                                            <strong>{{ $settings['perlengkapan'] ?? 'Sepatu bola, jersey, minum' }}</strong>
                                        </li>
                                        <li>
                                            <p>Shin Guard</p>
                                            <strong>{{ $settings['info_shinguard'] ?? '(Pelindung tulang kering) wajib dibawa' }}</strong>
                                        </li>
                                        <li>
                                            <p>Dokumen</p>
                                            <strong>{{ $settings['info_dokumen'] ?? 'Membawa salinan SK Sehat' }}</strong>
                                        </li>
                                    </ul>
                                    <div class="catatan-khusus">
                                        {{ $settings['catatan_registrasi'] ?? 'Datang 30 menit sebelum jadwal untuk registrasi ulang.' }}
                                    </div>
                                </div>
                            </section> -->

            <section class="section-card data-diri-preview">
                <h2><i class="fas fa-user-circle"></i> Kartu Data Seleksi</h2>

                <div class="data-preview-grid">
                    <div class="photo-container">
                        {{-- Menggunakan path foto dari DB --}}
                        <img src="{{ asset('storage/' . $pendaftar->path_foto ?? 'assets/images/placeholder_profile.png') }}"
                            alt="Foto Peserta">
                    </div>
                    <div class="detail-container">
                        <p><strong>Nama Lengkap:</strong> {{ $pendaftar->nama_lengkap ?? '-' }}</p>
                        <p><strong>NIM:</strong> {{ $pendaftar->nim ?? '-' }}</p>
                        <p><strong>Posisi Pilihan:</strong> {{ $pendaftar->posisi_pilihan ?? '-' }}</p>
                        <p><strong>Program Studi:</strong> {{ $pendaftar->prodi ?? '-' }}</p>
                        <p><strong>Tanggal Lahir:</strong>
                            {{ $pendaftar->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->tgl_lahir)->isoFormat('DD MMMM YYYY') : '-' }}
                        </p>
                        <p class="catatan-penting">Silakan tunggu konfirmasi lanjut terkait status Anda di atas.</p>
                    </div>
                </div>

                <div class="action-buttons">
                    {{-- Tombol Edit mengarah ke form_pendaftaran --}}
                    <a href="{{ route('pendaftar.dashboard', ['page' => 'form_pendaftaran']) }}"
                        class="btn btn-secondary-peserta"><i class="fas fa-edit"></i> Edit Data</a>
                    <a href="{{ route('pendaftar.cetak_pdf') }}" class="btn btn-primary-peserta"><i
                            class="fas fa-file-pdf"></i> Cetak PDF</a>
                </div>
            </section>

            <section class="catatan-akhir">
                {{-- Bagian Persiapan --}}
                <div class="info-box yellow-info-box-peserta">
                    <h3><i class="fas fa-exclamation-triangle"></i> Persiapan Mendatang</h3>
                    <ul>
                        <li>
                            <p>Perlengkapan</p>
                            <strong>{{ $settings['perlengkapan'] ?? 'Sepatu bola, jersey, minum' }}</strong>
                        </li>
                        <li>
                            <p>Shin Guard</p>
                            <strong>{{ $settings['info_shinguard'] ?? '(Pelindung tulang kering) wajib dibawa' }}</strong>
                        </li>
                        <li>
                            <p>Dokumen</p>
                            <strong>{{ $settings['info_dokumen'] ?? 'Membawa salinan SK Sehat' }}</strong>
                        </li>
                    </ul>
                    <div class="catatan-khusus">
                        {{ $settings['catatan_registrasi'] ?? 'Datang 30 menit sebelum jadwal untuk registrasi ulang.' }}
                    </div>
                </div>
                <h3>Catatan Penting:</h3>
                <ul>
                    <li>Harap datang 30 menit sebelum jadwal untuk registrasi ulang.</li>
                    <li>Wajib mengenakan pakaian olahraga yang proper.</li>
                    <li>Peserta yang terlambat lebih dari 15 menit dianggap gugur.</li>
                </ul>
            </section>

        @else
            {{-- Halaman 404 sederhana --}}
            <div class="section-card">
                <h2>404 Halaman Tidak Ditemukan</h2>
                <p>Konten yang Anda cari tidak tersedia. Silakan kembali ke <a
                        href="{{ route('pendaftar.dashboard') }}">Dashboard</a>.</p>
            </div>
        @endif

    </main>

    <footer class="peserta-footer">
        {{-- ... Footer content remains the same ... --}}
        <div class="footer-content container">
            <div class="footer-col">
                <h3>UKM Sepak Bola</h3>
                <p>Pengembangan bakat dan keterampilan bagi mahasiswa UAD yang berpotensi di bidang sepak bola.</p>
            </div>
            <div class="footer-col">
                <h3>Menu</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="{{ route('register') }}">Pendaftaran</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Kontak</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                    <li><i class="fas fa-envelope"></i> ukmbola@uad.ac.id</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 UKM Sepak Bola Universitas Ahmad Dahlan. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>