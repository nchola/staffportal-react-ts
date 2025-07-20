@extends('layout.index')
@section('title', 'Data Reward & Punishment')
@section('content')
@php
    $user = auth()->user();
    $isKaryawan = $user->role === 'Karyawan';
    $isKepalaUnit = $user->role === 'Kepala Unit';
    $showAksi = in_array($user->role, ['HRD', 'Kepala Unit']);
    $canVerify = in_array($user->role, ['HRD', 'Kepala Unit']);
@endphp
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Data Reward & Punishment</h6>
                    <div class="d-flex non-printable gap-2">
                        @if($showAksi && $user->role === 'HRD')
                            <a href="{{ route('rewardpunishment.create') }}" class="btn btn-success text-white me-3">
                                <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Data</a>
                        @endif
                        @if(Auth::check() && Auth::user()->role !== 'Kepala Unit')
                            <a href="#" class="btn btn-info text-white me-3" onclick="window.print(); return false;"><i class="material-symbols-rounded align-middle me-1">print</i> Cetak</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <div class="row">
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('rewardpunishment.index') }}" class="mb-2 d-flex gap-2 align-items-center position-relative non-printable" autocomplete="off" id="rewardpunishment-search-form">
                            <div class="input-group input-group-outline flex-grow-1">
                                <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Cari NIP/Nama/Jenis/Keterangan" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <div style="position: relative;">
                                <button type="button" class="btn btn-outline-secondary btn-icon" id="tanggal-btn" title="Filter Tanggal">
                                    <span class="material-symbols-rounded">calendar_month</span>
                                </button>
                                <input type="date" name="tanggal" id="tanggal-input" value="{{ request('tanggal') }}" style="position: absolute; left: 0; top: 0; width: 45px; height: 45px; opacity: 0; cursor: pointer; z-index: 2;">
                            </div>
                            <button type="submit" class="btn btn-primary btn-icon" title="Cari">
                                <span class="material-symbols-rounded">search</span>
                            </button>
                            @if(request('q') || request('tanggal'))
                                <a href="{{ route('rewardpunishment.index') }}" class="btn btn-outline-secondary btn-icon" title="Reset">
                                    <span class="material-symbols-rounded">close</span>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="rewardpunishmentTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Karyawan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Reward</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Surat</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                @if($showAksi)
                                <th class="text-secondary opacity-7 non-printable">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rewardPunishments as $item)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->karyawan->nama_lengkap ?? '-' }}</h6>
                                            <p class="text-xs text-secondary mb-0">NIP: {{ $item->karyawan->nip ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $item->jenis }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $item->keterangan }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $item->reward ? 'Rp' . number_format($item->reward, 0, ',', '.') : '-' }}</span></td>
                                <td><span class="text-xs font-weight-bold mb-0">
                                    @if($item->surat_punishment)
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $item->surat_punishment)) }}" target="_blank" class="text-primary text-decoration-underline">Lihat File</a>
                                    @else
                                        -
                                    @endif
                                </span></td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        switch($item->status) {
                                            case 'Diterima': $statusClass = 'success'; break;
                                            case 'Ditolak': $statusClass = 'danger'; break;
                                            case 'Menunggu': $statusClass = 'warning'; break;
                                        }
                                    @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $statusClass }}">{{ $item->status }}</span>
                                    
                                </td>
                                @if($showAksi)
                                <td class="align-middle non-printable">
                                    <a href="{{ route('rewardpunishment.show', $item->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" title="Detail"><i class="material-symbols-rounded" style="font-size: 18px;">visibility</i></a>
                                    @if($canVerify && $item->status === 'Menunggu')
                                        <button type="button" class="btn btn-link text-info text-gradient px-2 py-1 mb-0" title="Verifikasi" data-bs-toggle="modal" data-bs-target="#verifyModal-{{ $item->id }}">
                                            <i class="material-symbols-rounded" style="font-size: 18px;">edit_square</i>
                                        </button>
                                    @endif
                                    @if($user->role === 'HRD')
                                        <a href="{{ route('rewardpunishment.edit', $item->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" title="Edit"><i class="material-symbols-rounded" style="font-size: 18px;">edit</i></a>
                                        <form action="{{ route('rewardpunishment.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger text-gradient px-2 py-1 mb-0" title="Hapus"><i class="material-symbols-rounded" style="font-size: 18px;">delete</i></button>
                                        </form>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $showAksi ? 8 : 7 }}" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @foreach($rewardPunishments as $item)
                    @if($canVerify && $item->status === 'Menunggu')
                        <div class="modal fade" id="verifyModal-{{ $item->id }}" tabindex="-1" aria-labelledby="verifyModalLabel-{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('rewardpunishment.verify', $item->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="verifyModalLabel-{{ $item->id }}">Verifikasi Reward/Punishment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="status-{{ $item->id }}" class="form-label">Status Verifikasi</label>
                                                <select class="form-select" id="status-{{ $item->id }}" name="status" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Diterima">Diterima</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan-{{ $item->id }}" class="form-label">Keterangan (Opsional)</label>
                                                <textarea class="form-control" id="keterangan-{{ $item->id }}" name="keterangan" rows="2">{{ old('keterangan', $item->keterangan) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
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
    body {
        margin: 0;
        padding: 0;
    }
    .card, .row, .col-12 {
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .table-responsive {
        overflow: visible !important;
    }
}
</style>
@section('scripts')
<script>
    document.getElementById('tanggal-btn').addEventListener('click', function() {
        document.getElementById('tanggal-input').focus();
    });
    document.getElementById('tanggal-input').addEventListener('change', function() {
        document.getElementById('rewardpunishment-search-form').submit();
    });
</script>
@endsection
@endsection