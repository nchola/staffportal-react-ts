@extends('layout.index')
@section('title', 'Tambah Lamaran')
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0"><i class="material-symbols-rounded align-middle me-2">description</i>Tambah Lamaran</h6>
                </div>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('lamaran.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pelamar" class="form-label">Nama Pelamar</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="text" class="form-control" id="nama_pelamar" name="nama_pelamar" required placeholder="Nama lengkap sesuai KTP">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Email aktif">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon" class="form-label">No. Telepon</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Nomor HP/WA">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" placeholder="Contoh: S1 Teknik Informatika">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="resume_url" class="form-label">Resume (URL)</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="url" class="form-control" id="resume_url" name="resume_url" placeholder="Link Google Drive/Dropbox/Website">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pengalaman_kerja" class="form-label">Pengalaman Kerja</label>
                        <div class="input-group input-group-outline my-2">
                            <textarea class="form-control" id="pengalaman_kerja" name="pengalaman_kerja" rows="2" placeholder="Ceritakan pengalaman kerja Anda (jika ada)"></textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <div class="input-group input-group-outline my-2">
                            <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="rekrutmen_id" class="form-label">Lowongan</label>
                        <div class="input-group input-group-outline my-2">
                            <select class="form-select" id="rekrutmen_id" name="rekrutmen_id">
                                <option value="">Pilih Lowongan</option>
                                @foreach($rekrutmens as $r)
                                    <option value="{{ $r->id }}">{{ $r->judul }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn bg-gradient-dark">Simpan</button>
                        <a href="{{ route('lamaran.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 