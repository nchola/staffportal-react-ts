@extends('layout.index')
@section('title', 'Edit Pengajuan Resign')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-warning shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Edit Pengajuan Resign</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form method="POST" action="{{ route('resign.update', $resign->id) }}" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Resign</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="date" name="tanggal_resign" class="form-control @error('tanggal_resign') is-invalid @enderror" value="{{ old('tanggal_resign', $resign->tanggal_resign) }}" required>
                                </div>
                                @error('tanggal_resign')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Alasan</label>
                                <div class="input-group input-group-outline my-3">
                                    <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="3" required>{{ old('alasan', $resign->alasan) }}</textarea>
                                </div>
                                @error('alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Surat Resign (PDF/JPG/PNG, opsional)</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="file" name="surat_resign" class="form-control @error('surat_resign') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                @if($resign->surat_resign)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/'.$resign->surat_resign) }}" target="_blank">Lihat Surat Resign</a>
                                    </div>
                                @endif
                                @error('surat_resign')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('resign.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 