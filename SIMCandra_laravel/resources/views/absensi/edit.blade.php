@extends('layout.index')

@section('title', 'Edit Absensi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{ $absensi->pegawai->nama_lengkap ?? 'Edit Absensi' }}</h6>                </div>
            </div>
            <div class="card-body px-0 pb-2">

                <form action="{{ route('absensi.update', $absensi->id) }}" method="POST" class="p-3" enctype="multipart/form-data">
                    @csrf {{-- Laravel CSRF token --}}
                    @method('PUT') {{-- Method spoofing for PUT request --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pegawai_id" class="form-label">Pegawai</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="pegawai_id" id="pegawai_id" class="form-select" required>
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}" {{ old('pegawai_id', $absensi->pegawai_id) == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('pegawai_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $absensi->tanggal) }}" required>
                                </div>
                                @error('tanggal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ old('jam_masuk', $absensi->jam_masuk) }}">
                                </div>
                                @error('jam_masuk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="time" name="jam_keluar" id="jam_keluar" class="form-control" value="{{ old('jam_keluar', $absensi->jam_keluar) }}">
                                </div>
                                @error('jam_keluar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="status" id="status" class="form-select" required onchange="toggleSuratDokter()">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Hadir" {{ old('status', $absensi->status) == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="Izin" {{ old('status', $absensi->status) == 'Izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="Sakit" {{ old('status', $absensi->status) == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="Cuti" {{ old('status', $absensi->status) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                        {{-- Tambahkan status lain jika perlu --}}
                                    </select>
                                </div>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="mb-3" id="suratDokterContainer" style="display:none;">
                                    <label for="surat_keterangan_dokter" class="form-label">Surat Keterangan Dokter <span class="text-danger">*</span></label>
                                    <input type="file" name="surat_keterangan_dokter" id="surat_keterangan_dokter" class="form-control" accept="application/pdf,image/*">
                                    @if($absensi->surat_keterangan_dokter)
                                        <a href="{{ asset('storage/' . $absensi->surat_keterangan_dokter) }}" target="_blank" class="btn btn-info btn-sm mt-2">Lihat Surat Lama</a>
                                    @endif
                                    @error('surat_keterangan_dokter')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <div class="input-group input-group-outline my-3">
                                    <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                                </div>
                                @error('keterangan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="foto_masuk" class="form-label">Foto Masuk</label>
                                @if($absensi->foto_masuk)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $absensi->foto_masuk) }}" alt="Foto Masuk" style="max-width: 120px; max-height: 120px;">
                                    </div>
                                @endif
                                <input type="file" name="foto_masuk" id="foto_masuk" class="form-control" accept="image/*">
                                @error('foto_masuk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="foto_keluar" class="form-label">Foto Keluar</label>
                                @if($absensi->foto_keluar)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $absensi->foto_keluar) }}" alt="Foto Keluar" style="max-width: 120px; max-height: 120px;">
                                    </div>
                                @endif
                                <input type="file" name="foto_keluar" id="foto_keluar" class="form-control" accept="image/*">
                                @error('foto_keluar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Absensi</button>
                    <a href="{{ route('absensi.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleSuratDokter() {
    var status = document.getElementById('status').value;
    var suratContainer = document.getElementById('suratDokterContainer');
    var suratInput = document.getElementById('surat_keterangan_dokter');
    if (status === 'Sakit') {
        suratContainer.style.display = 'block';
        suratInput.required = true;
    } else {
        suratContainer.style.display = 'none';
        suratInput.required = false;
        suratInput.value = '';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    toggleSuratDokter();
});
</script>
@endpush 