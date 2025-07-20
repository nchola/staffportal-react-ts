@extends('layout.index')
@section('title', Auth::user() && Auth::user()->role === 'Calon Karyawan' ? 'Detail Lowongan' : 'Detail Lowongan Rekrutmen')
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <!-- Card Utama -->
        <div class="card my-4 shadow-lg">
            <div class="card-body p-4">
                <!-- Card Judul & Status -->
                <div class="card mb-3 border-0 shadow-none bg-transparent">
                    <div class="card-header p-0 bg-transparent border-0 position-relative z-index-2">
                        <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                            <span class="material-symbols-rounded text-white me-2" style="font-size:2.2rem;">work</span>
                            <h5 class="text-white text-capitalize ps-1 mb-0 flex-grow-1">{{ $rekrutmen->judul }}</h5>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-3 pb-0">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="card border-0 shadow-sm mb-0">
                                    <div class="card-body py-2 px-3">
                                        <span class="material-symbols-rounded align-middle text-primary me-1">calendar_month</span>
                                        <span class="fw-bold">Buka:</span> {{ $rekrutmen->tanggal_buka }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-0 shadow-sm mb-0">
                                    <div class="card-body py-2 px-3">
                                        <span class="material-symbols-rounded align-middle text-danger me-1">event_busy</span>
                                        <span class="fw-bold">Tutup:</span> {{ $rekrutmen->tanggal_tutup }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Deskripsi -->
                <div class="card mb-3">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h6 class="mb-0"><span class="material-symbols-rounded align-middle me-1 text-info">description</span>Deskripsi Pekerjaan</h6>
                    </div>
                    <div class="card-body pt-2">
                        <div class="text-muted">{!! nl2br(e($rekrutmen->deskripsi)) !!}</div>
                    </div>
                </div>
                <!-- Card Kualifikasi -->
                <div class="card mb-3">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h6 class="mb-0"><span class="material-symbols-rounded align-middle me-1 text-success">check_circle</span>Kualifikasi</h6>
                    </div>
                    <div class="card-body pt-2">
                        <div class="text-muted">{!! nl2br(e($rekrutmen->kualifikasi)) !!}</div>
                    </div>
                </div>
                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    @if(Auth::user() && Auth::user()->role === 'Calon Karyawan')
                        @php $sudahMelamar = $rekrutmen->lamarans->where('user_id', Auth::id())->first(); @endphp
                        @if(!$sudahMelamar && $rekrutmen->status === 'Aktif')
                            <a href="{{ route('lamaran.create', ['rekrutmen_id' => $rekrutmen->id]) }}" class="btn btn-primary"><i class="material-symbols-rounded align-middle me-1">send</i> Lamar</a>
                        @endif
                    @endif
                    <a href="{{ route('rekrutmen.index') }}" class="btn btn-secondary"><i class="material-symbols-rounded align-middle me-1">arrow_back</i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 