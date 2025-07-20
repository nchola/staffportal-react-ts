@extends('layout.index')
@section('title', 'Data PHK')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Data PHK</h6>
                    <div class="d-flex non-printable">
                        @if(Auth::user()->role === 'HRD')
                            <a href="{{ route('phk.create') }}" class="btn btn-success text-white me-3 "><i class="material-symbols-rounded align-middle me-1">add</i>Tambah PHK</a>
                            <a href="#" class="btn btn-info text-white me-3" onclick="window.print(); return false;"><i class="material-symbols-rounded align-middle me-1">print</i> Cetak</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <div class="table-responsive p-0">
                    <table class="table table-sm align-items-center mb-0" id="phkTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pegawai</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Surat</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($phks as $phk)
                                <tr>
                                    <td><span class="text-sm font-weight-bold">{{ $phk->pegawai->nama_lengkap ?? '-' }}</span></td>
                                    <td><span class="text-xs font-weight-bold mb-0">{{ Str::limit($phk->keterangan, 30) }}</span></td>
                                    <td>
                                        @php
                                            $statusClass = 'secondary';
                                            switch($phk->status) {
                                                case 'Menunggu': $statusClass = 'warning'; break;
                                                case 'Disetujui': $statusClass = 'success'; break;
                                                default: $statusClass = 'danger'; break;
                                            }
                                        @endphp
                                        <span class="badge badge-sm bg-gradient-{{ $statusClass }}">{{ $phk->status }}</span>
                                    </td>
                                    <td>
                                        @if($phk->surat_phk)
                                            <a href="{{ asset('storage/'.$phk->surat_phk) }}" target="_blank" class="btn btn-link text-primary text-gradient px-2 py-1 mb-0" style="font-size:13px;">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center non-printable">
                                        <a href="{{ route('phk.show', $phk->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" title="Detail"><i class="material-symbols-rounded" style="font-size: 18px;">visibility</i></a>
                                        @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $phk->status === 'Menunggu')
                                            <button type="button" class="btn btn-link text-info text-gradient px-2 py-1 mb-0" title="Verifikasi" data-bs-toggle="modal" data-bs-target="#verifModal-{{ $phk->id }}">
                                                <i class="material-symbols-rounded" style="font-size: 18px;">edit_square</i>
                                            </button>
                                        @endif
                                        @if(Auth::user()->role === 'HRD')
                                            <a href="{{ route('phk.edit', $phk->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" title="Edit"><i class="material-symbols-rounded" style="font-size: 18px;">edit</i></a>
                                            <form action="{{ route('phk.destroy', $phk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data PHK ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-gradient px-2 py-1 mb-0" title="Hapus"><i class="material-symbols-rounded" style="font-size: 18px;">delete</i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">Belum ada data PHK.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- CSS untuk print --}}
<style>
    @media print {
        .non-printable,
        .sidenav,
        .navbar,
        .card-header .bg-gradient-dark {
            display: none !important;
        }
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
@foreach($phks as $phk)
    @if(in_array(Auth::user()->role, ['HRD', 'Kepala Unit']) && $phk->status === 'Menunggu')
    <div class="modal fade" id="verifModal-{{ $phk->id }}" tabindex="-1" aria-labelledby="verifModalLabel-{{ $phk->id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('phk.verify', $phk->id) }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="verifModalLabel-{{ $phk->id }}">Verifikasi PHK</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="status-{{ $phk->id }}" class="form-label">Status</label>
                <select name="status" id="status-{{ $phk->id }}" class="form-select" required>
                  <option value="Disetujui">Disetujui</option>
                  <option value="Ditolak">Ditolak</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="keterangan_verifikasi-{{ $phk->id }}" class="form-label">Keterangan</label>
                <textarea name="keterangan_verifikasi" id="keterangan_verifikasi-{{ $phk->id }}" class="form-control" rows="3"></textarea>
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
@endsection 