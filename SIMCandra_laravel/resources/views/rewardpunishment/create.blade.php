@extends('layout.index')
@section('title', 'Tambah Reward / Punishment')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Tambah Reward / Punishment</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ route('rewardpunishment.store') }}" method="POST" enctype="multipart/form-data" class="p-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_karyawan" class="form-label">Karyawan</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="id_karyawan" id="id_karyawan" class="form-select" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($karyawan as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_lengkap }} (NIP: {{ $k->nip }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="jenis" id="jenis" class="form-select" required onchange="toggleFields()">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Reward">Reward</option>
                                        <option value="Punishment">Punishment</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <div class="input-group input-group-outline my-3">
                                    <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="Diterima" {{ old('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        <option value="Menunggu" {{ old('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="rewardField" style="display:none;">
                            <div class="mb-3">
                                <label for="reward" class="form-label">Reward (Rp)</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="number" name="reward" id="reward" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="suratPunishmentField" style="display:none;">
                            <div class="mb-3">
                                <label for="surat_punishment" class="form-label">Surat Punishment (PDF/JPG/PNG)</label>
                                <input type="file" name="surat_punishment" id="surat_punishment" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('rewardpunishment.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function toggleFields() {
    var jenis = document.getElementById('jenis').value;
    document.getElementById('rewardField').style.display = jenis === 'Reward' ? '' : 'none';
    document.getElementById('suratPunishmentField').style.display = jenis === 'Punishment' ? '' : 'none';
}
document.getElementById('jenis').addEventListener('change', toggleFields);
</script>
@endsection 