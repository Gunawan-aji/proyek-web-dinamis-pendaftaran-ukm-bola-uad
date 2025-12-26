<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // Import facade PDF

class PendaftarDashboardController extends Controller
{
    public function cetakPdf()
    {
        $pendaftar = Auth::guard('peserta')->user();

        // Pastikan data pendaftar ada
        if (!$pendaftar) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Menyiapkan data untuk dikirim ke view PDF
        $data = [
            'pendaftar' => $pendaftar,
            'title' => 'Kartu Data Seleksi - ' . $pendaftar->nama_lengkap,
            'tanggal' => date('d/m/Y')
        ];

        // Mengarahkan ke file blade khusus untuk tampilan PDF
        $pdf = Pdf::loadView('admin.cetak_pdf', $data);

        // Mengunduh file dengan nama tertentu
        return $pdf->download('Kartu_Seleksi_' . $pendaftar->nim . '.pdf');
    }


    public function __construct()
    {
        $this->middleware('auth:peserta');
    }

    /**
     * Menampilkan halaman dashboard berdasarkan parameter page.
     */
    public function index(Request $request, $page = 'dashboard')
    {
        // 1. Ambil data peserta yang sedang login
        $pendaftar = Auth::guard('peserta')->user();
        $status_pendaftaran = $pendaftar->status_pendaftaran ?? 'belum_daftar';

        // 2. Ambil data pengaturan seleksi dari database (Jadwal, Lokasi, dll)
        // Pluck akan mengubahnya menjadi array ['key' => 'value']
        $settings = \App\Models\Pengaturan::pluck('value', 'key');

        // 3. Tentukan Judul Halaman berdasarkan parameter page
        $title = "Dashboard Peserta";
        if ($page == 'data_diri') {
            $title = "Data Diri & Status";
        } elseif ($page == 'form_pendaftaran') {
            $title = "Formulir Pendaftaran";
        }

        // 4. Kirim SEMUA variabel ke dalam satu view saja
        return view('admin.index', compact(
            'pendaftar',
            'page',
            'settings',
            'title',
            'status_pendaftaran'
        ));
    }

    /**
     * Menyimpan data dari Formulir Pendaftaran ke Database.
     */
    public function store(Request $request)
    {
        // Coba pakai nim langsung dari user yang login
        $pendaftar = \App\Models\Pendaftar::where('nim', auth()->user()->username)->first();

        // Tambahkan pengaman ini biar gak error merah lagi kalau data gak ketemu
        if (!$pendaftar) {
            return redirect()->back()->with('error', 'Data profil pendaftar belum ada di database!');
        }

        // 2. Logika Upload Berkas (Inilah yang bikin DB nggak NULL lagi)
        if ($request->hasFile('path_foto')) {
            $pendaftar->path_foto = $request->file('path_foto')->store('pendaftar/foto', 'public');
        }

        if ($request->hasFile('path_ktm')) {
            $pendaftar->path_ktm = $request->file('path_ktm')->store('pendaftar/ktm', 'public');
        }

        if ($request->hasFile('path_sk_sehat')) {
            $pendaftar->path_sk_sehat = $request->file('path_sk_sehat')->store('pendaftar/sk_sehat', 'public');
        }

        if ($request->hasFile('path_sertifikat')) {
            $pendaftar->path_sertifikat = $request->file('path_sertifikat')->store('pendaftar/sertifikat', 'public');
        }

        // 3. Simpan data teks dari form
        $pendaftar->nama_lengkap = $request->nama_lengkap;
        $pendaftar->no_telepon = $request->no_telepon;
        $pendaftar->prodi = $request->prodi;
        $pendaftar->semester_saat_ini = $request->semester_saat_ini;
        $pendaftar->tgl_lahir = $request->tgl_lahir;
        $pendaftar->tinggi_badan_cm = $request->tinggi_badan_cm;
        $pendaftar->berat_badan_kg = $request->berat_badan_kg;
        $pendaftar->posisi_pilihan = $request->posisi_pilihan;
        $pendaftar->kaki_dominan = $request->kaki_dominan;
        $pendaftar->riwayat_cedera = $request->riwayat_cedera;

        // Set status agar muncul di dashboard admin
        $pendaftar->status_pendaftaran = 'menunggu_verifikasi';

        $request->validate([
            'path_foto' => 'image|max:2048',
            'path_ktm' => 'mimes:jpg,jpeg,png,pdf|max:2048',
            'path_sk_sehat' => 'mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pendaftar->save();

        return redirect()->route('pendaftar.dashboard', ['page' => 'data_diri'])
            ->with('success', 'Data pendaftaran dan berkas berhasil disimpan!');
    }
}