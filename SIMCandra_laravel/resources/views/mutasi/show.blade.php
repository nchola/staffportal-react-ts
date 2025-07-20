@extends('layout.index')

@section('title', 'Detail Promosi/Demosi')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Detail Promosi/Demosi</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Pegawai:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->pegawai->nama_lengkap ?? '-' }} (NIP: {{ $mutasi->pegawai->nip ?? '-' }})</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status Verifikasi:</p>
                                @php
                                    $verifClass = 'secondary';
                                    switch($mutasi->status_verifikasi) {
                                        case 'Menunggu': $verifClass = 'warning'; break;
                                        case 'Disetujui': $verifClass = 'success'; break;
                                        case 'Ditolak': $verifClass = 'danger'; break;
                                        default: $verifClass = 'secondary'; break;
                                    }
                                @endphp
                                <span class="badge badge-sm bg-gradient-{{ $verifClass }}">{{ $mutasi->status_verifikasi ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Status Ketetapan:</p>
                                @php
                                    $ketetapanClass = 'secondary';
                                    switch($mutasi->status_ketetapan) {
                                        case 'Tetap': $ketetapanClass = 'info'; break;
                                        case 'Sementara': $ketetapanClass = 'warning'; break;
                                        case 'Uji Coba': $ketetapanClass = 'secondary'; break;
                                        default: $ketetapanClass = 'secondary'; break;
                                    }
                                @endphp
                                <span class="badge badge-sm bg-gradient-{{ $ketetapanClass }}">{{ $mutasi->status_ketetapan ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jenis Mutasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ ucfirst($mutasi->jenis) }}</h6>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jabatan Lama:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->jabatanLama->nama ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Jabatan Baru:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->jabatanBaru->nama ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Departemen Lama:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->departemenLama->nama ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Departemen Baru:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->departemenBaru->nama ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Keterangan:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->keterangan ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Alasan Mutasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->alasan }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Efektif:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->tanggal_efektif }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Tanggal Verifikasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->tanggal_verifikasi ? \Carbon\Carbon::parse($mutasi->tanggal_verifikasi)->format('Y-m-d') : '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Verifikasi Oleh:</p>
                                <h6 class="text-dark font-weight-normal mb-0">{{ $mutasi->verifikator->name ?? '-' }} ({{ $mutasi->verifikator->role ?? '-' }})</h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="p-2 bg-gray-100 border-radius-lg h-100">
                                <p class="text-uppercase text-sm mb-0 font-weight-bold text-muted">Surat Mutasi:</p>
                                <h6 class="text-dark font-weight-normal mb-0">
                                    @if($mutasi->dokumen)
                                        <a href="{{ asset('storage/' . $mutasi->dokumen) }}" target="_blank" class="text-primary text-decoration-underline">Lihat File</a>
                                    @else
                                        -
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $mutasi->status=='Menunggu')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifModal-{{ $mutasi->id }}">
                                <i class="material-symbols-rounded">check</i> Verifikasi
                            </button>
                        @endif
                        <a href="{{ route('mutasi.index') }}" class="btn btn-secondary">
                            <i class="material-symbols-rounded">arrow_back</i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal Verifikasi untuk HRD dan Kepala Unit --}}
@if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $mutasi->status=='Menunggu')
<div class="modal fade" id="verifModal-{{ $mutasi->id }}" tabindex="-1" aria-labelledby="verifModalLabel-{{ $mutasi->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('mutasi.verify', $mutasi->id) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verifModalLabel-{{ $mutasi->id }}">Verifikasi Promosi/Demosi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="status-{{ $mutasi->id }}" class="form-label">Status</label>
            <select name="status" id="status-{{ $mutasi->id }}" class="form-select" required>
              <option value="Disetujui">Disetujui</option>
              <option value="Ditolak">Ditolak</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="keterangan_verifikasi-{{ $mutasi->id }}" class="form-label">Keterangan</label>
            <textarea name="keterangan_verifikasi" id="keterangan_verifikasi-{{ $mutasi->id }}" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Verifikasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endsection 