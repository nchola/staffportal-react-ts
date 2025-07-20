@extends('layout.index')

@section('title', 'Data Cuti/Izin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3">Data Cuti/Izin</h6>
                    <div class="d-flex non-printable">
                        {{-- Tombol Tambah (Akses: HRD, Karyawan) --}}
                        @can('create', App\Models\Cuti::class)
                            <a href="{{ route('cuti.create') }}" class="btn btn-success text-white me-3">
                                <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Permohonan Cuti</a>
                        @endcan
                        {{-- Tombol Cetak (Akses: HRD) --}}
                        @if(Auth::check() && Auth::user()->role === 'HRD')
                        <a href="#" class="btn btn-info text-white me-3" onclick="window.print(); return false;"><i class="material-symbols-rounded align-middle me-1">print</i> Cetak</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="cutiTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pegawai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Cuti</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Mulai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Selesai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alasan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Surat Keterangan</th>
                                {{-- Kolom Aksi disembunyikan saat print --}}
                                @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
                                    <th class="text-secondary opacity-7 non-printable">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cutis as $cuti)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $cuti->pegawai->nama_lengkap ?? 'N/A' }}</h6>
                                            <p class="text-xs text-secondary mb-0">NIP: {{ $cuti->pegawai->nip ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $cuti->jenis_cuti }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('Y-m-d') }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('Y-m-d') }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $cuti->alasan }}</p>
                                </td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        switch($cuti->status) {
                                            case 'Disetujui': $statusClass = 'success'; break;
                                            case 'Ditolak': $statusClass = 'danger'; break;
                                            case 'Pending': case null: $statusClass = 'warning'; break;
                                        }
                                    @endphp
                                    <span class="badge badge-sm bg-gradient-{{ $statusClass }}">{{ $cuti->status ?? 'Pending' }}</span>
                                </td>
                                <td>
                                    @if($cuti->requiresSuratKeterangan())
                                        @if($cuti->surat_keterangan)
                                            <a href="{{ asset('storage/' . $cuti->surat_keterangan) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="material-symbols-rounded">visibility</i> Lihat
                                            </a>
                                        @else
                                            <span class="badge badge-sm bg-gradient-danger">Belum Upload</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
                                    <td class="align-middle text-center non-printable">
                                        <a href="{{ route('cuti.show', $cuti->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" title="Detail"><i class="material-symbols-rounded" style="font-size: 18px;">visibility</i></a>
                                        @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && ($cuti->status == 'Menunggu' || $cuti->status == null))
                                            <button type="button" class="btn btn-link text-info text-gradient px-2 py-1 mb-0" title="Verifikasi" data-bs-toggle="modal" data-bs-target="#verifModal-{{ $cuti->id }}">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit_square</i>
                                            </button>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data cuti.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Verifikasi untuk HRD dan Kepala Unit --}}
@foreach($cutis as $cuti)
    @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && ($cuti->status == 'Menunggu' || $cuti->status == null))
    <div class="modal fade" id="verifModal-{{ $cuti->id }}" tabindex="-1" aria-labelledby="verifModalLabel-{{ $cuti->id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('cuti.verify', $cuti->id) }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="verifModalLabel-{{ $cuti->id }}">Verifikasi Cuti/Izin</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="status-{{ $cuti->id }}" class="form-label">Status</label>
                <select name="status" id="status-{{ $cuti->id }}" class="form-select" required>
                  <option value="Disetujui">Disetujui</option>
                  <option value="Ditolak">Ditolak</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="keterangan_verifikasi-{{ $cuti->id }}" class="form-label">Keterangan</label>
                <textarea name="keterangan_verifikasi" id="keterangan_verifikasi-{{ $cuti->id }}" class="form-control" rows="3"></textarea>
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
@endforeach

{{-- CSS untuk print --}}
<style>
    @media print {
        .non-printable {
            display: none !important;
        }
        .card-header .bg-gradient-dark {
            background: none !important;
            color: #000 !important;
        }
        .text-white {
            color: #000 !important;
        }
    }
</style>
@endsection 