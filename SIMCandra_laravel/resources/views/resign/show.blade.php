@extends('layout.index')
@section('title', 'Detail Resign')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Detail Resign</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pegawai:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $resign->pegawai->nama_lengkap ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Pengajuan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $resign->tanggal_pengajuan }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Resign:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $resign->tanggal_resign }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status:</p>
                                @php
                                    $statusClass = 'secondary';
                                    switch($resign->status) {
                                        case 'Menunggu': $statusClass = 'warning'; break;
                                        case 'Disetujui': $statusClass = 'success'; break;
                                        default: $statusClass = 'danger'; break;
                                    }
                                @endphp
                                <span class="badge bg-gradient-{{ $statusClass }} px-3 py-2" style="font-size: 1rem;">{{ strtoupper($resign->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Alasan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $resign->alasan }}</h6>
                            </div>
                        </div>
                        @if($resign->surat_resign)
                        <div class="col-md-12 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Surat Resign:</p>
                                <a href="{{ asset('storage/'.$resign->surat_resign) }}" target="_blank">Lihat Surat Resign</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if($resign->status !== 'Menunggu')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Verifikasi Oleh:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $resign->verifikator->name ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Verifikasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $resign->tanggal_verifikasi }}</h6>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Keterangan Verifikasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $resign->keterangan_verifikasi }}</h6>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('resign.index') }}" class="btn btn-secondary">Kembali</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 