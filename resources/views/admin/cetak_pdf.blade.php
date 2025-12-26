<!DOCTYPE html>
<html>
<head>
    <title>Kartu Seleksi</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .content { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 8px; vertical-align: top; }
        .photo { width: 150px; border: 1px solid #ddd;}
    </style>
</head>
<body>
    <div class="header">
        <h2>UKM SEPAK BOLA UAD</h2>
        <p>Kartu Bukti Pendaftaran Seleksi Pemain</p>
    </div>

    <div class="content">
        <table>
            <tr>
                <td width="30%">
                    @if($pendaftar->path_foto)
                        <img src="{{ public_path('storage/' . $pendaftar->path_foto) }}" class="photo">
                    @else
                        <p style="border: 1px solid #ccc; padding: 50px;">Tanpa Foto</p>
                    @endif
                </td>
                <td>
                    <table>
                        <tr><td><strong>NIM</strong></td><td>: {{ $pendaftar->nim }}</td></tr>
                        <tr><td><strong>Nama</strong></td><td>: {{ $pendaftar->nama_lengkap }}</td></tr>
                        <tr><td><strong>Prodi</strong></td><td>: {{ $pendaftar->prodi }}</td></tr>
                        <tr><td><strong>Posisi</strong></td><td>: {{ $pendaftar->posisi_pilihan }}</td></tr>
                        <tr><td><strong>Status</strong></td><td>: {{ ucfirst($pendaftar->status_pendaftaran) }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>