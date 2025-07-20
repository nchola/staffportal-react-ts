<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Rekrutmen;
use Illuminate\Support\Facades\Auth;

class LamaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user() && Auth::user()->role === 'Calon Karyawan') {
            $lamarans = Lamaran::where('user_id', Auth::id())->get();
        } else {
            $lamarans = Lamaran::all();
        }
        return view('lamaran.index', compact('lamarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rekrutmens = Rekrutmen::all();
        return view('lamaran.create', compact('rekrutmens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelamar' => 'required',
            'rekrutmen_id' => 'required',
            'email' => 'required|email',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        if (Auth::user() && Auth::user()->role === 'Calon Karyawan') {
            $data['status'] = 'Diproses';
        }
        Lamaran::create($data);
        return redirect()->route('lamaran.index')->with('success', 'Lamaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        return view('lamaran.show', compact('lamaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $rekrutmens = Rekrutmen::all();
        if (Auth::user() && Auth::user()->role === 'Calon Karyawan' && $lamaran->user_id !== Auth::id()) {
            abort(403);
        }
        return view('lamaran.edit', compact('lamaran', 'rekrutmens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelamar' => 'required',
            'rekrutmen_id' => 'required',
            'email' => 'required|email',
        ]);
        $lamaran = Lamaran::findOrFail($id);
        if (Auth::user() && Auth::user()->role === 'Calon Karyawan' && $lamaran->user_id !== Auth::id()) {
            abort(403);
        }
        $data = $request->all();
        $data['user_id'] = Auth::id();
        if (Auth::user() && Auth::user()->role === 'Calon Karyawan') {
            $data['status'] = $lamaran->status; // status tidak diubah oleh calon karyawan
        }
        $lamaran->update($data);
        return redirect()->route('lamaran.index')->with('success', 'Lamaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        $lamaran->delete();
        return redirect()->route('lamaran.index')->with('success', 'Lamaran berhasil dihapus');
    }
}
