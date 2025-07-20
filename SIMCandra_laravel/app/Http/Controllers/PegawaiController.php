<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pegawai::query();
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('nama_lengkap', 'like', "%$q%")
                    ->orWhere('nip', 'like', "%$q%")
                    ->orWhereHas('departemen', function($q2) use ($q) {
                        $q2->where('nama', 'like', "%$q%") ;
                    })
                    ->orWhereHas('jabatan', function($q3) use ($q) {
                        $q3->where('nama', 'like', "%$q%") ;
                    });
            });
        }
        $pegawai = $query->get();
        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departemens = \App\Models\Departemen::all();
        $jabatans = \App\Models\Jabatan::all();
        return view('pegawai.create', compact('departemens', 'jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:pegawais|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'departemen_id' => 'nullable|exists:departemens,id',
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string|max:20',
            'agama' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'status_pernikahan' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'tanggal_bergabung' => 'required|date',
            'nama_panggilan' => 'nullable|string|max:255', // Added new field
            'no_ktp' => 'nullable|string|max:255',         // Added new field
            'no_absensi' => 'nullable|string|max:255',     // Added new field
            'atasan_langsung' => 'nullable|string|max:255',// Added new field
            // 'user_id' will be handled separately, not from form input
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Create a new Pegawai instance
        $pegawai = new Pegawai;

        // Fill the model with validated data
        $pegawai->nip = $request->nip;
        $pegawai->nama_lengkap = $request->nama_lengkap;
        $pegawai->departemen_id = $request->departemen_id;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->nama_panggilan = $request->nama_panggilan; // Assign new field
        $pegawai->no_ktp = $request->no_ktp;                 // Assign new field
        $pegawai->no_absensi = $request->no_absensi;         // Assign new field
        $pegawai->atasan_langsung = $request->atasan_langsung;// Assign new field
        $pegawai->email = $request->email;
        $pegawai->no_telepon = $request->no_telepon;
        $pegawai->alamat = $request->alamat;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->agama = $request->agama;
        $pegawai->tempat_lahir = $request->tempat_lahir;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;
        $pegawai->pendidikan_terakhir = $request->pendidikan_terakhir;
        $pegawai->status_pernikahan = $request->status_pernikahan;
        $pegawai->status = $request->status;
        $pegawai->tanggal_bergabung = $request->tanggal_bergabung;
        // user_id will be set based on authentication, which is not implemented yet

        // Save the employee to the database
        $pegawai->save();

        // Redirect to the index page with a success message
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the employee by ID
        $pegawai = Pegawai::findOrFail($id);

        // Return the show view, passing the employee data
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $departemens = \App\Models\Departemen::all();
        $jabatans = \App\Models\Jabatan::all();
        return view('pegawai.edit', compact('pegawai', 'departemens', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the employee to be updated
        $pegawai = Pegawai::findOrFail($id);

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:255|unique:pegawais,nip,' . $pegawai->id, // Ignore current employee\'s ID for unique check
            'nama_lengkap' => 'required|string|max:255',
            'departemen_id' => 'nullable|exists:departemens,id',
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string|max:20',
            'agama' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'status_pernikahan' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'tanggal_bergabung' => 'required|date',
            'nama_panggilan' => 'nullable|string|max:255', // Added new field
            'no_ktp' => 'nullable|string|max:255',         // Added new field
            'no_absensi' => 'nullable|string|max:255',     // Added new field
            'atasan_langsung' => 'nullable|string|max:255',// Added new field
            // 'user_id' will be handled separately
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Update the employee with validated data
        $pegawai->nip = $request->nip;
        $pegawai->nama_lengkap = $request->nama_lengkap;
        $pegawai->departemen_id = $request->departemen_id;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->nama_panggilan = $request->nama_panggilan; // Update new field
        $pegawai->no_ktp = $request->no_ktp;                 // Update new field
        $pegawai->no_absensi = $request->no_absensi;         // Update new field
        $pegawai->atasan_langsung = $request->atasan_langsung;// Update new field
        $pegawai->email = $request->email;
        $pegawai->no_telepon = $request->no_telepon;
        $pegawai->alamat = $request->alamat;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->agama = $request->agama;
        $pegawai->tempat_lahir = $request->tempat_lahir;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;
        $pegawai->pendidikan_terakhir = $request->pendidikan_terakhir;
        $pegawai->status_pernikahan = $request->status_pernikahan;
        $pegawai->status = $request->status;
        $pegawai->tanggal_bergabung = $request->tanggal_bergabung;
        // user_id update will be handled separately

        // Save the updated employee
        $pegawai->save();

        // Redirect to the index page with a success message
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the employee by ID
        $pegawai = Pegawai::findOrFail($id);

        // Delete the employee record
        $pegawai->delete();

        // Redirect to the index page with a success message
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    /**
     * Generate and display a printable report of employees.
     */
    // Removed printReport method as print functionality is now handled by browser print on index page

    public function info($id)
    {
        Log::info('AJAX pegawai info', ['id' => $id, 'user' => Auth::user()]);
        $pegawai = \App\Models\Pegawai::with(['jabatan', 'departemen'])->findOrFail($id);
        Log::info('Pegawai data', ['pegawai' => $pegawai]);
        return response()->json([
            'jabatan' => $pegawai->jabatan ? ['id' => $pegawai->jabatan->id, 'nama' => $pegawai->jabatan->nama] : null,
            'departemen' => $pegawai->departemen ? ['id' => $pegawai->departemen->id, 'nama' => $pegawai->departemen->nama] : null,
        ]);
    }
}
