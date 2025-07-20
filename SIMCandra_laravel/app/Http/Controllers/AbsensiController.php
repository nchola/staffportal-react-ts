<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Absensi::with('pegawai')->latest();
        if ($user && $user->role === 'Karyawan') {
            $pegawai = $user->pegawai;
            if ($pegawai) {
                $query->where('pegawai_id', $pegawai->id);
            } else {
                // Jika tidak terhubung ke pegawai, tampilkan data kosong
                $query->whereRaw('1=0');
            }
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('pegawai', function($sub) use ($q) {
                $sub->where('nama_lengkap', 'like', "%$q%")
                    ->orWhere('nip', 'like', "%$q%")
                    ->orWhereHas('departemen', function($subDepartemen) use ($q) {
                        $subDepartemen->where('nama', 'like', "%$q%") ;
                    });
            });
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        $absensis = $query->get();
        return view('absensi.index', compact('absensis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $isKaryawan = $user && $user->role === 'Karyawan';
        $pegawais = !$isKaryawan ? Pegawai::all() : collect();
        $sudahAbsenMasuk = false;
        $sudahAbsenKeluar = false;
        if ($isKaryawan) {
            $pegawai = $user->pegawai;
            $today = date('Y-m-d');
            $absensi = $pegawai ? Absensi::where('pegawai_id', $pegawai->id)->where('tanggal', $today)->first() : null;
            $sudahAbsenMasuk = $absensi && $absensi->jam_masuk;
            $sudahAbsenKeluar = $absensi && $absensi->jam_keluar;
        }
        return view('absensi.create', compact('pegawais', 'sudahAbsenMasuk', 'sudahAbsenKeluar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $isKaryawan = $user && $user->role === 'Karyawan';
        if ($isKaryawan) {
            $pegawai = $user->pegawai;
            if (!$pegawai) {
                return back()->withErrors(['pegawai_id' => 'Akun Anda belum terhubung dengan data pegawai.'])->withInput();
            }
            $today = date('Y-m-d');
            $absensi = \App\Models\Absensi::where('pegawai_id', $pegawai->id)->where('tanggal', $today)->first();
            if ($request->has('submit_masuk')) {
                if ($absensi && $absensi->jam_masuk) {
                    return back()->with('info', 'Anda sudah absen masuk hari ini.');
                }
                $request->validate([
                    'foto_masuk_data' => 'required',
                ]);
                $fotoMasukPath = null;
                if ($request->foto_masuk_data) {
                    $fotoMasukPath = $this->saveBase64Image($request->foto_masuk_data, 'absensi');
                }
                if (!$absensi) {
                    \App\Models\Absensi::create([
                        'pegawai_id' => $pegawai->id,
                        'tanggal' => $today,
                        'jam_masuk' => now()->format('H:i'),
                        'status' => 'Hadir',
                        'foto_masuk' => $fotoMasukPath,
                    ]);
                } else {
                    $absensi->update([
                        'jam_masuk' => now()->format('H:i'),
                        'foto_masuk' => $fotoMasukPath,
                    ]);
                }
                return redirect()->route('absensi.create')->with('success', 'Absen masuk berhasil.');
            } elseif ($request->has('submit_keluar')) {
                if (!$absensi || !$absensi->jam_masuk) {
                    return back()->with('info', 'Anda harus absen masuk terlebih dahulu.');
                }
                if ($absensi->jam_keluar) {
                    return back()->with('info', 'Anda sudah absen keluar hari ini.');
                }
                $request->validate([
                    'foto_keluar_data' => 'required',
                ]);
                $fotoKeluarPath = null;
                if ($request->foto_keluar_data) {
                    $fotoKeluarPath = $this->saveBase64Image($request->foto_keluar_data, 'absensi');
                }
                $absensi->update([
                    'jam_keluar' => now()->format('H:i'),
                    'foto_keluar' => $fotoKeluarPath,
                ]);
                return redirect()->route('absensi.create')->with('success', 'Absen keluar berhasil.');
            }
            return redirect()->route('absensi.create');
        }
        // HRD/Kepala Unit: proses seperti sebelumnya
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i|after_or_equal:jam_masuk',
            'status' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
            'foto_masuk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_keluar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'surat_keterangan_dokter' => $request->status === 'Sakit' ? 'required|file|mimes:pdf,jpeg,png,jpg|max:2048' : 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('foto_masuk')) {
            $fotoMasuk = $request->file('foto_masuk')->store('absensi', 'public');
            $validatedData['foto_masuk'] = $fotoMasuk;
        }
        if ($request->hasFile('foto_keluar')) {
            $fotoKeluar = $request->file('foto_keluar')->store('absensi', 'public');
            $validatedData['foto_keluar'] = $fotoKeluar;
        }
        if ($request->hasFile('surat_keterangan_dokter')) {
            $suratDokter = $request->file('surat_keterangan_dokter')->store('surat_dokter', 'public');
            $validatedData['surat_keterangan_dokter'] = $suratDokter;
        }
        \App\Models\Absensi::create($validatedData);
        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        // Load the pegawai relationship
        $absensi->load('pegawai');

        // Tampilkan view show dan kirim data absensi
        return view('absensi.show', compact('absensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        // Ambil semua data pegawai untuk dropdown
        $pegawais = Pegawai::all();

        // Tampilkan view edit, kirim data absensi dan pegawai
        return view('absensi.edit', compact('absensi', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absensi)
    {
        // Define validation rules
        $validatedData = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i|after_or_equal:jam_masuk', // Jam keluar harus setelah atau sama dengan jam masuk
            'status' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
            'foto_masuk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_keluar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'surat_keterangan_dokter' => $request->status === 'Sakit' ? 'required|file|mimes:pdf,jpeg,png,jpg|max:2048' : 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // Handle upload foto masuk
        if ($request->hasFile('foto_masuk')) {
            $fotoMasuk = $request->file('foto_masuk')->store('absensi', 'public');
            $validatedData['foto_masuk'] = $fotoMasuk;
        }
        // Handle upload foto keluar
        if ($request->hasFile('foto_keluar')) {
            $fotoKeluar = $request->file('foto_keluar')->store('absensi', 'public');
            $validatedData['foto_keluar'] = $fotoKeluar;
        }
        if ($request->hasFile('surat_keterangan_dokter')) {
            $suratDokter = $request->file('surat_keterangan_dokter')->store('surat_dokter', 'public');
            $validatedData['surat_keterangan_dokter'] = $suratDokter;
        }

        // Update the Absensi record with validated data
        $absensi->update($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        // Delete the absensi record
        $absensi->delete();

        // Redirect to the index page with a success message
        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }

    /**
     * Generate and display a printable report of absences.
     */
    // Removed printReport method as print functionality is now handled by browser print on index page

    // Tambahkan method helper untuk menyimpan base64 image
    protected function saveBase64Image($base64Image, $folder = 'absensi') {
        $image = str_replace('data:image/jpeg;base64,', '', $base64Image);
        $image = str_replace(' ', '+', $image);
        $imageName = $folder . '/' . uniqid() . '.jpg';
        Storage::disk('public')->put($imageName, base64_decode($image));
        return $imageName;
    }
}
