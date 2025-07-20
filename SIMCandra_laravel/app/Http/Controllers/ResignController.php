<?php
namespace App\Http\Controllers;

use App\Models\Resign;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ResignController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'Karyawan') {
            $pegawai = Auth::user()->pegawai;
            $resigns = $pegawai ? Resign::with('pegawai')->where('pegawai_id', $pegawai->id)->get() : collect();
        } else {
            $resigns = Resign::with('pegawai')->get();
        }
        return view('resign.index', compact('resigns'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'Karyawan') abort(403);
        return view('resign.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'Karyawan') abort(403);
        $pegawai = $user->pegawai;
        $request->validate([
            'tanggal_resign' => 'required|date|after_or_equal:today',
            'alasan' => 'required|string',
            'surat_resign' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);
        $data = [
            'pegawai_id' => $pegawai->id,
            'tanggal_pengajuan' => now()->toDateString(),
            'tanggal_resign' => $request->tanggal_resign,
            'alasan' => $request->alasan,
            'status' => 'Menunggu',
        ];
        if ($request->hasFile('surat_resign')) {
            $data['surat_resign'] = $request->file('surat_resign')->store('resign', 'public');
        }
        Resign::create($data);
        return redirect()->route('resign.index')->with('success', 'Pengajuan resign berhasil.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $resign = Resign::findOrFail($id);
        if ($user->role !== 'Karyawan' || $resign->pegawai_id !== $user->pegawai->id || $resign->status !== 'Menunggu') abort(403);
        return view('resign.edit', compact('resign'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $resign = Resign::findOrFail($id);
        if ($user->role !== 'Karyawan' || $resign->pegawai_id !== $user->pegawai->id || $resign->status !== 'Menunggu') abort(403);
        $request->validate([
            'tanggal_resign' => 'required|date|after_or_equal:today',
            'alasan' => 'required|string',
            'surat_resign' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);
        $data = [
            'tanggal_resign' => $request->tanggal_resign,
            'alasan' => $request->alasan,
        ];
        if ($request->hasFile('surat_resign')) {
            // Hapus file lama jika ada
            if ($resign->surat_resign && Storage::disk('public')->exists($resign->surat_resign)) {
                Storage::disk('public')->delete($resign->surat_resign);
            }
            $data['surat_resign'] = $request->file('surat_resign')->store('resign', 'public');
        }
        $resign->update($data);
        return redirect()->route('resign.index')->with('success', 'Pengajuan resign berhasil diupdate.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $resign = Resign::with('pegawai')->findOrFail($id);
        if ($user->role === 'Karyawan' && $resign->pegawai_id !== $user->pegawai->id) abort(403);
        return view('resign.show', compact('resign'));
    }

    public function verify(Request $request, $id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['HRD', 'Kepala Unit'])) abort(403);
        $resign = Resign::findOrFail($id);
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'keterangan_verifikasi' => 'nullable|string',
        ]);
        $resign->update([
            'status' => $request->status,
            'keterangan_verifikasi' => $request->keterangan_verifikasi,
            'tanggal_verifikasi' => now()->toDateString(),
            'verifikasi_oleh' => $user->id,
        ]);
        return redirect()->route('resign.index')->with('success', 'Resign berhasil diverifikasi.');
    }

    public function print($id)
    {
        $user = Auth::user();
        $resign = Resign::with('pegawai')->findOrFail($id);
        if ($user->role === 'Karyawan' && $resign->pegawai_id !== $user->pegawai->id) abort(403);
        // HRD dan Kepala Unit bisa print semua
        return view('resign.print', compact('resign'));
    }
} 