{{-- resources/views/admin/peserta_detail.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta - {{ $peserta->nama_lengkap }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body style="background: #f4f7f6; font-family: 'Poppins', sans-serif; padding: 40px;">

    <div
        style="max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 15px;">
            <h2 style="margin: 0; color: #333;">Detail Profil Peserta</h2>
            <a href="{{ route('admin.dashboard', ['page' => 'peserta']) }}"
                style="text-decoration: none; color: #666; font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 30px;">
            <div class="foto-section">
                @if($peserta->path_foto)
                    <img src="{{ asset('storage/' . $peserta->path_foto) }}" alt="Foto Peserta"
                        style="width: 100%; border-radius: 10px; border: 3px solid #0056b3;">
                @else
                    <div
                        style="width: 100%; height: 250px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user fa-5x" style="color: #bbb;"></i>
                    </div>
                @endif
            </div>

            <div class="info-section">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 10px 0; color: #888; width: 150px;">NIM</td>
                        <td style="padding: 10px 0; font-weight: 700; color: #333;">{{ $peserta->nim }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 10px 0; color: #888;">Nama Lengkap</td>
                        <td style="padding: 10px 0; font-weight: 700; color: #333;">{{ $peserta->nama_lengkap }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 10px 0; color: #888;">Program Studi</td>
                        <td style="padding: 10px 0; font-weight: 700; color: #333;">{{ $peserta->prodi }}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 10px 0; color: #888;">Posisi Pilihan</td>
                        <td style="padding: 10px 0;">
                            <span
                                style="background: #0056b3; color: white; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                {{ $peserta->posisi_pilihan }}
                            </span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 10px 0; color: #888;">Status Saat Ini</td>
                        <td style="padding: 10px 0; font-weight: 700;">
                            @if($peserta->status_pendaftaran == 'lolos_berkas')
                                <span style="color: #28a745;"><i class="fas fa-file-signature"></i> LOLOS BERKAS</span>
                            @elseif($peserta->status_pendaftaran == 'tidak_lolos_berkas')
                                <span style="color: #dc3545;"><i class="fas fa-file-excel"></i> TIDAK LOLOS BERKAS</span>
                            @elseif($peserta->penilaian)
                                {{-- Logika penilaian Anda yang sudah ada --}}
                                @php $rataRata = $peserta->penilaian->nilai_rata_rata; @endphp
                                @if($rataRata >= 65)
                                    <span style="color: #28a745;"><i class="fas fa-check-circle"></i> LOLOS ADMIN</span>
                                @else
                                    <span style="color: #dc3545;"><i class="fas fa-times-circle"></i> GAGAL ADMIN</span>
                                @endif
                            @else
                                <span style="color: #ffc107;"><i class="fas fa-hourglass-half"></i>
                                    {{ ucwords(str_replace('_', ' ', $peserta->status_pendaftaran)) }}</span>
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- Bagian Aksi Admin untuk Berkas --}}
                <div
                    style="margin-top: 30px; background: #fff; border: 1px solid #e3e6f0; border-radius: 10px; overflow: hidden;">
                    <div style="background: #f8f9fc; padding: 15px 20px; border-bottom: 1px solid #e3e6f0;">
                        <h3 style="margin: 0; color: #4e73df; font-size: 16px;"><i class="fas fa-file-alt"></i> Panel
                            Koreksi Berkas</h3>
                    </div>

                    <div style="padding: 20px;">
                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 25px;">

                            <div style="text-align: center; border: 1px solid #eee; padding: 15px; border-radius: 8px;">
                                <p style="font-weight: 600; font-size: 14px; margin-bottom: 10px; color: #555;">Kartu
                                    Tanda Mahasiswa</p>
                                <div
                                    style="height: 120px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                    <i class="fas fa-id-card fa-3x" style="color: #ccc;"></i>
                                </div>
                                <a href="{{ asset('storage/' . $peserta->path_ktm) }}" target="_blank"
                                    style="display: block; background: #4e73df; color: white; text-decoration: none; padding: 8px; border-radius: 5px; font-size: 12px; transition: 0.3s;">
                                    <i class="fas fa-search-plus"></i> Periksa KTM
                                </a>
                            </div>

                            <div style="text-align: center; border: 1px solid #eee; padding: 15px; border-radius: 8px;">
                                <p style="font-weight: 600; font-size: 14px; margin-bottom: 10px; color: #555;">SK Sehat
                                    / Medis</p>
                                <div
                                    style="height: 120px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                    <i class="fas fa-file-medical fa-3x" style="color: #ccc;"></i>
                                </div>

                                @if(!empty($peserta->path_sk_sehat))
                                    <a href="{{ asset('storage/' . $peserta->path_sk_sehat) }}" target="_blank"
                                        style="display: block; background: #4e73df; color: white; text-decoration: none; padding: 8px; border-radius: 5px; font-size: 12px;">
                                        <i class="fas fa-search-plus"></i> Periksa SK Sehat
                                    </a>
                                @else
                                    <span style="color: #dc3545; font-size: 11px; font-style: italic;">Berkas tidak
                                        tersedia</span>
                                @endif
                            </div>

                            @if($peserta->path_sertifikat)
                                <div style="text-align: center; border: 1px solid #eee; padding: 15px; border-radius: 8px;">
                                    <p style="font-weight: 600; font-size: 14px; margin-bottom: 10px; color: #555;">
                                        Sertifikat Prestasi</p>
                                    <div
                                        style="height: 120px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                        <i class="fas fa-award fa-3x" style="color: #ccc;"></i>
                                    </div>
                                    <a href="{{ asset('storage/' . $peserta->path_sertifikat) }}" target="_blank"
                                        style="display: block; background: #4e73df; color: white; text-decoration: none; padding: 8px; border-radius: 5px; font-size: 12px; transition: 0.3s;">
                                        <i class="fas fa-search-plus"></i> Periksa Sertifikat
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div style="border-top: 1px dashed #ccc; padding-top: 20px; text-align: center;">
                            <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Apakah semua berkas sudah
                                sesuai dan valid?</p>
                            <div style="display: flex; justify-content: center; gap: 15px;">
                                <form action="{{ route('admin.peserta.updateStatus', $peserta->id_pendaftar) }}"
                                    method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="lolos_berkas">
                                    <button type="submit"
                                        style="background: #1cc88a; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-weight: 700; box-shadow: 0 4px 6px rgba(28, 200, 138, 0.2);">
                                        <i class="fas fa-check-circle"></i> TERIMA & LOLOSKAN BERKAS
                                    </button>
                                </form>

                                <form action="{{ route('admin.peserta.updateStatus', $peserta->id_pendaftar) }}"
                                    method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="tidak_lolos_berkas">
                                    <button type="submit"
                                        style="background: #e74a3b; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-weight: 700; box-shadow: 0 4px 6px rgba(231, 74, 59, 0.2);">
                                        <i class="fas fa-times-circle"></i> TOLAK BERKAS
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>