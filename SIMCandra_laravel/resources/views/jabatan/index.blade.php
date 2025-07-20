@extends('layout.index')

@section('title', 'Daftar Jabatan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Daftar Jabatan</h6>
                    <a href="{{ route('jabatan.create') }}" class="btn btn-outline-light">Tambah Jabatan</a>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Nama Jabatan</th>
                                <th>Level</th>
                                <th>Departemen</th>
                                <th>Deskripsi</th>
                                <th class="non-printable">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jabatans as $j)
                            <tr>
                                <td>{{ $j->nama }}</td>
                                <td>{{ $j->level }}</td>
                                <td>{{ $j->departemen->nama ?? '-' }}</td>
                                <td>{{ $j->deskripsi }}</td>
                                <td class="non-printable">
                                    <a href="{{ route('jabatan.edit', $j->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('jabatan.destroy', $j->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jabatan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data jabatan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 