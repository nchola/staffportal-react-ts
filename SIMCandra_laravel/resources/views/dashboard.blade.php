@extends('layout.index')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Info Card Statistik -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                    <i class="material-symbols-rounded fs-3">group</i>
                </div>
                <div>
                    <h6 class="mb-0">Pegawai</h6>
                    <h4 class="mb-0">{{ $pegawaiCount }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-gradient-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                    <i class="material-symbols-rounded fs-3">calendar_month</i>
                </div>
                <div>
                    <h6 class="mb-0">Cuti Aktif</h6>
                    <h4 class="mb-0">{{ $cutiAktifCount }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-gradient-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                    <i class="material-symbols-rounded fs-3">work</i>
                </div>
                <div>
                    <h6 class="mb-0">Lowongan</h6>
                    <h4 class="mb-0">{{ $lowonganCount }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-gradient-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                    <i class="material-symbols-rounded fs-3">sync_alt</i>
                </div>
                <div>
                    <h6 class="mb-0">Mutasi</h6>
                    <h4 class="mb-0">{{ $mutasiCount }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-gradient-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                    <i class="material-symbols-rounded fs-3">star</i>
                </div>
                <div>
                    <h6 class="mb-0">Reward</h6>
                    <h4 class="mb-0">{{ $rewardCount }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="bg-gradient-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                    <i class="material-symbols-rounded fs-3">gavel</i>
                </div>
                <div>
                    <h6 class="mb-0">Punishment</h6>
                    <h4 class="mb-0">{{ $punishmentCount }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 