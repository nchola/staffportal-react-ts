@extends('layout.index')
@section('title', 'Detail Reward & Punishment')
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Detail Reward & Punishment</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Nama Karyawan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $rewardPunishment->karyawan->nama_lengkap ?? '-' }} (NIP: {{ $rewardPunishment->karyawan->nip ?? '-' }})</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jenis:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $rewardPunishment->jenis }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ \Carbon\Carbon::parse($rewardPunishment->tanggal)->format('d/m/Y') }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Reward:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $rewardPunishment->reward ? 'Rp' . number_format($rewardPunishment->reward, 0, ',', '.') : '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Keterangan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $rewardPunishment->keterangan }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Surat:</p>
                                @if($rewardPunishment->surat_punishment)
                                    <a href="{{ asset('storage/' . str_replace('public/', '', $rewardPunishment->surat_punishment)) }}" target="_blank">Lihat File</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status:</p>
                                @php
                                    $statusClass = 'secondary';
                                    switch($rewardPunishment->status) {
                                        case 'Diterima': $statusClass = 'success'; break;
                                        case 'Ditolak': $statusClass = 'danger'; break;
                                        case 'Menunggu': $statusClass = 'warning'; break;
                                    }
                                @endphp
                                <span class="badge bg-gradient-{{ $statusClass }} px-3 py-2" style="font-size: 1rem;">{{ strtoupper($rewardPunishment->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('rewardpunishment.index') }}" class="btn btn-secondary">
                            <i class="material-symbols-rounded">arrow_back</i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 