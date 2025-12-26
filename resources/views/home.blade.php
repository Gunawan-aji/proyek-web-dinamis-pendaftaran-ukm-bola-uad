<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Pendaftaran UKM Sepak Bola UAD</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>

    <header class="hero">
        <div class="navbar">
            <div class="container">
                <div class="logo">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo UAD">
                    <!-- <span>UKM Sepak Bola</span> -->
                </div>
                <nav>
                    <a href="#home">Beranda</a>
                    <a href="#tentang">Tentang Kami</a>
                    <a href="#pendaftaran">Pendaftaran</a>
                    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                </nav>
            </div>
        </div>
        <div class="hero-content">
            <h1>Sepak Bola Universitas Ahmad Dahlan</h1>
            <p>Dibuka kesempatan bagi seluruh mahasiswa/i UAD untuk bergabung menjadi bagian dari UKM Sepak Bola dan
                meraih prestasi gemilang.</p>
            <!-- <div class="banner-title">
                <h2>PIALA REKTOR UAD 2023</h2>
            </div> -->
        </div>
    </header>

    <section id="tentang" class="about-stats-section container">
        <div class="about-content">
            <h2>Sepak Bola Universitas Ahmad Dahlan</h2>
            <p>UKM Sepak Bola UAD adalah unit kegiatan mahasiswa yang berkomitmen penuh dalam pengembangan bakat dan
                peningkatan prestasi olahraga sepak bola di kancah regional maupun nasional. Kami mengedepankan
                profesionalitas, kedisiplinan, dan semangat kekeluargaan.</p>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>150 +</h3>
                    <p>Total Pendaftar</p>
                </div>
                <div class="stat-card">
                    <h3>35 +</h3>
                    <p>Anggota Aktif</p>
                </div>
                <div class="stat-card">
                    <h3>10 +</h3>
                    <p>Piala Kejuaraan</p>
                </div>
                <div class="stat-card">
                    <h3>5</h3>
                    <p>Lisensi Pelatih</p>
                </div>
            </div>
        </div>
        <div class="winner-image-container">
            <img src="{{ asset('images/images.jpeg') }}" alt="Tim Juara" class="winner-image">
        </div>
    </section>

    <section class="achievements-section container">
        <h2>Pencapaian Membanggakan</h2>
        <p>Kami telah mencetak berbagai prestasi di berbagai tingkat kompetisi.</p>
        <div class="grid-3">
            <div class="achievement-card">
                <i class="fas fa-trophy icon-lg"></i>
                <h4>LIGA TOP PREDIKSI 2023</h4>
                <p>Juara Regional, menjadi wakil UAD di Tingkat Nasional.</p>
            </div>
            <div class="achievement-card">
                <i class="fas fa-medal icon-lg"></i>
                <h4>BRONZE MEDAL</h4>
                <p>Turnamen Piala Rektor UGM, kategori Umum.</p>
            </div>
            <div class="achievement-card">
                <i class="fas fa-star icon-lg"></i>
                <h4>ALL STAR HONORABLE</h4>
                <p>5 Pemain terpilih masuk tim All Star Championship 2024.</p>
            </div>
        </div>
    </section>

    <section class="features-section light-bg">
        <div class="container">
            <h2 class="features-title">Platform Pendaftaran Modern</h2>
            <p class="features-subtitle">Sistem informasi untuk memudahkan proses rekrutmen tim UKM Sepak Bola.</p>
            <div class="grid-4 feature-grid">
                <div class="feature-card">
                    <i class="fas fa-file-alt icon-md"></i>
                    <h4>Pendaftaran Online</h4>
                    <p>Formulir pendaftaran yang dapat diakses di mana saja dan kapan saja.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-clipboard-check icon-md"></i>
                    <h4>Verifikasi Otomatis</h4>
                    <p>Sistem verifikasi data dan kelengkapan dokumen pendaftar.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-user-shield icon-md"></i>
                    <h4>Penilaian Pelatih</h4>
                    <p>Dashboard khusus bagi pelatih untuk input dan rekap nilai seleksi.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-bullhorn icon-md"></i>
                    <h4>Pengumuman Hasil</h4>
                    <p>Pengumuman kelulusan yang cepat dan terintegrasi via email/WA.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pendaftaran" class="flow-section container">
        <div class="flow-header">
            <h2>Alur Pendaftaran</h2>
            <p>Penyaringan calon pemain yang berdedikasi, bertalenta, dan profesional.</p>
        </div>
        <div class="flow-steps">
            <div class="step">
                <div class="step-circle step-1">1</div>
                <h4>Daftar Online</h4>
                <p>Mengisi formulir pendaftaran, data diri, dan mengunggah dokumen (KTM, Foto).</p>
            </div>
            <div class="flow-line"></div>
            <div class="step">
                <div class="step-circle step-2">2</div>
                <h4>Verifikasi Administrasi</h4>
                <p>Pengecekan kelengkapan data dan persetujuan untuk maju ke tahap seleksi lapangan.</p>
            </div>
            <div class="flow-line"></div>
            <div class="step">
                <div class="step-circle step-3">3</div>
                <h4>Seleksi Lapangan</h4>
                <p>Tes kemampuan teknis, fisik, dan *gameplay* di lapangan secara langsung.</p>
            </div>
        </div>

        <div class="benefits-box">
            <h4>Keuntungan Bergabung</h4>
            <div class="grid-5 benefit-grid">
                <span><i class="fas fa-check-circle"></i> Fasilitas Lengkap</span>
                <span><i class="fas fa-check-circle"></i> Pelatih Berpengalaman</span>
                <span><i class="fas fa-check-circle"></i> Kompetisi Rutin</span>
                <span><i class="fas fa-check-circle"></i> Komunitas Solid</span>
                <span><i class="fas fa-check-circle"></i> Jaringan Luas</span>
            </div>
        </div>
    </section>

    <section class="schedule-contact-section container">
        <h2 class="section-title-center">Siap Bergabung dengan Tim?</h2>
        <p class="section-subtitle-center">Kami membuka peluang untuk calon pemain berbakat pimpinan bergabung dengan
            tim sepak bola UAD.</p>

        <div class="schedule-contact-grid">
            <div class="box blue-box">
                <h4><i class="fas fa-calendar-check"></i> Jadwal Seleksi</h4>

                <div class="schedule-detail-item">
                    <span>Pendaftaran Online:</span>
                    <strong>{{ $settings['tgl_daftar_online'] ?? '1 November 2025 - 30 November 2025' }}</strong>
                </div>
                <div class="schedule-detail-item">
                    <span>Seleksi Administrasi:</span>
                    <strong>{{ $settings['tgl_verifikasi'] ?? '1 Desember 2025 - 3 Desember 2025' }}</strong>
                </div>
                <div class="schedule-detail-item">
                    <span>Pengumuman Seleksi Adm:</span>
                    <strong>{{ $settings['tgl_pengumuman_adm'] ?? '5 Desember 2025' }}</strong>
                </div>
                <div class="schedule-detail-item">
                    <span>Seleksi Lapangan:</span>
                    <strong>{{ $settings['tgl_seleksi_lapangan'] ?? '10 Desember 2025 - 12 Desember 2025' }}</strong>
                </div>
                <div class="schedule-detail-item">
                    <span>Pengumuman Akhir:</span>
                    <strong>{{ $settings['tgl_pengumuman_akhir'] ?? '20 Desember 2025' }}</strong>
                </div>
            </div>

            <div class="box yellow-box">
                <h4><i class="fas fa-map-marked-alt"></i> Lokasi Seleksi Lapangan</h4>
                <p class="contact-text">{{ $settings['nama_lokasi_seleksi'] ?? 'Stadion Sepak Bola UAD' }}</p>
                <p class="contact-address">
                    {{ $settings['alamat_lengkap_seleksi'] ?? 'Jl. Lingkar Selatan No. 12, Yogyakarta' }}
                </p>

                {{-- Link Maps bisa kamu buat dinamis juga kalau mau --}}
                <a href="{{ $settings['link_maps'] ?? '#' }}" target="_blank"
                    class="btn btn-yellow-inverse btn-map-link"
                    style="text-decoration: none; display: inline-block; text-align: center;">
                    Lihat Google Maps Lokasi Seleksi
                </a>

                <div class="contact-time">
                    <p>Waktu Pendaftaran Online:</p>
                    <div class="time-box">
                        <i class="fas fa-clock"></i> {{ $settings['jam_pendaftaran'] ?? 'Online 24 Jam' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="requirements-grid">
            <div class="requirements-col">
                <p><strong>Persyaratan Peserta:</strong></p>
                <ul>
                    @php
                        // Mengambil data dari settings, jika kosong pakai default
                        $defaultSyarat = "Mahasiswa/i Aktif UAD (Semua Prodi).,Mengisi formulir pendaftaran online.,Memiliki minat dan bakat.,Bersedia mengikuti jadwal.";
                        $syaratArray = explode(',', $settings['syarat_umum'] ?? $defaultSyarat);
                    @endphp
                    @foreach($syaratArray as $item)
                        <li><i class="fas fa-check"></i> {{ trim($item) }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="requirements-col">
                <p><strong>Dokumen yang Diperlukan:</strong></p>
                <ul>
                    @php
                        $defaultDokumen = "Scan KTM/KTP.,Pas Foto Terbaru (4x6).,Surat Keterangan Sehat.,Berkas Pendukung.";
                        $dokumenArray = explode(',', $settings['dokumen_wajib'] ?? $defaultDokumen);
                    @endphp
                    @foreach($dokumenArray as $item)
                        <li><i class="fas fa-check"></i> {{ trim($item) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <footer>
        <div class="container footer-grid">
            <div class="footer-col">
                <h4>UKM Sepak Bola UAD</h4>
                <p>Organisasi mahasiswa yang bergerak di bidang olahraga Sepak Bola. Berkomitmen mencetak pemain
                    berprestasi dan berkarakter.</p>
            </div>
            <div class="footer-col">
                <h4>Menu</h4>
                <ul>
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#pendaftaran">Alur Pendaftaran</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <p>Sekretariat: Gedung UKM UAD, Lantai 2</p>
                <p>Email: ukm.bola@uad.ac.id</p>
                <p>WA: 0812-xxxx-xxxx</p>
            </div>
        </div>
        <div class="copyright">
            <p>Platform Pendaftaran dan Seleksi UKM Sepak Bola UAD. © 2025.</p>
        </div>
    </footer>

    <script src="{{ asset('js/navbar.js') }}"></script>

</body>

</html>