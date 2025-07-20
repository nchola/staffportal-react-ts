<!DOCTYPE html>
<html>
<head>
    <title>Surat Cuti/Izin</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 80%; margin: 0 auto; }
        h1, h2 { text-align: center; margin-bottom: 20px; }
        .details p { margin-bottom: 10px; }
        .footer { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Surat Cuti/Izin</h1>

        <div class="details">
            <p><strong>Nama Karyawan:</strong> {{ $cuti->pegawai->nama ?? 'N/A' }}</p> {{-- Assuming Cuti model has a relationship to Pegawai --}}
            <p><strong>Alasan Cuti/Izin:</strong> {{ $cuti->alasan }}</p>
            <p><strong>Jenis Cuti:</strong> {{ $cuti->jenis_cuti }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $cuti->tanggal_mulai }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $cuti->tanggal_selesai }}</p>
            <p><strong>Keterangan:</strong> {{ $cuti->keterangan ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $cuti->status ?? 'Pending' }}</p>
            <p><strong>Tanggal Pengajuan:</strong> {{ $cuti->created_at->format('Y-m-d') ?? 'N/A' }}</p>
            <p><strong>Tanggal Verifikasi:</strong> {{ $cuti->tanggal_verifikasi ?? 'Belum Diverifikasi' }}</p>
        </div>

        <div class="footer">
            <p>Disetujui oleh,</p>
            <p>[Nama Kepala Unit]</p>
            <p>Tanggal: {{ $cuti->tanggal_verifikasi ?? '' }}</p>
        </div>
    </div>
</body>
</html> 