@extends('layout.index')

@section('title', 'Detail Pegawai: ' . $pegawai->nama_lengkap)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Detail Pegawai: {{ $pegawai->nama_lengkap }}</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    {{-- Detail Pegawai menggunakan layout grid untuk susunan horizontal --}}
                    <div class="row">
                        <div class="col-md-6 mb-3"> {{-- NIP in one column --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100"> {{-- Apply card style and padding to inner div --}}
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">NIP:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->nip }}</h6> {{-- mb-0 to reduce space below value --}}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3"> {{-- Nama Lengkap in another column --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100"> {{-- Apply card style and padding to inner div --}}
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Nama Lengkap:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->nama_lengkap }}</h6> {{-- mb-0 to reduce space below value --}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-3"> {{-- Nama Panggilan --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Nama Panggilan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->nama_panggilan ?? '-' }}</h6>
                            </div>
                         </div>
                         <div class="col-md-6 mb-3"> {{-- Nomor KTP --}}
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Nomor KTP:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->no_ktp ?? '-' }}</h6>
                            </div>
                         </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6 mb-3"> {{-- Jenis Kelamin --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                 <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jenis Kelamin:</p>
                                 <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->jenis_kelamin ?? '-' }}</h6>
                             </div>
                         </div>
                         <div class="col-md-6 mb-3"> {{-- Agama --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                 <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Agama:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->agama ?? '-' }}</h6>
                             </div>
                         </div>
                    </div>

                     <div class="row">
                          <div class="col-md-6 mb-3"> {{-- Tempat Lahir --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tempat Lahir:</p>
                                 <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->tempat_lahir ?? '-' }}</h6>
                              </div>
                          </div>
                          <div class="col-md-6 mb-3"> {{-- Tanggal Lahir --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Lahir:</p>
                                 <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->tanggal_lahir ?? '-' }}</h6>
                              </div>
                          </div>
                     </div>

                     <div class="row">
                          <div class="col-md-6 mb-3"> {{-- Pendidikan Terakhir --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pendidikan Terakhir:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->pendidikan_terakhir ?? '-' }}</h6>
                              </div>
                          </div>
                          <div class="col-md-6 mb-3"> {{-- Status Pernikahan --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status Pernikahan:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->status_pernikahan ?? '-' }}</h6>
                              </div>
                          </div>
                     </div>

                    {{-- Informasi Kontak --}}
                     <div class="row mt-4">
                         <div class="col-md-6 mb-3"> {{-- Email --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                 <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Email:</p>
                                 <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->email ?? '-' }}</h6>
                             </div>
                         </div>
                         <div class="col-md-6 mb-3"> {{-- Nomor Telepon --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                 <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Nomor Telepon:</p>
                                 <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->no_telepon ?? '-' }}</h6>
                             </div>
                         </div>
                    </div>

                     <div class="row">
                         <div class="col-md-12 mb-3"> {{-- Alamat takes full width --}}
                             <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                 <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Alamat:</p>
                                 <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->alamat ?? '-' }}</h6>
                             </div>
                         </div>
                    </div>

                    {{-- Informasi Pekerjaan --}}
                     <div class="row mt-4">
                         <div class="col-md-6 mb-3"> {{-- Departemen --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Departemen:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->departemen->nama ?? $pegawai->divisi ?? '-' }}</h6>
                              </div>
                         </div>
                         <div class="col-md-6 mb-3"> {{-- Jabatan --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jabatan:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->jabatan->nama ?? $pegawai->jabatan ?? '-' }}</h6>
                              </div>
                         </div>
                    </div>

                     <div class="row">
                          <div class="col-md-6 mb-3"> {{-- Nomor Absensi --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Nomor Absensi:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->no_absensi ?? '-' }}</h6>
                              </div>
                          </div>
                          <div class="col-md-6 mb-3"> {{-- Atasan Langsung --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Atasan Langsung:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->atasan_langsung ?? '-' }}</h6>
                              </div>
                          </div>
                    </div>

                     <div class="row">
                          <div class="col-md-6 mb-3"> {{-- Status Kepegawaian --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status Kepegawaian:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->status ?? '-' }}</h6>
                              </div>
                          </div>
                          <div class="col-md-6 mb-3"> {{-- Tanggal Bergabung --}}
                              <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                  <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Bergabung:</p>
                                  <h6 class="text-dark font-weight-normal mb-0">{{ $pegawai->tanggal_bergabung }}</h6>
                              </div>
                          </div>
                    </div>

                    {{-- Add user relationship details if needed later --}}

                    <div class="mt-4">
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 