@extends('layout.index')

@section('title', 'Tambah Presensi Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Tambah Presensi Baru</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">

                @php $isKaryawan = Auth::user() && Auth::user()->role === 'Karyawan'; @endphp
                @if($isKaryawan)
                    <form action="{{ route('absensi.store') }}" method="POST" class="p-3" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title mb-3">Presensi Masuk</h5>
                                        <div class="mb-2 position-relative" id="container_masuk">
                                            <img id="preview_foto_masuk" src="https://via.placeholder.com/180x180?text=Foto+Masuk" alt="Preview Foto Masuk" class="rounded shadow border" style="max-width:180px;max-height:180px;object-fit:cover;display:block;margin:0 auto 10px;">
                                            <video id="video_masuk" width="180" height="180" autoplay playsinline style="display:none;border-radius:8px;margin:0 auto 10px;"></video>
                                            <button type="button" class="btn btn-secondary w-100" id="startCameraMasukBtn" onclick="startCamera('masuk')" @if($sudahAbsenMasuk) disabled @endif>Aktifkan Kamera</button>
                                            <button type="button" class="btn btn-primary w-100 mt-2" id="takePhotoMasukBtn" style="display:none;" onclick="takePhoto('masuk')">Ambil Foto</button>
                                        </div>
                                        <input type="hidden" name="foto_masuk_data" id="foto_masuk_data">
                                        @error('foto_masuk')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <button type="submit" name="submit_masuk" value="1" class="btn btn-primary btn-lg w-100" @if($sudahAbsenMasuk) disabled @endif>Presensi Masuk</button>
                                        @if($sudahAbsenMasuk)
                                            <div class="text-success mt-2">Sudah presensi masuk hari ini</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="card-title mb-3">Presensi Keluar</h5>
                                        <div class="mb-2 position-relative" id="container_keluar">
                                            <img id="preview_foto_keluar" src="https://via.placeholder.com/180x180?text=Foto+Keluar" alt="Preview Foto Keluar" class="rounded shadow border" style="max-width:180px;max-height:180px;object-fit:cover;display:block;margin:0 auto 10px;">
                                            <video id="video_keluar" width="180" height="180" autoplay playsinline style="display:none;border-radius:8px;margin:0 auto 10px;"></video>
                                            <button type="button" class="btn btn-secondary w-100" id="startCameraKeluarBtn" onclick="startCamera('keluar')" @if(!$sudahAbsenMasuk || $sudahAbsenKeluar) disabled @endif>Aktifkan Kamera</button>
                                            <button type="button" class="btn btn-primary w-100 mt-2" id="takePhotoKeluarBtn" style="display:none;" onclick="takePhoto('keluar')">Ambil Foto</button>
                                        </div>
                                        <input type="hidden" name="foto_keluar_data" id="foto_keluar_data">
                                        @error('foto_keluar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <button type="submit" name="submit_keluar" value="1" class="btn btn-primary btn-lg w-100" @if(!$sudahAbsenMasuk || $sudahAbsenKeluar) disabled @endif>Presensi Keluar</button>
                                        @if($sudahAbsenKeluar)
                                            <div class="text-success mt-2">Sudah presensi keluar hari ini</div>
                                        @elseif(!$sudahAbsenMasuk)
                                            <div class="text-muted mt-2">Presensi masuk dulu sebelum presensi keluar</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary mt-2">Kembali ke Data Presensi</a>
                        </div>
                    </form>
                    <script>
                    let videoStreamMasuk = null;
                    let videoStreamKeluar = null;

                    function startCamera(type) {
                        const video = document.getElementById(type === 'masuk' ? 'video_masuk' : 'video_keluar');
                        const startBtn = document.getElementById(type === 'masuk' ? 'startCameraMasukBtn' : 'startCameraKeluarBtn');
                        const takeBtn = document.getElementById(type === 'masuk' ? 'takePhotoMasukBtn' : 'takePhotoKeluarBtn');
                        const container = document.getElementById('container_' + type);
                        
                        // Tambahkan loading indicator
                        const loadingIndicator = document.createElement('div');
                        loadingIndicator.className = 'text-center mt-2';
                        loadingIndicator.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><div class="mt-2">Memuat kamera...</div>';
                        container.appendChild(loadingIndicator);

                        video.style.display = 'block';
                        startBtn.style.display = 'none';
                        takeBtn.style.display = 'block';
                        takeBtn.disabled = true;

                        // Optimasi constraint kamera
                        const constraints = {
                            video: {
                                width: { ideal: 640 },
                                height: { ideal: 480 },
                                facingMode: 'user',
                                frameRate: { ideal: 30 }
                            }
                        };

                        navigator.mediaDevices.getUserMedia(constraints)
                            .then(function(stream) {
                                if (type === 'masuk') {
                                    videoStreamMasuk = stream;
                                } else {
                                    videoStreamKeluar = stream;
                                }
                                video.srcObject = stream;
                                video.onloadedmetadata = function() {
                                    video.play();
                                };
                                video.onplaying = function() {
                                    takeBtn.disabled = false;
                                    container.removeChild(loadingIndicator);
                                };
                            })
                            .catch(function(err) {
                                console.error('Kamera error:', err);
                                let errorMessage = 'Tidak dapat mengakses kamera. ';
                                
                                switch(err.name) {
                                    case 'NotFoundError':
                                        errorMessage += 'Kamera tidak ditemukan.';
                                        break;
                                    case 'NotAllowedError':
                                        errorMessage += 'Akses kamera ditolak. Mohon izinkan akses kamera di browser Anda.';
                                        break;
                                    case 'NotReadableError':
                                        errorMessage += 'Kamera sedang digunakan aplikasi lain. Mohon tutup aplikasi tersebut.';
                                        break;
                                    default:
                                        errorMessage += err.message;
                                }
                                
                                alert(errorMessage);
                                startBtn.style.display = 'block';
                                takeBtn.style.display = 'none';
                                video.style.display = 'none';
                                container.removeChild(loadingIndicator);
                            });
                    }

                    function takePhoto(type) {
                        const video = document.getElementById(type === 'masuk' ? 'video_masuk' : 'video_keluar');
                        const canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const dataUrl = canvas.toDataURL('image/jpeg');
                        if (type === 'masuk') {
                            document.getElementById('preview_foto_masuk').src = dataUrl;
                            document.getElementById('foto_masuk_data').value = dataUrl;
                            if (videoStreamMasuk) {
                                videoStreamMasuk.getTracks().forEach(track => track.stop());
                                videoStreamMasuk = null;
                            }
                            document.getElementById('video_masuk').style.display = 'none';
                            document.getElementById('takePhotoMasukBtn').style.display = 'none';
                            document.getElementById('startCameraMasukBtn').style.display = 'block';
                        } else {
                            document.getElementById('preview_foto_keluar').src = dataUrl;
                            document.getElementById('foto_keluar_data').value = dataUrl;
                            if (videoStreamKeluar) {
                                videoStreamKeluar.getTracks().forEach(track => track.stop());
                                videoStreamKeluar = null;
                            }
                            document.getElementById('video_keluar').style.display = 'none';
                            document.getElementById('takePhotoKeluarBtn').style.display = 'none';
                            document.getElementById('startCameraKeluarBtn').style.display = 'block';
                        }
                    }
                    </script>
                @else
                    <form action="{{ route('absensi.store') }}" method="POST" class="p-3" enctype="multipart/form-data">
                        @csrf {{-- Laravel CSRF token --}}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pegawai_id" class="form-label">Pegawai</label>
                                    <div class="input-group input-group-outline my-3">
                                        <select name="pegawai_id" id="pegawai_id" class="form-select" required>
                                            <option value="">Pilih Pegawai</option>
                                            @foreach ($pegawais as $pegawai)
                                                <option value="{{ $pegawai->id }}" {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
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
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
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
                                        <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ old('jam_masuk') }}">
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
                                        <input type="time" name="jam_keluar" id="jam_keluar" class="form-control" value="{{ old('jam_keluar') }}">
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
                                            <option value="">Pilih Status</option>
                                            <option value="Hadir" {{ old('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                            <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                            {{-- Tambahkan status lain jika perlu --}}
                                        </select>
                                    </div>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3" id="suratDokterContainer" style="display:none;">
                                    <label for="surat_keterangan_dokter" class="form-label">Surat Keterangan Dokter <span class="text-danger">*</span></label>
                                    <input type="file" name="surat_keterangan_dokter" id="surat_keterangan_dokter" class="form-control" accept="application/pdf,image/*">
                                    @error('surat_keterangan_dokter')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <div class="input-group input-group-outline my-3">
                                        <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
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
                                    <input type="file" name="foto_masuk" id="foto_masuk" class="form-control" accept="image/*">
                                    @error('foto_masuk')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto_keluar" class="form-label">Foto Keluar</label>
                                    <input type="file" name="foto_keluar" id="foto_keluar" class="form-control" accept="image/*">
                                    @error('foto_keluar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Presensi</button>
                        <a href="{{ route('absensi.index') }}" class="btn btn-secondary ms-2">Batal</a>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Kamera -->
<div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cameraModalLabel">Ambil Foto Presensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <video id="videoPreview" width="320" height="240" autoplay playsinline style="border-radius:8px;"></video>
        <canvas id="canvasPreview" width="320" height="240" style="display:none;"></canvas>
        <img id="photoResult" src="" alt="Hasil Foto" style="display:none;max-width:100%;margin-top:10px;" class="rounded shadow">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="takePhotoBtn">Ambil Foto</button>
      </div>
    </div>
  </div>
</div>

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
@endsection 