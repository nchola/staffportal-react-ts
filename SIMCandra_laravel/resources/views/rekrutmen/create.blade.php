@extends('layout.index')
@section('title', 'Tambah Lowongan Rekrutmen')
@section('content')
<style>
.card .form-control, .card .form-select {
  border: 1px solid #ced4da !important;
  background-color: #fff !important;
  border-radius: 0.5rem;
}
</style>
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0"><i class="material-symbols-rounded align-middle me-2">work</i>Tambah Lowongan Rekrutmen</h6>
                </div>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('rekrutmen.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="judul" class="form-label">Posisi</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kualifikasi" class="form-label">Kualifikasi</label>
                        <textarea class="form-control" id="kualifikasi" name="kualifikasi" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_buka" class="form-label">Tanggal Buka</label>
                            <input type="date" class="form-control" id="tanggal_buka" name="tanggal_buka" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_tutup" class="form-label">Tanggal Tutup</label>
                            <input type="date" class="form-control" id="tanggal_tutup" name="tanggal_tutup" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="Aktif">Aktif</option>
                            <option value="Tutup">Tutup</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="material-symbols-rounded align-middle me-1">save</i> Simpan</button>
                        <a href="{{ route('rekrutmen.index') }}" class="btn btn-secondary btn-lg"><i class="material-symbols-rounded align-middle me-1">arrow_back</i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 