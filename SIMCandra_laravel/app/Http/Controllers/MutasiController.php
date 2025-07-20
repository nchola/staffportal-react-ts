<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutasi;
use App\Models\Pegawai;
use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Mutasi::with(['pegawai', 'departemenBaru', 'departemenLama', 'jabatanBaru', 'jabatanLama', 'verifikator']);
        if ($user && $user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            if ($pegawai) {
                $query->where('pegawai_id', $pegawai->id);
            } else {
                $query->whereRaw('1=0'); // Tidak ada data jika tidak terhubung pegawai
            }
        }
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->whereHas('pegawai', function($q1) use ($q) {
                    $q1->where('nama_lengkap', 'like', "%$q%")
                        ->orWhere('nip', 'like', "%$q%") ;
                })
                ->orWhereHas('departemenBaru', function($q2) use ($q) {
                    $q2->where('nama', 'like', "%$q%") ;
                })
                ->orWhereHas('departemenLama', function($q3) use ($q) {
                    $q3->where('nama', 'like', "%$q%") ;
                })
                ->orWhereHas('jabatanBaru', function($q4) use ($q) {
                    $q4->where('nama', 'like', "%$q%") ;
                })
                ->orWhereHas('jabatanLama', function($q5) use ($q) {
                    $q5->where('nama', 'like', "%$q%") ;
                });
            });
        }
        if ($request->tanggal_efektif) {
            $query->whereDate('tanggal_efektif', $request->tanggal_efektif);
        }
        $mutasis = $query->get();
        return view('mutasi.index', compact('mutasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        $departemens = Departemen::all();
        $jabatans = Jabatan::all();
        return view('mutasi.create', compact('pegawais', 'departemens', 'jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'departemen_baru_id' => 'nullable|exists:departemens,id',
            'departemen_lama_id' => 'nullable|exists:departemens,id',
            'jabatan_baru_id' => 'nullable|exists:jabatans,id',
            'jabatan_lama_id' => 'nullable|exists:jabatans,id',
            'alasan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'tanggal_efektif' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'jenis' => 'required|in:promosi,demosi',
        ]);
        $data = $request->all();
        $data['verifikasi_oleh'] = Auth::id();
        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('mutasi', 'public');
        }
        $mutasi = Mutasi::create($data);
        // Update data pegawai utama
        $pegawai = Pegawai::find($request->pegawai_id);
        if ($pegawai) {
            if ($request->departemen_baru_id) $pegawai->departemen_id = $request->departemen_baru_id;
            if ($request->jabatan_baru_id) $pegawai->jabatan_id = $request->jabatan_baru_id;
            $pegawai->save();
        }
        return redirect()->route('mutasi.index')->with('success', 'Data Promosi/Demosi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mutasi = Mutasi::with(['pegawai', 'departemenBaru', 'departemenLama', 'jabatanBaru', 'jabatanLama', 'verifikator'])->findOrFail($id);
        return view('mutasi.show', compact('mutasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $pegawais = Pegawai::all();
        $departemens = Departemen::all();
        $jabatans = Jabatan::all();
        return view('mutasi.edit', compact('mutasi', 'pegawais', 'departemens', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'departemen_baru_id' => 'nullable|exists:departemens,id',
            'departemen_lama_id' => 'nullable|exists:departemens,id',
            'jabatan_baru_id' => 'nullable|exists:jabatans,id',
            'jabatan_lama_id' => 'nullable|exists:jabatans,id',
            'alasan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'tanggal_efektif' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'jenis' => 'required|in:promosi,demosi',
        ]);
        $data = $request->all();
        $data['verifikasi_oleh'] = Auth::id();
        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('mutasi', 'public');
        }
        $mutasi->update($data);
        // Update data pegawai utama
        $pegawai = Pegawai::find($request->pegawai_id);
        if ($pegawai) {
            if ($request->departemen_baru_id) $pegawai->departemen_id = $request->departemen_baru_id;
            if ($request->jabatan_baru_id) $pegawai->jabatan_id = $request->jabatan_baru_id;
            $pegawai->save();
        }
        return redirect()->route('mutasi.index')->with('success', 'Data Promosi/Demosi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $mutasi->delete();
        return redirect()->route('mutasi.index')->with('success', 'Data Promosi/Demosi berhasil dihapus.');
    }

    public function verify(Request $request, $id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['HRD', 'Kepala Unit'])) abort(403);
        $mutasi = Mutasi::findOrFail($id);
        if ($mutasi->status_verifikasi !== 'Menunggu') {
            return back()->with('error', 'Data sudah diverifikasi.');
        }
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'keterangan_verifikasi' => 'nullable|string',
        ]);
        $mutasi->update([
            'status_verifikasi' => $request->status,
            'keterangan' => $request->keterangan_verifikasi,
            'tanggal_verifikasi' => now(),
            'verifikasi_oleh' => $user->id,
        ]);
        return redirect()->route('mutasi.index')->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function print(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'HRD') abort(403);
        $query = Mutasi::with(['pegawai', 'departemenBaru', 'departemenLama', 'jabatanBaru', 'jabatanLama', 'verifikator']);
        if ($request->pegawai) {
            $query->whereHas('pegawai', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->pegawai}%")
                  ->orWhere('nip', 'like', "%{$request->pegawai}%");
            });
        }
        if ($request->departemen) {
            $query->whereHas('departemenBaru', function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->departemen}%");
            })->orWhereHas('departemenLama', function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->departemen}%");
            });
        }
        if ($request->jabatan) {
            $query->whereHas('jabatanBaru', function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->jabatan}%");
            })->orWhereHas('jabatanLama', function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->jabatan}%");
            });
        }
        if ($request->status) {
            $query->where('status', 'like', "%{$request->status}%");
        }
        if ($request->tanggal_efektif) {
            $query->whereDate('tanggal_efektif', $request->tanggal_efektif);
        }
        $mutasis = $query->get();
        return view('mutasi.print', compact('mutasis'));
    }
} 