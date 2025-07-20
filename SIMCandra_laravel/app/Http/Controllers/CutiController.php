<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CutiController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Cuti::class);
        $user = Auth::user();
        if ($user->role === 'HRD' || $user->role === 'Kepala Unit') {
            $cutis = Cuti::with('pegawai')->get();
        } elseif ($user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            $cutis = $pegawai ? Cuti::with('pegawai')->where('pegawai_id', $pegawai->id)->get() : collect();
        } else {
            $cutis = collect();
        }
        return view('cuti.index', compact('cutis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Cuti::class);
        $pegawaiList = collect();
        if (Auth::check() && Auth::user()->role === 'HRD') {
            $pegawaiList = Pegawai::all();
        }
        return view('cuti.create', compact('pegawaiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cuti::class);
        $user = Auth::user();
        
        $rules = [
            'alasan' => 'required|string|max:255',
            'jenis_cuti' => 'required|in:Cuti Tahunan,Cuti Sakit,Izin,Cuti Melahirkan,Cuti Khusus',
            'keterangan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ];

        // Tambahkan validasi surat keterangan untuk jenis cuti tertentu
        if (in_array($request->jenis_cuti, ['Cuti Sakit', 'Cuti Melahirkan', 'Cuti Khusus'])) {
            $rules['surat_keterangan'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        if ($user->role === 'HRD') {
            $rules['pegawai_id'] = 'required|exists:pegawais,id';
        }

        $validated = $request->validate($rules);

        if ($user->role === 'HRD') {
            $validated['pegawai_id'] = $request->pegawai_id;
        } elseif ($user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            if (!$pegawai) {
                return back()->withErrors(['pegawai_id' => 'Akun Anda belum terhubung dengan data pegawai.'])->withInput();
            }
            $validated['pegawai_id'] = $pegawai->id;
        } else {
            return back()->withErrors(['error' => 'Akses ditolak.'])->withInput();
        }

        // Handle file upload jika ada
        if ($request->hasFile('surat_keterangan')) {
            $file = $request->file('surat_keterangan');
            $path = $file->store('surat_keterangan', 'public');
            $validated['surat_keterangan'] = $path;
        }

        $cuti = Cuti::create($validated);
        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cuti = Cuti::with('pegawai')->findOrFail($id);
        $this->authorize('view', $cuti);
        return view('cuti.show', compact('cuti'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cuti = Cuti::with('pegawai')->findOrFail($id);
        $this->authorize('update', $cuti);
        $pegawaiList = collect();
        if (Auth::check() && Auth::user()->role === 'HRD') {
            $pegawaiList = Pegawai::all();
        }
        return view('cuti.edit', compact('cuti', 'pegawaiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cuti = Cuti::findOrFail($id);
        $this->authorize('update', $cuti);
        $user = Auth::user();
        
        $rules = [
            'alasan' => 'sometimes|required|string|max:255',
            'jenis_cuti' => 'sometimes|required|in:Cuti Tahunan,Cuti Sakit,Izin,Cuti Melahirkan,Cuti Khusus',
            'keterangan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'sometimes|required|date',
            'tanggal_selesai' => 'sometimes|required|date|after_or_equal:tanggal_mulai',
        ];

        // Tambahkan validasi surat keterangan untuk jenis cuti tertentu
        if (in_array($request->jenis_cuti ?? $cuti->jenis_cuti, ['Cuti Sakit', 'Cuti Melahirkan', 'Cuti Khusus'])) {
            $rules['surat_keterangan'] = 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        if ($user->role === 'HRD') {
            $rules['pegawai_id'] = 'sometimes|required|exists:pegawais,id';
            $rules['status'] = 'sometimes|nullable|string|max:255';
            $rules['tanggal_verifikasi'] = 'sometimes|nullable|date';
        }

        $validated = $request->validate($rules);

        if ($user->role === 'HRD' && $request->has('pegawai_id')) {
            $cuti->pegawai_id = $validated['pegawai_id'];
            unset($validated['pegawai_id']);
        }

        // Handle file upload jika ada
        if ($request->hasFile('surat_keterangan')) {
            // Hapus file lama jika ada
            if ($cuti->surat_keterangan) {
                Storage::disk('public')->delete($cuti->surat_keterangan);
            }
            $file = $request->file('surat_keterangan');
            $path = $file->store('surat_keterangan', 'public');
            $validated['surat_keterangan'] = $path;
        }

        if ($user->role === 'HRD' && $request->has('status')) {
            $cuti->status = $validated['status'];
            if ($request->has('tanggal_verifikasi')) {
                $cuti->tanggal_verifikasi = $validated['tanggal_verifikasi'];
                unset($validated['tanggal_verifikasi']);
            }
            unset($validated['status']);
        }

        $cuti->update($validated);
        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuti = Cuti::findOrFail($id);
        $this->authorize('delete', $cuti);
        
        // Hapus file surat keterangan jika ada
        if ($cuti->surat_keterangan) {
            Storage::disk('public')->delete($cuti->surat_keterangan);
        }
        
        $cuti->delete();
        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti berhasil dihapus.');
    }

    /**
     * Verify the specified cuti application (approve/reject by Admin only).
     */
    public function verify(Request $request, string $id)
    {
        $cuti = Cuti::findOrFail($id);
        $this->authorize('verify', $cuti);

        // Tambahkan validasi untuk memastikan surat keterangan ada jika diperlukan
        if ($cuti->requiresSuratKeterangan() && !$cuti->surat_keterangan) {
            return back()->withErrors(['error' => 'Surat keterangan wajib dilampirkan untuk jenis cuti ini.']);
        }

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $cuti->status = $request->status;
        $cuti->tanggal_verifikasi = Carbon::now();
        $cuti->save();

        return redirect()->route('cuti.index')->with('success', 'Permohonan cuti berhasil diverifikasi.');
    }

    /**
     * Generate a printable document for the specified cuti application.
     */
    public function print(string $id)
    {
        $cuti = Cuti::with('pegawai')->findOrFail($id);
        $this->authorize('print', $cuti);
        return view('cuti.print', compact('cuti'));
    }
}
