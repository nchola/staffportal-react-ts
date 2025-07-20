@extends('layout.index')

@section('title', 'Tambah Permohonan Cuti/Izin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Tambah Permohonan Cuti/Izin</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="p-4">
                    <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Form fields --}}
                        <div class="row">
                            {{-- Pegawai selection field (only for HRD) --}}
                            @if(Auth::check() && Auth::user()->role === 'HRD')
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="pegawai_id">Pegawai</label>
                                        <select class="form-control" id="pegawai_id" name="pegawai_id" required>
                                            <option value="">-- Pilih Pegawai --</option>
                                            @foreach ($pegawaiList as $p)
                                                <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }} ({{ $p->nip }})</option>
                                            @endforeach
                                        </select>
                                        @error('pegawai_id')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-{{ (Auth::check() && Auth::user()->role === 'HRD') ? 6 : 12 }}">
                                <div class="input-group input-group-static mb-4">
                                    <label for="jenis_cuti">Jenis Cuti</label>
                                    <select class="form-control" id="jenis_cuti" name="jenis_cuti" required onchange="toggleSuratKeterangan()">
                                        <option value="">-- Pilih Jenis Cuti --</option>
                                        <option value="Cuti Tahunan" {{ old('jenis_cuti') == 'Cuti Tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                                        <option value="Cuti Sakit" {{ old('jenis_cuti') == 'Cuti Sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                                        <option value="Izin" {{ old('jenis_cuti') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="Cuti Melahirkan" {{ old('jenis_cuti') == 'Cuti Melahirkan' ? 'selected' : '' }}>Cuti Melahirkan (Khusus Wanita)</option>
                                        <option value="Cuti Khusus" {{ old('jenis_cuti') == 'Cuti Khusus' ? 'selected' : '' }}>Cuti Khusus</option>
                                    </select>
                                    @error('jenis_cuti')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
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
                                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                    @error('tanggal_selesai')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="alasan">Alasan</label>
                                     {{-- Menggunakan textarea untuk alasan agar lebih luas --}}
                                    <textarea class="form-control" id="alasan" name="alasan" rows="2" required>{{ old('alasan') }}</textarea>
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
                                     {{-- Menggunakan textarea untuk keterangan --}}
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2">{{ old('keterangan') }}</textarea>
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
                                    <input type="file" class="form-control" id="surat_keterangan" name="surat_keterangan" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Format yang diizinkan: PDF, JPG, JPEG, PNG (Maks. 2MB)</small>
                                    @error('surat_keterangan')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Ajukan Permohonan</button>
                            <a href="{{ route('cuti.index') }}" class="btn btn-secondary ms-2">Batal</a>
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
