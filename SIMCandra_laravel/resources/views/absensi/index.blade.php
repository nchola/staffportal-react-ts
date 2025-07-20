@extends('layout.index')

@section('title', 'Data Presensi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Data Presensi</h6>
                    <div class="d-flex non-printable">
                        {{-- Tombol Tambah (Akses: HRD, Karyawan) --}}
                        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Karyawan']))
                            <a href="{{ route('absensi.create') }}" class="btn btn-success text-white me-3">
                                <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Data Presensi</a>
                        @endif
                        {{-- Tombol Cetak (Akses: HRD) --}}
                        @if(Auth::check() && Auth::user()->role === 'HRD')
                            <a href="#" class="btn btn-info text-white me-3" onclick="window.print(); return false;"><i class="material-symbols-rounded align-middle me-1">print</i> Cetak</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <div class="row">
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('absensi.index') }}" class="mb-2 d-flex gap-2 align-items-center position-relative non-printable" autocomplete="off" id="absensi-search-form">
                            <div class="input-group input-group-outline flex-grow-1">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="q"
                                    value="{{ request('q') }}"
                                    placeholder="Cari NIP/Nama/Departemen"
                                    onfocus="focused(this)"
                                    onfocusout="defocused(this)"
                                >
                            </div>
                            <div style="position: relative;">
                                <button type="button" class="btn btn-outline-secondary btn-icon" id="calendar-btn" title="Filter Tanggal">
                                    <span class="material-symbols-rounded">calendar_month</span>
                                </button>
                                <input type="date" name="tanggal" id="calendar-input"
                                    value="{{ request('tanggal') }}"
                                    style="position: absolute; left: 0; top: 0; width: 45px; height: 45image.pngpx; opacity: 0; cursor: pointer; z-index: 2;">
                            </div>
                            <button type="submit" class="btn btn-primary btn-icon" title="Cari">
                                <span class="material-symbols-rounded">search</span>
                            </button>
                            @if(request('q') || request('tanggal'))
                                <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary btn-icon" title="Reset">
                                    <span class="material-symbols-rounded">close</span>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="absensiTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pegawai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Masuk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Foto Masuk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Keluar</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Foto Keluar</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Surat Dokter</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                                @php $isKaryawan = Auth::user() && Auth::user()->role === 'Karyawan'; @endphp
                                @unless($isKaryawan)
                                    <th class="text-secondary opacity-7 non-printable">Aksi</th>
                                @endunless
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absensis as $absensi)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $absensi->pegawai->nama_lengkap ?? 'N/A' }}</h6>
                                            <p class="text-xs text-secondary mb-0">NIP: {{ $absensi->pegawai->nip ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $absensi->tanggal }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $absensi->jam_masuk ?? '-' }}</span></td>
                                <td>
                                    @if($absensi->foto_masuk)
                                        <img src="{{ asset('storage/' . $absensi->foto_masuk) }}" alt="Foto Masuk" style="max-width: 60px; max-height: 60px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $absensi->jam_keluar ?? '-' }}</span></td>
                                <td>
                                    @if($absensi->foto_keluar)
                                        <img src="{{ asset('storage/' . $absensi->foto_keluar) }}" alt="Foto Keluar" style="max-width: 60px; max-height: 60px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        switch($absensi->status) {
                                            case 'Hadir': $statusClass = 'success'; break;
                                            case 'Terlambat': $statusClass = 'warning'; break;
                                            case 'Izin': $statusClass = 'info'; break;
                                            case 'Sakit': $statusClass = 'danger'; break;
                                        }
                                    @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $statusClass }}">{{ $absensi->status }}</span>
                                </td>
                                <td>
                                    @if($absensi->status === 'Sakit' && $absensi->surat_keterangan_dokter)
                                        <a href="{{ asset('storage/' . $absensi->surat_keterangan_dokter) }}" target="_blank" class="btn btn-sm btn-info">Lihat Surat</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $absensi->keterangan ?? '-' }}</span></td>
                                @unless($isKaryawan)
                                    <td class="align-middle non-printable">
                                        {{-- Tombol Lihat (Akses: HRD, Kepala Unit, Karyawan) --}}
                                        @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
                                            <a href="{{ route('absensi.show', $absensi->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Lihat presensi">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">visibility</i>
                                            </a>
                                        @endif

                                        {{-- Tombol Edit (Akses: HRD)
                                        @if(Auth::user()->role === 'HRD')
                                            <a href="{{ route('absensi.edit', $absensi->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Edit presensi">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                            </a>
                                        @endif --}}
                                        
                                        {{-- Form Hapus (Akses: HRD) --}}
                                        @if(Auth::user()->role === 'HRD')
                                            <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-gradient px-2 py-1 mb-0" onclick="return confirm('Anda yakin ingin menghapus data presensi ini?')" data-toggle="tooltip" data-original-title="Hapus presensi">
                                                    <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endunless
                            </tr>
                            @empty
                            <tr>
                                {{-- Sesuaikan colspan tergantung apakah kolom aksi muncul atau tidak --}}
                                <td colspan="9" class="text-center">Tidak ada data presensi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS untuk print --}}
<style>
    @media print {
        /* Sembunyikan elemen non-cetak */
        .non-printable,
        .sidenav,
        .navbar,
        .card-header .bg-gradient-dark { /* Sembunyikan container gradient */
            display: none !important;
        }
        /* Sesuaikan tampilan tabel untuk print */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Hapus margin/padding yang mengganggu */
        body {
            margin: 0; /* Hapus margin body */
            padding: 0; /* Hapus padding body */
        }
        .card, .row, .col-12 {
            box-shadow: none !important; /* Hapus shadow/border card */
            margin: 0 !important;
            padding: 0 !important;
        }
        .table-responsive {
            overflow: visible !important; /* Pastikan tabel penuh terlihat */
        }
    }
</style>

@endsection

@section('scripts')
<script>
    document.getElementById('calendar-btn').addEventListener('click', function() {
        document.getElementById('calendar-input').focus();
    });
    document.getElementById('calendar-input').addEventListener('change', function() {
        document.getElementById('absensi-search-form').submit();
    });
</script>
@endsection 