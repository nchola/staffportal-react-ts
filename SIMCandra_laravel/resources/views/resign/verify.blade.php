@extends('layout.index')
@section('title', 'Verifikasi Resign')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Verifikasi Pengajuan Resign</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form method="POST" action="{{ route('resign.verify', $resign->id) }}" class="p-3">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="input-group input-group-outline my-3">
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="Disetujui" @if(old('status')=='Disetujui') selected @endif>Disetujui</option>
                                <option value="Ditolak" @if(old('status')=='Ditolak') selected @endif>Ditolak</option>
                            </select>
                        </div>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan Verifikasi</label>
                        <div class="input-group input-group-outline my-3">
                            <textarea name="keterangan_verifikasi" class="form-control @error('keterangan_verifikasi') is-invalid @enderror" rows="3">{{ old('keterangan_verifikasi') }}</textarea>
                        </div>
                        @error('keterangan_verifikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('resign.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-success text-white"><i class="material-symbols-rounded align-middle me-1">check_circle</i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 