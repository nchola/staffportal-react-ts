@extends('layout.index')

@section('title', 'Detail Presensi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail Presensi</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    {{-- Detail Presensi menggunakan layout grid untuk susunan horizontal --}}
                    <div class="row">
                        <div class="col-md-6 mb-3"> {{-- Pegawai in one column --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100"> {{-- Apply card style and padding to inner div --}}
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pegawai:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $absensi->pegawai->nama_lengkap ?? 'N/A' }} (NIP: {{ $absensi->pegawai->nip ?? 'N/A' }})</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3"> {{-- Tanggal in another column --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100"> {{-- Apply card style and padding to inner div --}}
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $absensi->tanggal }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-3"> {{-- Jam Masuk --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jam Masuk:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $absensi->jam_masuk ?? '-' }}</h6>
                            </div>
                         </div>
                         <div class="col-md-6 mb-3"> {{-- Jam Keluar --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jam Keluar:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $absensi->jam_keluar ?? '-' }}</h6>
                            </div>
                         </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-3"> {{-- Status --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                 <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status:</p>
                                 <h6 class="text-dark font-weight-normal mb-0">{{ $absensi->status }}</h6>
                             </div>
                         </div>
                         <div class="col-md-6 mb-3"> {{-- Keterangan --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                 <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Keterangan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $absensi->keterangan ?? '-' }}</h6>
                             </div>
                         </div>
                    </div>
                    @if($absensi->status === 'Sakit' && $absensi->surat_keterangan_dokter)
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Surat Keterangan Dokter:</p>
                                <a href="{{ asset('storage/' . $absensi->surat_keterangan_dokter) }}" target="_blank" class="btn btn-info btn-sm">Lihat Surat</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3"> {{-- Foto Masuk --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Foto Masuk:</p>
                                @if($absensi->foto_masuk)
                                    <img src="{{ asset('storage/' . $absensi->foto_masuk) }}" alt="Foto Masuk" style="max-width: 120px; max-height: 120px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3"> {{-- Foto Keluar --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Foto Keluar:</p>
                                @if($absensi->foto_keluar)
                                    <img src="{{ asset('storage/' . $absensi->foto_keluar) }}" alt="Foto Keluar" style="max-width: 120px; max-height: 120px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    

                    {{-- Tombol Kembali --}}
                    <div class="mt-4">
                        <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Kembali ke Data Presensi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Removed custom CSS for spacing --}}

@endsection 