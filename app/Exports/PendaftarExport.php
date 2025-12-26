<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class PendaftarExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        // Menggunakan with('penilaian') agar data nilai ikut terambil (Eager Loading)
        return Pendaftar::query()->with('penilaian')->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Lengkap',
            'Program Studi',
            'No. Telepon',
            'Posisi Pilihan',
            'Kaki Dominan',
            'Tinggi (cm)',
            'Berat (kg)',
            'Nilai Rata-rata',
            'Status Seleksi',
            'Tanggal Pendaftaran',
        ];
    }

    public function map($pendaftar): array
    {
        // Logika penentuan status Lolos/Gagal berdasarkan nilai rata-rata
        $rataRata = $pendaftar->penilaian ? $pendaftar->penilaian->nilai_rata_rata : null;
        $statusAkhir = '-';

        if ($rataRata !== null) {
            $statusAkhir = ($rataRata >= 65) ? 'LOLOS' : 'GAGAL';
        } else {
            // Jika belum dinilai, pakai status pendaftaran (e.g., Lolos Berkas / Menunggu)
            $statusAkhir = ucwords(str_replace('_', ' ', $pendaftar->status_pendaftaran));
        }

        return [
            $pendaftar->nim,
            $pendaftar->nama_lengkap,
            $pendaftar->prodi,
            $pendaftar->no_telepon,
            $pendaftar->posisi_pilihan,
            ucfirst($pendaftar->kaki_dominan),
            $pendaftar->tinggi_badan_cm,
            $pendaftar->berat_badan_kg,
            $rataRata ?? 'Belum Dinilai',
            $statusAkhir,
            $pendaftar->created_at ? $pendaftar->created_at->format('d-m-Y H:i') : '-',
        ];
    }
}