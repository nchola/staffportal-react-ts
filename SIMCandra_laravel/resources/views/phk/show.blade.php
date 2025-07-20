@extends('layout.index')
@section('title', 'Detail PHK')
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Detail PHK</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pegawai:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $phk->pegawai->nama_lengkap ?? '-' }} (NIP: {{ $phk->pegawai->nip ?? '-' }})</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status:</p>
                                @php
                                    $statusClass = 'secondary';
                                    switch($phk->status) {
                                        case 'Menunggu': $statusClass = 'warning'; break;
                                        case 'Disetujui': $statusClass = 'success'; break;
                                        default: $statusClass = 'danger'; break;
                                    }
                                @endphp
                                <span class="badge bg-gradient-{{ $statusClass }} px-3 py-2" style="font-size: 1rem;">{{ strtoupper($phk->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Keterangan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $phk->keterangan }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Surat PHK:</p>
                                @if($phk->surat_phk)
                                    <a href="{{ asset('storage/'.$phk->surat_phk) }}" target="_blank">Lihat Surat PHK</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($phk->tanggal_verifikasi)
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Verifikasi Oleh:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $phk->verifikator->name ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Verifikasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">
                                    {{ $phk->tanggal_verifikasi ? \Carbon\Carbon::parse($phk->tanggal_verifikasi)->format('Y-m-d') : '-' }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('phk.index') }}" class="btn btn-secondary">
                            <i class="material-symbols-rounded">arrow_back</i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 