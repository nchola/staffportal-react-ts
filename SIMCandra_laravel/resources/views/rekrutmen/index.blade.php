@extends('layout.index')

@section('title', Auth::user() && Auth::user()->role === 'Calon Karyawan' ? 'Lowongan Kerja' : 'Daftar Lowongan Rekrutmen')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">
                        {{ Auth::user() && Auth::user()->role === 'Calon Karyawan' ? 'Lowongan Kerja Tersedia' : 'Daftar Lowongan Rekrutmen' }}
                    </h6>
                    @if(Auth::check() && Auth::user()->role === 'HRD')
                        <div class="d-flex non-printable gap-2">
                            <a href="{{ route('rekrutmen.create') }}" class="btn btn-success text-white me-3">
                                <i class="material-symbols-rounded align-middle me-1">add</i>Tambah Lowongan</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body px-3 py-2">
                <div class="row g-4">
                    @forelse($rekrutmens as $r)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="material-symbols-rounded text-primary me-2" style="font-size: 2.2rem;">work</span>
                                    <h5 class="mb-0 flex-grow-1">{{ $r->judul }}</h5>
                                    <span class="badge ms-2 badge-sm bg-gradient-{{ $r->status === 'Aktif' ? 'success' : ($r->status === 'Tutup' ? 'danger' : 'secondary') }}">{{ $r->status ?? '-' }}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="text-muted small"><i class="material-symbols-rounded align-middle me-1" style="font-size: 1.1rem;">calendar_month</i> Buka: {{ $r->tanggal_buka }} | Tutup: {{ $r->tanggal_tutup }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Kualifikasi:</strong>
                                    <div class="text-muted small">{{ \Illuminate\Support\Str::limit($r->kualifikasi, 80) }}</div>
                                </div>
                                <div class="mb-2 flex-grow-1">
                                    <strong>Deskripsi:</strong>
                                    <div class="text-muted small">{{ \Illuminate\Support\Str::limit($r->deskripsi, 80) }}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-auto gap-2">
                                    <a href="{{ route('rekrutmen.show', $r->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1"><i class="material-symbols-rounded align-middle me-1">info</i> Detail</a>
                                    @if(Auth::user() && Auth::user()->role === 'Calon Karyawan')
                                    @php $sudahMelamar = $r->lamarans->where('user_id', Auth::id())->first(); @endphp
                                    @if(!$sudahMelamar && $r->status === 'Aktif')
                                        <a href="{{ route('lamaran.create', ['rekrutmen_id' => $r->id]) }}" class="btn btn-primary btn-sm flex-grow-1"><i class="material-symbols-rounded align-middle me-1">send</i> Lamar</a>
                                    @elseif($sudahMelamar)
                                        <span class="badge bg-gradient-info align-self-center flex-grow-1">Sudah Dilamar</span>
                                        @endif
                                    @endif
                                    @if(Auth::user() && Auth::user()->role === 'HRD')
                                        <a href="{{ route('rekrutmen.edit', $r->id) }}" class="btn btn-warning btn-sm flex-grow-1"><i class="material-symbols-rounded align-middle me-1">edit</i> Edit</a>
                                        <form action="{{ route('rekrutmen.destroy', $r->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm flex-grow-1"><i class="material-symbols-rounded align-middle me-1">delete</i> Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="material-symbols-rounded" style="font-size: 3rem;">work_off</i><br>
                        Tidak ada lowongan tersedia saat ini.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
{{-- CSS untuk print --}}
<style>
    @media print {
        .non-printable,
        .sidenav,
        .navbar,
        .card-header .bg-gradient-dark {
            display: none !important;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        body { margin: 0; padding: 0; }
        .card, .row, .col-12 { box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
        .table-responsive { overflow: visible !important; }
    }
</style>
@endsection 