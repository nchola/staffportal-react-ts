@extends('layout.index')
@section('title', 'Tambah Pengguna')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6><i class="material-symbols-rounded align-middle me-2">person_add</i>Tambah Pengguna</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Nama lengkap">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required placeholder="Username unik">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <div class="input-group input-group-outline my-2">
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="HRD" {{ old('role') == 'HRD' ? 'selected' : '' }}>HRD</option>
                                    <option value="Kepala Unit" {{ old('role') == 'Kepala Unit' ? 'selected' : '' }}>Kepala Unit</option>
                                    <option value="Karyawan" {{ old('role') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                    <option value="Calon Karyawan" {{ old('role') == 'Calon Karyawan' ? 'selected' : '' }}>Calon Karyawan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3" id="pegawaiDropdown" style="display: none;">
                            <label for="pegawai_id" class="form-label">Pilih Pegawai</label>
                            <div class="input-group input-group-outline my-2">
                                <select class="form-select" id="pegawai_id" name="pegawai_id">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->nama_lengkap }} ({{ $pegawai->nip }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Minimal 6 karakter">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group input-group-outline my-2">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
                            </div>
                        </div>
                        <button type="submit" class="btn bg-gradient-dark">Simpan</button>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var roleSelect = document.getElementById('role');
    var pegawaiDropdown = document.getElementById('pegawaiDropdown');
    function togglePegawaiDropdown() {
        if (roleSelect.value === 'Karyawan') {
            pegawaiDropdown.style.display = '';
            document.getElementById('pegawai_id').setAttribute('required', 'required');
        } else {
            pegawaiDropdown.style.display = 'none';
            document.getElementById('pegawai_id').removeAttribute('required');
        }
    }
    roleSelect.addEventListener('change', togglePegawaiDropdown);
    togglePegawaiDropdown();
});
</script>
@endsection 