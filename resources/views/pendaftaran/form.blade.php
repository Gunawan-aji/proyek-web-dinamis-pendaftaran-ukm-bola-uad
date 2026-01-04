<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun - UKM Sepak Bola UAD</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="register-body">
    <div class="register-wrapper">
        {{-- Menggunakan route() untuk Kembali ke Beranda --}}
        <a href="{{ route('home') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="register-container">
            <div class="register-icon-circle">
                <i class="fas fa-shield-alt"></i>
            </div>

            <h2 class="register-title">Buat Akun</h2>
            <p class="register-subtitle">Gunakan email kampus untuk verifikasi keanggotaan</p>

            {{-- Menampilkan pesan error validasi (jika ada) --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                    Mohon periksa kembali input Anda.
                </div>
            @endif

            <form action="{{ route('account.store') }}" method="POST" class="register-form">

                {{-- TOKEN KEAMANAN WAJIB LARAVEL --}}
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap"
                            value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')<span class="error-message"
                        style="color: red;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password (Minimal 8 Karakter)</label>
                        <input type="password" id="password_input" name="password" placeholder="Minimal 8 karakter"
                            required>
                        @error('password')<span class="error-message" style="color: red;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" id="nim" name="nim" placeholder="Masukkan Nim" value="{{ old('nim') }}"
                            required>
                        @error('nim')<span class="error-message" style="color: red;">{{ $message }}</span>@enderror
                    </div>

                    {{-- Wajib bernama 'password_confirmation' --}}
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi password" required>
                    </div>

                    <div class="form-group">
                        <label for="email_kampus">Email</label>
                        <input type="email" id="email_kampus" name="email_kampus" placeholder="Masukkan Email Kampus"
                            value="{{ old('email_kampus') }}" required>
                        @error('email_kampus')<span class="error-message"
                        style="color: red;">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-submit-area">
                        <button type="submit" class="btn-submit">Daftar</button>
                    </div>
                </div>
            </form>

            <p class="login-prompt">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </div>
    </div>
</body>

</html>