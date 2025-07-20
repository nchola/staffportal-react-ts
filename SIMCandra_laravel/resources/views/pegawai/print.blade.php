<!DOCTYPE html>
<html>
<head>
    <title>Data Pegawai</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20mm;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Data Pegawai</h1>
    <table>
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Divisi</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pegawai as $p)
            <tr>
                <td>
                    <div>
                        <strong>{{ $p->nama_lengkap }}</strong><br>
                        <span style="font-size: 11px; color: #888;">NIP: {{ $p->nip }}</span>
                    </div>
                </td>
                <td>{{ $p->departemen->nama ?? $p->divisi ?? '-' }}</td>
                <td>{{ $p->jabatan->nama ?? $p->jabatan ?? '-' }}</td>
                <td>{{ $p->status ?? '-' }}</td>
                <td>{{ $p->tanggal_bergabung ? \Carbon\Carbon::parse($p->tanggal_bergabung)->format('d-m-Y') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pegawai.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html> 