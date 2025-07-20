<?php
namespace App\Http\Controllers;

use App\Models\Phk;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            $phks = $pegawai ? Phk::with('pegawai')->where('pegawai_id', $pegawai->id)->get() : collect();
        } else {
            $phks = Phk::with('pegawai')->get();
        }
        return view('phk.index', compact('phks'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'HRD') abort(403);
        $pegawais = Pegawai::all();
        return view('phk.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'HRD') abort(403);
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'keterangan' => 'required|string',
            'status' => 'required|string',
            'surat_phk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);
        $data = $request->only(['pegawai_id','keterangan','status']);
        if ($request->hasFile('surat_phk')) {
            $data['surat_phk'] = $request->file('surat_phk')->store('phk', 'public');
        }
        Phk::create($data);
        return redirect()->route('phk.index')->with('success', 'Data PHK berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $phk = Phk::with('pegawai')->findOrFail($id);
        if ($user->role === 'Karyawan' && $phk->pegawai_id !== $user->pegawai->id) abort(403);
        return view('phk.show', compact('phk'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        if ($user->role !== 'HRD') abort(403);
        $phk = Phk::findOrFail($id);
        $pegawais = Pegawai::all();
        return view('phk.edit', compact('phk','pegawais'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'HRD') abort(403);
        $phk = Phk::findOrFail($id);
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'keterangan' => 'required|string',
            'status' => 'required|string',
            'surat_phk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);
        $data = $request->only(['pegawai_id','keterangan','status']);
        if ($request->hasFile('surat_phk')) {
            if ($phk->surat_phk && Storage::disk('public')->exists($phk->surat_phk)) {
                Storage::disk('public')->delete($phk->surat_phk);
            }
            $data['surat_phk'] = $request->file('surat_phk')->store('phk', 'public');
        }
        $phk->update($data);
        return redirect()->route('phk.index')->with('success', 'Data PHK berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->role !== 'HRD') abort(403);
        $phk = Phk::findOrFail($id);
        if ($phk->surat_phk && Storage::disk('public')->exists($phk->surat_phk)) {
            Storage::disk('public')->delete($phk->surat_phk);
        }
        $phk->delete();
        return redirect()->route('phk.index')->with('success', 'Data PHK berhasil dihapus.');
    }

    public function print($id)
    {
        $user = Auth::user();
        $phk = Phk::with('pegawai')->findOrFail($id);
        if ($user->role === 'Karyawan' && $phk->pegawai_id !== $user->pegawai->id) abort(403);
        // HRD dan Kepala Unit bisa print semua
        return view('phk.print', compact('phk'));
    }

    public function verify(Request $request, $id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['HRD', 'Kepala Unit'])) abort(403);

        $phk = Phk::findOrFail($id);
        if ($phk->status !== 'Menunggu') {
            return back()->with('error', 'Data sudah diverifikasi.');
        }

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'keterangan_verifikasi' => 'nullable|string',
        ]);

        $phk->status = $request->status;
        $phk->tanggal_verifikasi = now()->toDateString();
        $phk->verifikasi_oleh = $user->id;
        if ($request->filled('keterangan_verifikasi')) {
            $phk->keterangan = $request->keterangan_verifikasi;
        }
        $phk->save();

        return redirect()->route('phk.index')->with('success', 'PHK berhasil diverifikasi.');
    }
} 