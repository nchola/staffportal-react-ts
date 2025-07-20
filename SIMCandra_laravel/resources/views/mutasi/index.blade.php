@extends('layout.index')

@section('title', 'Data Promosi/Demosi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Data Promosi/Demosi</h6>
                    <div class="d-flex non-printable">
                        @if(Auth::check() && Auth::user()->role === 'HRD')
                        <a href="{{ route('mutasi.create') }}" class="btn btn-success text-white me-3">
                            <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Data Promosi/Demosi</a>    
                        <a href="#" class="btn btn-info text-white me-3" onclick="window.print(); return false;"><i class="material-symbols-rounded align-middle me-1">print</i> Cetak</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <div class="row">
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('mutasi.index') }}" class="mb-2 d-flex gap-2 align-items-center position-relative non-printable" autocomplete="off" id="mutasi-search-form">
                            <div class="input-group input-group-outline flex-grow-1">
                                <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Cari NIP/Nama/Departemen/Jabatan" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <div style="position: relative;">
                                <button type="button" class="btn btn-outline-secondary btn-icon" id="tanggal-btn" title="Filter Tanggal Efektif">
                                    <span class="material-symbols-rounded">calendar_month</span>
                                </button>
                                <input type="date" name="tanggal_efektif" id="tanggal-input" value="{{ request('tanggal_efektif') }}" style="position: absolute; left: 0; top: 0; width: 45px; height: 45px; opacity: 0; cursor: pointer; z-index: 2;">
                            </div>
                            <button type="submit" class="btn btn-primary btn-icon" title="Cari">
                                <span class="material-symbols-rounded">search</span>
                            </button>
                            @if(request('q') || request('tanggal_efektif'))
                                <a href="{{ route('mutasi.index') }}" class="btn btn-outline-secondary btn-icon" title="Reset">
                                    <span class="material-symbols-rounded">close</span>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="mutasiTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pegawai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jabatan/Departemen</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Efektif</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status Verifikasi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status Ketetapan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Surat</th>
                                <th class="text-secondary opacity-7 non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mutasis as $mutasi)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $mutasi->pegawai->nama_lengkap ?? '-' }}</h6>
                                            <p class="text-xs text-secondary mb-0">NIP: {{ $mutasi->pegawai->nip ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 12px;">
                                        <div><span class="text-muted">Jabatan Lama:</span> <span class="fw-bold">{{ $mutasi->jabatanLama->nama ?? '-' }}</span></div>
                                        <div><span class="text-muted">Jabatan Baru:</span> <span class="fw-bold">{{ $mutasi->jabatanBaru->nama ?? '-' }}</span></div>
                                        <div><span class="text-muted">Dept. Lama:</span> <span class="fw-bold">{{ $mutasi->departemenLama->nama ?? '-' }}</span></div>
                                        <div><span class="text-muted">Dept. Baru:</span> <span class="fw-bold">{{ $mutasi->departemenBaru->nama ?? '-' }}</span></div>
                                    </div>
                                </td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ $mutasi->tanggal_efektif }}</span></td>
                                <td>
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
                                </td>
                                <td>
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
                                </td>
                                <td><span class="text-xs font-weight-bold mb-0">{{ ucfirst($mutasi->jenis) }}</span></td>
                                <td><span class="text-xs font font-weight-bold mb-0">
                                    @if ($mutasi->dokumen)
                                        <a href="{{ asset('storage/' . $mutasi->dokumen) }}" target="_blank" class="text-primary text-decoration-underline">Lihat File</a>
                                    @else
                                        -
                                    @endif
                                </span></td>
                                <td class="align-middle text-center non-printable">
                                    {{-- Tombol Edit (Akses: HRD) --}}
                                    @if(Auth::check() && Auth::user()->role === 'HRD')
                                    <a href="{{ route('mutasi.edit', $mutasi->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Edit pegawai">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                    </a>
                                    @endif
                                    <a href="{{ route('mutasi.show', $mutasi->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" title="Detail"><i class="material-symbols-rounded" style="font-size: 18px;">visibility</i></a>
                                    @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $mutasi->status_verifikasi == 'Menunggu')
                                        <button type="button" class="btn btn-link text-info text-gradient px-2 py-1 mb-0" title="Verifikasi Status" data-bs-toggle="modal" data-bs-target="#verifModal-{{ $mutasi->id }}">
                                            <i class="material-symbols-rounded" style="font-size: 18px;">edit_square</i>
                                        </button>
                                    @endif
                                    @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $mutasi->status=='Menunggu')
                                        <button type="button" class="btn btn-link text-success text-gradient px-2 py-1 mb-0" title="Verifikasi" data-bs-toggle="modal" data-bs-target="#verifModal-{{ $mutasi->id }}">
                                            <i class="material-symbols-rounded" style="font-size: 18px;">check_circle</i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data mutasi.</td>
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
@foreach($mutasis as $mutasi)
    @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $mutasi->status_verifikasi == 'Menunggu')
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
@endforeach

{{-- Modal Verifikasi Status Promosi/Demosi --}}
@foreach($mutasis as $mutasi)
    @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $mutasi->status_promosi_demosi !== 'Tetap')
    <div class="modal fade" id="verifStatusModal-{{ $mutasi->id }}" tabindex="-1" aria-labelledby="verifStatusModalLabel-{{ $mutasi->id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('mutasi.update', $mutasi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title" id="verifStatusModalLabel-{{ $mutasi->id }}">Verifikasi Status Promosi/Demosi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="status_promosi_demosi-{{ $mutasi->id }}" class="form-label">Status Promosi/Demosi</label>
                <select name="status_promosi_demosi" id="status_promosi_demosi-{{ $mutasi->id }}" class="form-select" required>
                  <option value="Tetap" {{ $mutasi->status_promosi_demosi == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                  <option value="Sementara" {{ $mutasi->status_promosi_demosi == 'Sementara' ? 'selected' : '' }}>Sementara</option>
                  <option value="Uji Coba" {{ $mutasi->status_promosi_demosi == 'Uji Coba' ? 'selected' : '' }}>Uji Coba</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-info">Update Status</button>
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
        /* Sembunyikan elemen non-cetak */
        .non-printable,
        .sidenav,
        .navbar,
        .card-header .bg-gradient-dark {
            display: none !important;
        }
        /* Sesuaikan tampilan tabel untuk print */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Hapus margin/padding yang mengganggu */
        body {
            margin: 0;
            padding: 0;
        }
        .card, .row, .col-12 {
            box-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .table-responsive {
            overflow: visible !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.getElementById('tanggal-btn').addEventListener('click', function() {
        document.getElementById('tanggal-input').focus();
    });
    document.getElementById('tanggal-input').addEventListener('change', function() {
        document.getElementById('mutasi-search-form').submit();
    });
</script>
@endsection 