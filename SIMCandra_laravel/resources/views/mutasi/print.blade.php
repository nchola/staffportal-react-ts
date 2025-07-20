<!DOCTYPE html>
<html>
<head>
    <title>Data Promosi/Demosi</title>
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 8mm;
            }
            html, body {
                width: 100%;
                height: 100%;
            }
        }
        body { font-family: sans-serif; margin: 8mm; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 2px; text-align: left; word-break: break-word; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; margin-bottom: 20px; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    <h1>Data Promosi/Demosi</h1>
    <table>
        <thead>
            <tr>
                <th>Pegawai</th>
                <th>Jabatan Lama</th>
                <th>Jabatan Baru</th>
                <th>Departemen Lama</th>
                <th>Departemen Baru</th>
                <th>Tanggal Efektif</th>
                <th>Status</th>
                <th>Jenis Promosi/Demosi</th>
                <th>Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutasis as $mutasi)
            <tr>
                <td>
                    <div>
                        <strong>{{ $mutasi->pegawai->nama_lengkap ?? '-' }}</strong><br>
                        <span style="font-size: 11px; color: #888;">NIP: {{ $mutasi->pegawai->nip ?? '-' }}</span>
                    </div>
                </td>
                <td>{{ $mutasi->jabatanLama->nama ?? '-' }}</td>
                <td>{{ $mutasi->jabatanBaru->nama ?? '-' }}</td>
                <td>{{ $mutasi->departemenLama->nama ?? '-' }}</td>
                <td>{{ $mutasi->departemenBaru->nama ?? '-' }}</td>
                <td>{{ $mutasi->tanggal_efektif }}</td>
                <td>{{ $mutasi->status ?? '-' }}</td>
                <td>{{ ucfirst($mutasi->jenis) }}</td>
                <td>{{ $mutasi->verifikator->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data mutasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <p class="no-print">Tutup jendela ini untuk kembali.</p>
    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html> 