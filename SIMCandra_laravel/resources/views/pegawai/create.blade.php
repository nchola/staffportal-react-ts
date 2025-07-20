@extends('layout.index')

@section('title', 'Tambah Pegawai Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Tambah Pegawai Baru</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">

                <form action="{{ route('pegawai.store') }}" method="POST" class="p-3">
                    @csrf {{-- Laravel CSRF token --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Menambahkan field Nama Panggilan dan No. KTP --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="nama_panggilan" id="nama_panggilan" class="form-control" value="{{ old('nama_panggilan') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="mb-3">
                                <label for="no_ktp" class="form-label">No. KTP</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ old('no_ktp') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Menambahkan field No. Absensi --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_absensi" class="form-label">No. Absensi</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="no_absensi" id="no_absensi" class="form-control" value="{{ old('no_absensi') }}">
                                </div>
                            </div>
                        </div>
                        {{-- Kolom kosong atau field lain jika perlu --}}
                        <div class="col-md-6">
                            {{-- Placeholder for another field or keep empty --}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="departemen_id" class="form-label">Divisi/Departemen</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="departemen_id" id="departemen_id" class="form-control">
                                        <option value="">Pilih Departemen</option>
                                        @foreach($departemens as $d)
                                            <option value="{{ $d->id }}" {{ old('departemen_id') == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jabatan_id" class="form-label">Jabatan</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="jabatan_id" id="jabatan_id" class="form-control">
                                        <option value="">Pilih Jabatan</option>
                                        @foreach($jabatans as $j)
                                            <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Menambahkan field Atasan Langsung --}}
                    <div class="row">
                         <div class="col-md-12">
                             <div class="mb-3">
                                <label for="atasan_langsung" class="form-label">Atasan Langsung</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="atasan_langsung" id="atasan_langsung" class="form-control" value="{{ old('atasan_langsung') }}">
                                </div>
                            </div>
                         </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                             <div class="mb-3">
                                <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon') }}">
                                </div>
                            </div>
                         </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                             <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <div class="input-group input-group-outline my-3">
                                    <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="agama" id="agama" class="form-select">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        {{-- Tambahkan opsi agama lain jika diperlukan --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                         </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6">
                             <div class="mb-3">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir') }}">
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="status_pernikahan" id="status_pernikahan" class="form-select">
                                        <option value="">Pilih Status Pernikahan</option>
                                        <option value="Belum Menikah" {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                        <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                        <option value="Cerai Hidup" {{ old('status_pernikahan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ old('status_pernikahan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>
                         </div>
                    </div>

                    <div class="row">
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Kepegawaian</label>
                                <div class="input-group input-group-outline my-3">
                                    <select name="status" id="status" class="form-select">
                                        <option value="">Pilih Status</option>
                                        <option value="Pegawai Tetap" {{ old('status') == 'Pegawai Tetap' ? 'selected' : '' }}>Pegawai Tetap</option>
                                        <option value="Pegawai Kontrak" {{ old('status') == 'Pegawai Kontrak' ? 'selected' : '' }}>Pegawai Kontrak</option>
                                        <option value="Pegawai Harian" {{ old('status') == 'Pegawai Harian' ? 'selected' : '' }}>Pegawai Harian</option>
                                        <option value="Magang" {{ old('status') == 'Magang' ? 'selected' : '' }}>Magang</option>
                                        <option value="Probation" {{ old('status') == 'Probation' ? 'selected' : '' }}>Probation</option>
                                        {{-- Tambahkan opsi status lain jika diperlukan --}}
                                    </select>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                                <div class="input-group input-group-outline my-3">
                                    <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-control" value="{{ old('tanggal_bergabung') }}" required>
                                </div>
                            </div>
                         </div>
                    </div>

                    {{-- user_id will likely be handled by authentication later, not a direct form input --}}

                    <button type="submit" class="btn btn-primary">Simpan Pegawai</button>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function() {
    $('#departemen_id').on('change', function() {
        var depId = $(this).val();
        var $jabatan = $('#jabatan_id');
        $jabatan.empty().append('<option value="">-</option>');
        if(depId) {
            $.get('/departemen/' + depId + '/jabatans', function(data) {
                data.forEach(function(jab) {
                    $jabatan.append('<option value="'+jab.id+'">'+jab.nama+'</option>');
                });
            });
        }
    });
});
</script>
@endsection 