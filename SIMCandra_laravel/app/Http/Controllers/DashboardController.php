<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Cuti;
use App\Models\Rekrutmen;
use App\Models\Mutasi;
use App\Models\RewardPunishment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pegawaiCount = Pegawai::count();
        $cutiAktifCount = Cuti::where('status', 'Disetujui')->whereDate('tanggal_selesai', '>=', now())->count();
        $lowonganCount = Rekrutmen::where('status', 'Dibuka')->count();
        $mutasiCount = Mutasi::count();
        $rewardCount = RewardPunishment::where('jenis', 'Reward')->count();
        $punishmentCount = RewardPunishment::where('jenis', 'Punishment')->count();
        
        return view('dashboard', compact('pegawaiCount', 'cutiAktifCount', 'lowonganCount', 'mutasiCount', 'rewardCount', 'punishmentCount'));
    }
} 