@extends('layout.index')

@section('title', 'Tambah Promosi/Demosi')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Tambah Promosi/Demosi</h6>
                </div>
            </div>
            <div class="card-body px-4 py-3">
                <form action="{{ route('mutasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pegawai</label>
                        <select name="pegawai_id" id="pegawai_id" class="form-select border" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }} (NIP: {{ $pegawai->nip }})</option>
                            @endforeach
                        </select>
                        @error('pegawai_id')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="departemen_lama_nama" class="form-label">Departemen Lama</label>
                            <input type="text" id="departemen_lama_nama" class="form-control border" readonly>
                            <input type="hidden" name="departemen_lama_id" id="departemen_lama_id">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="departemen_baru_id" class="form-label">Departemen Baru</label>
                            <select name="departemen_baru_id" id="departemen_baru_id" class="form-select border">
                                <option value="">-</option>
                                @foreach($departemens as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jabatan_lama_nama" class="form-label">Jabatan Lama</label>
                            <input type="text" id="jabatan_lama_nama" class="form-control border" readonly>
                            <input type="hidden" name="jabatan_lama_id" id="jabatan_lama_id">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jabatan_baru_id" class="form-label">Jabatan Baru</label>
                            <select name="jabatan_baru_id" id="jabatan_baru_id" class="form-select border">
                                <option value="">-</option>
                                @foreach($jabatans as $jab)
                                    <option value="{{ $jab->id }}">{{ $jab->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Promosi/Demosi</label>
                        <input type="text" name="alasan" id="alasan" class="form-control border" required>
                        @error('alasan')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Promosi/Demosi</label>
                        <select name="jenis" id="jenis" class="form-select border" required>
                            <option value="promosi">Promosi</option>
                            <option value="demosi">Demosi</option>
                        </select>
                        @error('jenis')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control border"></textarea>
                        @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_efektif" class="form-label">Tanggal Efektif</label>
                        <input type="date" name="tanggal_efektif" id="tanggal_efektif" class="form-control border" required>
                        @error('tanggal_efektif')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
                        <select name="status_verifikasi" id="status_verifikasi" class="form-select border" required>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        @error('status_verifikasi')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_ketetapan" class="form-label">Status Ketetapan Karyawan</label>
                        <select name="status_ketetapan" id="status_ketetapan" class="form-select border" required>
                            <option value="Tetap">Tetap</option>
                            <option value="Sementara">Sementara</option>
                            <option value="Uji Coba">Uji Coba</option>
                        </select>
                        @error('status_ketetapan')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="dokumen" class="form-label">Upload Dokumen (opsional)</label>
                        <input type="file" name="dokumen" id="dokumen" class="form-control border" accept=".pdf,.jpg,.jpeg,.png">
                        @error('dokumen')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                        <a href="{{ route('mutasi.index') }}" class="btn btn-secondary btn-lg">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function() {
    // Sinkronisasi data lama
    $('#pegawai_id').on('change', function() {
        var pegawaiId = $(this).val();
        if (pegawaiId) {
            $.get('/pegawai/' + pegawaiId + '/info', function(data) {
                if(data.departemen) {
                    $('#departemen_lama_nama').val(data.departemen.nama);
                    $('#departemen_lama_id').val(data.departemen.id);
                } else {
                    $('#departemen_lama_nama').val('');
                    $('#departemen_lama_id').val('');
                }
                if(data.jabatan) {
                    $('#jabatan_lama_nama').val(data.jabatan.nama);
                    $('#jabatan_lama_id').val(data.jabatan.id);
                } else {
                    $('#jabatan_lama_nama').val('');
                    $('#jabatan_lama_id').val('');
                }
            });
        } else {
            $('#departemen_lama_nama').val('');
            $('#departemen_lama_id').val('');
            $('#jabatan_lama_nama').val('');
            $('#jabatan_lama_id').val('');
        }
    });
    // Dependent dropdown jabatan baru
    $('#departemen_baru_id').on('change', function() {
        var depId = $(this).val();
        var $jabatanBaru = $('#jabatan_baru_id');
        $jabatanBaru.empty().append('<option value="">-</option>');
        if(depId) {
            $.get('/departemen/' + depId + '/jabatans', function(data) {
                data.forEach(function(jab) {
                    $jabatanBaru.append('<option value="'+jab.id+'">'+jab.nama+'</option>');
                });
            });
        }
    });
});
</script>
@endsection 