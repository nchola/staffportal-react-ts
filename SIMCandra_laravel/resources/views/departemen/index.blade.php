@extends('layout.index')

@section('title', 'Daftar Departemen')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Departemen</h6>
                    <a href="{{ route('departemen.create') }}" class="btn btn-success text-white me-3">
                        <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Departemen</a>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <div class="table-responsive p-0">
                    <table class="table table-sm align-items-center mb-0" id="departemenTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Departemen</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departemens as $departemen)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1 align-items-center">
                                        <button class="btn btn-link btn-sm p-0 align-baseline toggle-jabatan" data-id="{{ $departemen->id }}" title="Lihat Jabatan" style="vertical-align: middle; min-width: 24px;">
                                            <span class="material-symbols-rounded" style="font-size: 20px; vertical-align: middle;">expand_more</span>
                                        </button>
                                        <h6 class="mb-0 text-sm ms-2">{{ $departemen->nama }}</h6>
                                    </div>
                                </td>
                                <td><p class="text-xs font-weight-bold mb-0">{{ $departemen->deskripsi }}</p></td>
                                <td class="align-middle text-center non-printable">
                                    @if(Auth::check() && Auth::user()->role === 'HRD')
                                    <a href="{{ route('departemen.edit', $departemen->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Edit departemen">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                    </a>
                                    <a href="{{ route('jabatan.create', ['departemen_id' => $departemen->id]) }}" class="btn btn-link text-success text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Tambah Jabatan">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">add</i>
                                    </a>
                                    <form action="{{ route('departemen.destroy', $departemen->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus departemen ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Hapus departemen">
                                            <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                        </button>
                                    </form>
                                    @endif
                                    @if(Auth::check() && Auth::user()->role !== 'HRD')
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="jabatan-row" id="jabatan-row-{{ $departemen->id }}" style="display:none;">
                                <td colspan="4">
                                    <div class="p-2 bg-light border rounded">
                                        <strong>Daftar Jabatan:</strong>
                                        <ul class="mb-0">
                                            @forelse($departemen->jabatans as $jabatan)
                                                <li>
                                                    {{ $jabatan->nama }} (Level: {{ $jabatan->level }})
                                                    @if(Auth::check() && Auth::user()->role === 'HRD')
                                                    <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-xs btn-warning ms-3">Edit</a>
                                                    @endif
                                                </li>
                                            @empty
                                                <li><em>Tidak ada jabatan.</em></li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-jabatan').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var row = document.getElementById('jabatan-row-' + id);
                if (row.style.display === 'none') {
                    row.style.display = '';
                    this.querySelector('span').textContent = 'expand_less';
                } else {
                    row.style.display = 'none';
                    this.querySelector('span').textContent = 'expand_more';
                }
            });
        });
    });
</script>
@endsection 