@extends('layout.index')
@section('title', 'Detail Lamaran')
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0"><i class="material-symbols-rounded align-middle me-2">description</i>Detail Lamaran</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Nama Pelamar:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $lamaran->nama_pelamar }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status:</p>
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Email:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $lamaran->email }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">No. Telepon:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $lamaran->no_telepon }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pendidikan Terakhir:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $lamaran->pendidikan_terakhir }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Lowongan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $lamaran->rekrutmen ? $lamaran->rekrutmen->judul : '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pengalaman Kerja:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $lamaran->pengalaman_kerja }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Catatan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $lamaran->catatan }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Resume:</p>
                                <h6 class="text-dark font-weight-normal mb-0">@if($lamaran->resume_url)<a href="{{ $lamaran->resume_url }}" target="_blank" class="text-primary text-decoration-underline">Lihat Resume</a>@else - @endif</h6>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('lamaran.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 