<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter halaman dari URL (?page=...)
        $page = $request->query('page', 'dashboard');

        // 1. DATA PENGATURAN (Penting agar form setting terisi data asli)
        $settings = \App\Models\Pengaturan::pluck('value', 'key');

        // 2. LOGIKA PENCARIAN PESERTA
        $nim_search = $request->query('nim');
        $peserta_data = null;
        if ($nim_search) {
            $peserta_data = Pendaftar::where('nim', $nim_search)->first();
        }

        // 3. AMBIL DATA UNTUK STATISTIK (Eager Loading)
        $dataStatistik = Pendaftar::with('penilaian')->get();
        $total = $dataStatistik->count();

        // 4. HITUNG STATISTIK UTAMA (Real-time)
        $stats = [
            'total' => $total,
            'diterima' => $dataStatistik->filter(function ($p) {
                return optional($p->penilaian)->nilai_rata_rata >= 65;
            })->count(),
            'dinilai' => $dataStatistik->whereNotNull('penilaian')->count(),
            'menunggu' => $dataStatistik->whereNull('penilaian')->count(),
        ];

        // 5. HITUNG PERSENTASE
        $percentages = [
            'diterima' => $total > 0 ? round(($stats['diterima'] / $total) * 100, 1) : 0,
            'dinilai' => $total > 0 ? round(($stats['dinilai'] / $total) * 100, 1) : 0,
            'menunggu' => $total > 0 ? round(($stats['menunggu'] / $total) * 100, 1) : 0,
        ];

        // 6. HITUNG RATA-RATA USIA
        $rataRataUsia = Pendaftar::whereNotNull('tgl_lahir')
            ->selectRaw('AVG(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE())) as rata_usia')
            ->first()->rata_usia ?? 0;

        // 7. DATA UNTUK TABEL (Pagination dipisah agar tidak bentrok dengan statistik)
        $pendaftarTerbaru = Pendaftar::latest()->take(5)->get();
        $allPendaftar = Pendaftar::latest()->paginate(10)->withQueryString();

        // 8. INFO SELEKSI (Sekarang mengambil dari database, bukan manual lagi)
        $infoSeleksi = [
            'lokasi' => $settings['nama_lokasi_seleksi'] ?? 'Belum Diatur',
            'jadwal' => $settings['tgl_seleksi_lapangan'] ?? 'Belum Diatur',
            'kelulusan' => $percentages['diterima']
        ];

        // KIRIM SEMUA KE VIEW
        return view('admin.dashboard', compact(
            'page',
            'stats',
            'percentages',
            'rataRataUsia',
            'pendaftarTerbaru',
            'allPendaftar',
            'infoSeleksi',
            'peserta_data',
            'settings'
        ));
    }
    public function show($id)
    {
        $peserta = Pendaftar::findOrFail($id);
        return view('admin.peserta_detail', compact('peserta'));
    }

    public function destroy($id)
    {
        $peserta = Pendaftar::findOrFail($id);

        // Daftar file yang harus dihapus dari storage
        $files = [$peserta->path_foto, $peserta->path_ktm, $peserta->path_sk_sehat, $peserta->path_sertifikat];

        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $peserta->delete();

        return redirect()->back()->with('success', 'Data peserta dan dokumen terkait berhasil dihapus.');
    }

    public function storePenilaian(Request $request)
    {
        $request->validate([
            'id_pendaftar' => 'required|exists:pendaftar,id_pendaftar',
            'skor_fisik' => 'required|numeric|min:0|max:100',
            'skor_teknik' => 'required|numeric|min:0|max:100',
            'skor_visi' => 'required|numeric|min:0|max:100',
            'skor_kerjasama' => 'required|numeric|min:0|max:100',
        ]);

        $rata_rata = ($request->skor_fisik + $request->skor_teknik + $request->skor_visi + $request->skor_kerjasama) / 4;

        // UpdateOrCreate memastikan tidak ada duplikasi data penilaian untuk satu peserta
        Penilaian::updateOrCreate(
            ['id_pendaftar' => $request->id_pendaftar],
            [
                'skor_fisik' => $request->skor_fisik,
                'skor_teknik' => $request->skor_teknik,
                'skor_visi' => $request->skor_visi,
                'skor_kerjasama' => $request->skor_kerjasama,
                'nilai_rata_rata' => $rata_rata,
            ]
        );

        // Update status pendaftaran
        Pendaftar::where('id_pendaftar', $request->id_pendaftar)
            ->update(['status_pendaftaran' => 'lolos_admin']);

        return redirect()->route('admin.dashboard', ['page' => 'penilaian'])
            ->with('success', 'Penilaian berhasil disimpan untuk peserta ini.');
    }

    public function updateStatus(Request $request, $id)
    {
        $peserta = \App\Models\Pendaftar::findOrFail($id);

        // Validasi input status
        $statusInput = $request->input('status');

        // Update status di database
        $peserta->status_pendaftaran = $statusInput;
        $peserta->save();

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui menjadi ' . str_replace('_', ' ', $statusInput));
    }

    public function updateSettings(Request $request)
    {
        // Ambil semua data dari form kecuali token Laravel
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // updateOrCreate: kalau key sudah ada diupdate, kalau belum dibuat baru
            \App\Models\Pengaturan::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Informasi pendaftaran berhasil diperbarui!');
    }
}