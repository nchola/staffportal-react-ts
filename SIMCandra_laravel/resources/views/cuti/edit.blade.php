@extends('layout.index')

@section('title', 'Edit Permohonan Cuti/Izin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">{{ $cuti->pegawai->nama_lengkap ?? 'Edit Permohonan Cuti/Izin' }}</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-4">
                    <form action="{{ route('cuti.update', $cuti->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="jenis_cuti">Jenis Cuti</label>
                                    <select class="form-control" id="jenis_cuti" name="jenis_cuti" required onchange="toggleSuratKeterangan()">
                                        <option value="">-- Pilih Jenis Cuti --</option>
                                        <option value="Cuti Tahunan" {{ (old('jenis_cuti', $cuti->jenis_cuti) == 'Cuti Tahunan') ? 'selected' : '' }}>Cuti Tahunan</option>
                                        <option value="Cuti Sakit" {{ (old('jenis_cuti', $cuti->jenis_cuti) == 'Cuti Sakit') ? 'selected' : '' }}>Cuti Sakit</option>
                                        <option value="Izin" {{ (old('jenis_cuti', $cuti->jenis_cuti) == 'Izin') ? 'selected' : '' }}>Izin</option>
                                        <option value="Cuti Melahirkan" {{ (old('jenis_cuti', $cuti->jenis_cuti) == 'Cuti Melahirkan') ? 'selected' : '' }}>Cuti Melahirkan (Khusus Wanita)</option>
                                        <option value="Cuti Khusus" {{ (old('jenis_cuti', $cuti->jenis_cuti) == 'Cuti Khusus') ? 'selected' : '' }}>Cuti Khusus</option>
                                    </select>
                                    @error('jenis_cuti')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $cuti->tanggal_mulai ? \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('Y-m-d') : '') }}" required>
                                    @error('tanggal_mulai')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $cuti->tanggal_selesai ? \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('Y-m-d') : '') }}" required>
                                    @error('tanggal_selesai')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="alasan">Alasan</label>
                                    <textarea class="form-control" id="alasan" name="alasan" rows="2" required>{{ old('alasan', $cuti->alasan) }}</textarea>
                                    @error('alasan')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group input-group-static mb-4">
                                    <label for="keterangan">Keterangan (Opsional)</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2">{{ old('keterangan', $cuti->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" id="surat_keterangan_container" style="display: none;">
                                <div class="input-group input-group-static mb-4">
                                    <label for="surat_keterangan">Surat Keterangan</label>
                                    @if($cuti->surat_keterangan)
                                        <div class="mb-2">
                                            <p class="mb-1">Surat keterangan saat ini:</p>
                                            <a href="{{ asset('storage/' . $cuti->surat_keterangan) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="material-symbols-rounded">visibility</i> Lihat Surat
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" id="surat_keterangan" name="surat_keterangan" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Format yang diizinkan: PDF, JPG, JPEG, PNG (Maks. 2MB)</small>
                                    @error('surat_keterangan')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if(Auth::check() && Auth::user()->role === 'HRD')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">-- Biarkan Kosong --</option>
                                            <option value="Pending" {{ (old('status', $cuti->status) == 'Pending') ? 'selected' : '' }}>Pending</option>
                                            <option value="Disetujui" {{ (old('status', $cuti->status) == 'Disetujui') ? 'selected' : '' }}>Disetujui</option>
                                            <option value="Ditolak" {{ (old('status', $cuti->status) == 'Ditolak') ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        @error('status')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <button type="submit" class="btn bg-gradient-primary">Simpan Perubahan</button>
                            <a href="{{ route('cuti.show', $cuti->id) }}" class="btn btn-outline-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleSuratKeterangan() {
    const jenisCuti = document.getElementById('jenis_cuti').value;
    const suratKeteranganContainer = document.getElementById('surat_keterangan_container');
    const suratKeteranganInput = document.getElementById('surat_keterangan');
    
    if (['Cuti Sakit', 'Cuti Melahirkan', 'Cuti Khusus'].includes(jenisCuti)) {
        suratKeteranganContainer.style.display = 'block';
        suratKeteranganInput.required = true;
    } else {
        suratKeteranganContainer.style.display = 'none';
        suratKeteranganInput.required = false;
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleSuratKeterangan();
});
</script>
@endsection 