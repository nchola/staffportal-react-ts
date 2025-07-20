@extends('layout.index')
@section('title', 'Detail Cuti/Izin')
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Detail Cuti/Izin</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pegawai:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $cuti->pegawai->nama_lengkap ?? '-' }} (NIP: {{ $cuti->pegawai->nip ?? '-' }})</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jenis Cuti:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $cuti->jenis_cuti }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Mulai:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $cuti->tanggal_mulai ? \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('Y-m-d') : '-' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Selesai:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $cuti->tanggal_selesai ? \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('Y-m-d') : '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Alasan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $cuti->alasan }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Keterangan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $cuti->keterangan ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status:</p>
                                @php
                                    $statusClass = 'secondary';
                                    switch($cuti->status) {
                                        case 'Disetujui': $statusClass = 'success'; break;
                                        case 'Ditolak': $statusClass = 'danger'; break;
                                        case 'Pending': case null: $statusClass = 'warning'; break;
                                    }
                                @endphp
                                <span class="badge badge-sm bg-gradient-{{ $statusClass }}">{{ $cuti->status ?? 'Pending' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Verifikasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $cuti->tanggal_verifikasi ? \Carbon\Carbon::parse($cuti->tanggal_verifikasi)->format('Y-m-d') : '-' }}</h6>
                            </div>
                        </div>
                    </div>

                    @if($cuti->requiresSuratKeterangan())
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Surat Keterangan:</p>
                                @if($cuti->surat_keterangan)
                                    <a href="{{ asset('storage/' . $cuti->surat_keterangan) }}" target="_blank" class="btn btn-sm btn-info mt-2">
                                        <i class="material-symbols-rounded">visibility</i> Lihat Surat Keterangan
                                    </a>
                                @else
                                    <span class="text-danger">Surat keterangan belum diunggah</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('cuti.index') }}" class="btn btn-secondary">
                            <i class="material-symbols-rounded">arrow_back</i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 