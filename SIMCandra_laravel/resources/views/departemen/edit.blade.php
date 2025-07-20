@extends('layout.index')

@section('title', 'Edit Departemen')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0"><i class="material-symbols-rounded align-middle me-2">edit</i>Edit Departemen</h6>
                    <a href="{{ route('departemen.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <form action="{{ route('departemen.update', $departemen->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Departemen</label>
                        <div class="input-group input-group-outline my-2">
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $departemen->nama) }}" required placeholder="Nama departemen">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <div class="input-group input-group-outline my-2">
                            <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi singkat">{{ old('deskripsi', $departemen->deskripsi) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Kembali</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 