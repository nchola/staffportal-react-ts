@extends('layout.index')
@section('title', 'Edit Data PHK')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Edit Data PHK</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form method="POST" action="{{ route('phk.update', $phk->id) }}" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pegawai</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="pegawai_id" class="form-control @error('pegawai_id') is-invalid @enderror" required>
                                        <option value="">Pilih Pegawai</option>
                                        @foreach($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('pegawai_id', $phk->pegawai_id) == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('pegawai_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="Menunggu" {{ old('status', $phk->status)=='Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Disetujui" {{ old('status', $phk->status)=='Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="Ditolak" {{ old('status', $phk->status)=='Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <div class="input-group input-group-outline my-3">
                                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" required>{{ old('keterangan', $phk->keterangan) }}</textarea>
                                </div>
                                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Surat PHK (PDF/JPG/PNG, opsional)</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="file" name="surat_phk" class="form-control @error('surat_phk') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                @if($phk->surat_phk)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/'.$phk->surat_phk) }}" target="_blank">Lihat Surat PHK</a>
                                    </div>
                                @endif
                                @error('surat_phk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phk.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 