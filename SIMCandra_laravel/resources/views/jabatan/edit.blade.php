@extends('layout.index')

@section('title', 'Edit Jabatan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0"><i class="material-symbols-rounded align-middle me-2">edit</i>Edit Jabatan</h6>
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="departemen_id" value="{{ $jabatan->departemen_id }}">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jabatan</label>
                        <div class="input-group input-group-outline my-2">
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $jabatan->nama) }}" required placeholder="Nama jabatan">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <div class="input-group input-group-outline my-2">
                            <input type="number" name="level" id="level" class="form-control" value="{{ old('level', $jabatan->level) }}" required placeholder="Level jabatan">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <div class="input-group input-group-outline my-2">
                            <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi singkat">{{ old('deskripsi', $jabatan->deskripsi) }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="departemen_id" class="form-label">Departemen</label>
                        <div class="input-group input-group-outline my-2">
                            <select name="departemen_id" id="departemen_id" class="form-select" required>
                                <option value="">Pilih Departemen</option>
                                @foreach($departemens as $d)
                                    <option value="{{ $d->id }}" {{ $jabatan->departemen_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                                @endforeach
                            </select>
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