<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - UKM Sepak Bola UAD</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="login-body">
    <div class="login-wrapper">
        <a href="{{ route('home') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="login-container">
            <div class="login-icon-circle">
                <i class="fas fa-sign-in-alt"></i>
            </div>

            <h2 class="login-title">Login</h2>
            <p class="login-subtitle">Masuk ke akun Anda untuk melanjutkan</p>

            {{-- Menampilkan Notifikasi Error (jika ada kesalahan autentikasi) --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                    Username atau Password tidak sesuai.
                </div>
            @endif

            {{-- Menggunakan route('login') yang menunjuk ke AuthController@login --}}
            <form action="{{ route('login') }}" method="POST" class="login-form">

                {{-- TOKEN KEAMANAN WAJIB LARAVEL --}}
                @csrf

                <div class="form-group">
                    {{-- Menggunakan 'username' di name input, karena DB_USER di AuthController adalah 'username'
                    (nim/username admin) --}}
                    <label for="username">Username / NIM</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username/NIM"
                        value="{{ old('username') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>

                <button type="submit" class="btn-submit">Login</button>
            </form>

            <p class="register-prompt">
                {{-- Menggunakan route('register') yang menunjuk ke PendaftaranController@showRegistrationForm --}}
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>

</html>