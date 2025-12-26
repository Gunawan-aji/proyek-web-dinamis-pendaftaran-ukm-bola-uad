<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PendaftarDashboardController;
use App\Exports\PendaftarExport; // Pastikan ini ada agar class Excel dikenali
use Maatwebsite\Excel\Facades\Excel;

/* -------------------- RUTE AKSES UMUM -------------------- */

Route::get('/', function () {
    return view('home');
})->name('home');

// LOGIN & REGISTER (Hanya untuk yang belum login)
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'createAccount'])->name('account.store');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/* -------------------- RUTE PESERTA (GUARD: PESERTA) -------------------- */

Route::middleware(['auth:peserta'])->prefix('pendaftar')->group(function () {
    // Dashboard dinamis
    Route::get('/dashboard/{page?}', [PendaftarDashboardController::class, 'index'])
        ->name('pendaftar.dashboard');

    // Proses simpan form pendaftaran
    Route::post('/store', [PendaftarDashboardController::class, 'store'])
        ->name('pendaftar.store_ukm');

    Route::get('/form-ukm', [PendaftaranController::class, 'showFullRegistrationForm'])
        ->name('pendaftar.old_form');

    // Rute cetak PDF
    Route::get('/cetak-pdf', [PendaftarDashboardController::class, 'cetakPdf'])
        ->name('pendaftar.cetak_pdf');
});


/* -------------------- RUTE ADMIN (GUARD: ADMIN) -------------------- */

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    // PERBAIKAN: Gunakan rute relatif terhadap prefix 'admin'
    Route::get('/export-pendaftar', function () {
        // Nama file dinamis dengan jam-menit-detik agar real-time
        $fileName = 'data_pendaftar_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new PendaftarExport, $fileName);
    })->name('admin.export_pendaftar');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Rute untuk melihat detail
    Route::get('/peserta/{id}', [AdminDashboardController::class, 'show'])->name('admin.peserta.show');

    // Rute untuk menghapus peserta
    Route::delete('/peserta/{id}', [AdminDashboardController::class, 'destroy'])->name('admin.peserta.destroy');

    // Rute simpan penilaian (Hapus prefix /admin karena sudah ada di group)
    Route::post('/penilaian/store', [AdminDashboardController::class, 'storePenilaian'])->name('admin.penilaian.store');

    // Route terima berkas
    Route::patch('/peserta/{id}/update-status', [AdminDashboardController::class, 'updateStatus'])->name('admin.peserta.updateStatus');

    Route::post('/admin/pengaturan/update', [AdminDashboardController::class, 'updateSettings'])
        ->name('admin.pengaturan.update');
});