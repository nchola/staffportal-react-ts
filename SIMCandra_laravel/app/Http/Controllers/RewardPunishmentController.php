<?php

namespace App\Http\Controllers;

use App\Models\RewardPunishment;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RewardPunishmentController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'Karyawan') {
            $pegawai = auth()->user()->pegawai;
            $rewardPunishments = $pegawai
                ? RewardPunishment::with('karyawan')->where('id_karyawan', $pegawai->id)->get()
                : collect();
        } else {
            $rewardPunishments = RewardPunishment::with('karyawan')->get();
        }
        return view('rewardpunishment.index', compact('rewardPunishments'));
    }

    public function create()
    {
        $karyawan = Pegawai::all();
        return view('rewardpunishment.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_karyawan' => 'required|exists:pegawais,id',
                'jenis' => 'required|in:Reward,Punishment',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string',
                'reward' => 'nullable|integer|required_if:jenis,Reward',
                'surat_punishment' => 'nullable|file|mimes:pdf,jpg,png|required_if:jenis,Punishment',
            ]);

            $data = $request->only(['id_karyawan', 'jenis', 'tanggal', 'keterangan', 'reward']);
            $data['status'] = $request->status ?? 'Menunggu';

            if ($request->hasFile('surat_punishment')) {
                $file = $request->file('surat_punishment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->store('surat_punishment', 'public');
                $data['surat_punishment'] = $path;
            }

            RewardPunishment::create($data);

            return redirect()->route('rewardpunishment.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('rewardpunishment.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $rewardPunishment = RewardPunishment::findOrFail($id);
            $karyawan = Pegawai::all();
            return view('rewardpunishment.edit', compact('rewardPunishment', 'karyawan'));
        } catch (\Exception $e) {
            return redirect()->route('rewardpunishment.index')->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id_karyawan' => 'required|exists:pegawais,id',
                'jenis' => 'required|in:Reward,Punishment',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string',
                'reward' => 'nullable|integer|required_if:jenis,Reward',
                'surat_punishment' => 'nullable|file|mimes:pdf,jpg,png',
            ]);

            $rewardPunishment = RewardPunishment::findOrFail($id);
            $data = $request->only(['id_karyawan', 'jenis', 'tanggal', 'keterangan', 'status']);

            if ($request->jenis === 'Reward') {
                $data['reward'] = $request->reward;
                $data['surat_punishment'] = null;
                if ($rewardPunishment->surat_punishment && Storage::exists($rewardPunishment->surat_punishment)) {
                    Storage::delete($rewardPunishment->surat_punishment);
                }
            }

            if ($request->jenis === 'Punishment') {
                $data['reward'] = null;
                if ($request->hasFile('surat_punishment')) {
                    $file = $request->file('surat_punishment');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->store('surat_punishment', 'public');
                    if ($rewardPunishment->surat_punishment && Storage::exists($rewardPunishment->surat_punishment)) {
                        Storage::delete($rewardPunishment->surat_punishment);
                    }
                    $data['surat_punishment'] = $path;
                } else {
                    $data['surat_punishment'] = $rewardPunishment->surat_punishment;
                }
            }

            $rewardPunishment->update($data);

            return redirect()->route('rewardpunishment.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('rewardpunishment.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $rewardPunishment = RewardPunishment::findOrFail($id);
            if ($rewardPunishment->jenis === 'Punishment' && $rewardPunishment->surat_punishment && Storage::exists($rewardPunishment->surat_punishment)) {
                Storage::delete($rewardPunishment->surat_punishment);
            }
            $rewardPunishment->delete();
            return redirect()->route('rewardpunishment.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('rewardpunishment.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function status(Request $request, $id)
    {
        try {
            $rewardPunishment = RewardPunishment::findOrFail($id);
            $rewardPunishment->update(['status' => $request->status]);
            return redirect()->route('rewardpunishment.index')->with('success', 'Status berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('rewardpunishment.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function verify(Request $request, $id)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['HRD', 'Kepala Unit'])) {
            return redirect()->route('rewardpunishment.index')->with('error', 'Anda tidak memiliki akses untuk verifikasi.');
        }
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak',
            'keterangan' => 'nullable|string',
        ]);
        $rewardPunishment = RewardPunishment::findOrFail($id);
        $rewardPunishment->status = $request->status;
        if ($request->filled('keterangan')) {
            $rewardPunishment->keterangan = $request->keterangan;
        }
        $rewardPunishment->save();
        return redirect()->route('rewardpunishment.index')->with('success', 'Status berhasil diverifikasi.');
    }

    public function show($id)
    {
        $rewardPunishment = RewardPunishment::with('karyawan')->findOrFail($id);
        return view('rewardpunishment.show', compact('rewardPunishment'));
    }
} 