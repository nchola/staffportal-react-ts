@extends('layout.index')

@section('title', 'Daftar Pegawai')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Data Pegawai</h6>
                    <div class="d-flex non-printable">
                        {{-- Tombol Tambah (Akses: HRD) --}}
                        @if(Auth::check() && Auth::user()->role === 'HRD')
                            <a href="{{ route('pegawai.create') }}" class="btn btn-success text-white me-3 ">
                                <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Pegawai</a>
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
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('pegawai.index') }}" class="mb-2 d-flex gap-2 align-items-center position-relative non-printable" autocomplete="off" id="pegawai-search-form">
                            <div class="input-group input-group-outline flex-grow-1">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="q"
                                    value="{{ request('q') }}"
                                    placeholder="Cari NIP/Nama/Departemen"
                                    onfocus="focused(this)"
                                    onfocusout="defocused(this)"
                                ><div style="position: relative;">
                                <button type="submit" class="btn btn-primary btn-icon" title="Cari">
                                    <span class="material-symbols-rounded">search</span>
                                </button>
                                @if(request('q'))
                                    <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary btn-icon" title="Reset">
                                        <span class="material-symbols-rounded">close</span>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive p-0">
                    <table class="table table-sm align-items-center mb-0" id="pegawaiTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIP</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Lengkap</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Departemen</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jabatan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                {{-- Kolom Aksi disembunyikan saat print --}}
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $p)
                            <tr>
                                <td><span class="text-sm">{{ $p->nip }}</span></td>
                                <td><span class="text-sm font-weight-bold">{{ $p->nama_lengkap }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $p->departemen->nama ?? $p->divisi ?? '-' }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $p->jabatan->nama ?? $p->jabatan ?? '-' }}</span></td>
                                <td>
                                    @php
                                        $status = $p->status;
                                        $statusClass = 'secondary';
                                        switch($status) {
                                            case 'Pegawai Tetap':
                                            case 'Aktif': $statusClass = 'success'; break;
                                            case 'Pegawai Kontrak': $statusClass = 'primary'; break;
                                            case 'Pegawai Harian': $statusClass = 'info'; break;
                                            case 'Magang': $statusClass = 'secondary'; break;
                                            case 'Probation': $statusClass = 'warning'; break;
                                            case 'Tidak Aktif': $statusClass = 'danger'; break;
                                        }
                                    @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $statusClass }}">{{ $status }}</span>
                                </td>
                                {{-- Kolom Aksi disembunyikan saat print --}}
                                <td class="align-middle text-center non-printable">
                                    {{-- Tombol Lihat (Akses: HRD, Kepala Unit) --}}
                                    @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit']))
                                    <a href="{{ route('pegawai.show', $p->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Lihat pegawai">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">visibility</i>
                                    </a>
                                    @endif

                                    {{-- Tombol Edit (Akses: HRD) --}}
                                    @if(Auth::check() && Auth::user()->role === 'HRD')
                                    <a href="{{ route('pegawai.edit', $p->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Edit pegawai">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                    </a>
                                    @endif

                                    {{-- Form Hapus (Akses: HRD) --}}
                                    @if(Auth::check() && Auth::user()->role === 'HRD')
                                    <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data pegawai ini?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Hapus pegawai"><i class="material-symbols-rounded" style="font-size: 18px;">delete</i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
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