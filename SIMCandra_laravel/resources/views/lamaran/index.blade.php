@extends('layout.index')

@section('title', 'Daftar Lamaran Masuk')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Lamaran Masuk</h6>
                    @if(Auth::user() && Auth::user()->role === 'Calon Karyawan')
                        <a href="{{ route('lamaran.create') }}" class="btn btn-success text-white me-3">
                            <i class="material-symbols-rounded align-middle me-1">add</i> Tambah Lamaran
                        </a>
                    @endif
                </div>
            </div>
            
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="lamaranTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pelamar</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Resume</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No. Telepon</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lowongan</th>
                                <th class="text-secondary opacity-7 non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lamarans as $lamaran)
                            <tr>
                                <td><span class="text-sm font-weight-bold">{{ $lamaran->nama_pelamar }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">
                                    @if($lamaran->resume_url)
                                        <a href="{{ $lamaran->resume_url }}" target="_blank" class="text-primary text-decoration-underline">Lihat File</a>
                                    @else
                                        -
                                    @endif
                                </span></td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        switch($lamaran->status) {
                                            case 'Diterima': $statusClass = 'success'; break;
                                            case 'Ditolak': $statusClass = 'danger'; break;
                                            case 'Diproses': $statusClass = 'warning'; break;
                                            default: $statusClass = 'secondary'; break;
                                        }
                                    @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $statusClass }}">{{ $lamaran->status ?? '-' }}</span>
                                </td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $lamaran->email }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $lamaran->no_telepon }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $lamaran->rekrutmen ? $lamaran->rekrutmen->judul : '-' }}</span></td>
                                <td class="non-printable">
                                    <a href="{{ route('lamaran.show', $lamaran->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Detail"><i class="material-symbols-rounded align-middle me-1">info</i></a>
                                    @if(Auth::user() && (Auth::user()->role === 'HRD' || (Auth::user()->role === 'Calon Karyawan' && Auth::id() == $lamaran->user_id)))
                                        <a href="{{ route('lamaran.edit', $lamaran->id) }}" class="btn btn-link text-warning text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Edit"><i class="material-symbols-rounded align-middle me-1">edit</i></a>
                                    @endif
                                    @if(Auth::user() && Auth::user()->role === 'HRD')
                                        <form action="{{ route('lamaran.destroy', $lamaran->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger text-gradient px-2 py-1 mb-0" onclick="return confirm('Yakin hapus lamaran ini?')" data-toggle="tooltip" data-original-title="Hapus"><i class="material-symbols-rounded align-middle me-1">delete</i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="material-symbols-rounded" style="font-size: 3rem;">drafts</i><br>
                                    Tidak ada lamaran masuk.
                                </td>
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
        .non-printable,
        .sidenav,
        .navbar,
        .card-header .bg-gradient-dark {
            display: none !important;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        body { margin: 0; padding: 0; }
        .card, .row, .col-12 { box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
        .table-responsive { overflow: visible !important; }
    }
    .table-hover tbody tr:hover {background-color: #f5f5f5;}
    table.table {border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;}
    table.table th, table.table td {border-bottom: 1px solid #e0e0e0;}
</style>
@endsection 