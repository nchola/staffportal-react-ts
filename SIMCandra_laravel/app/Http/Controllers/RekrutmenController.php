<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekrutmen;
use Illuminate\Support\Facades\Auth;

class RekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekrutmens = Rekrutmen::all();
        return view('rekrutmen.index', compact('rekrutmens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rekrutmen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'status' => 'required',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date',
        ]);
        Rekrutmen::create($request->only(['judul','deskripsi','kualifikasi','status','tanggal_buka','tanggal_tutup']));
        return redirect()->route('rekrutmen.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rekrutmen = Rekrutmen::findOrFail($id);
        return view('rekrutmen.show', compact('rekrutmen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rekrutmen = Rekrutmen::findOrFail($id);
        return view('rekrutmen.edit', compact('rekrutmen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'status' => 'required',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date',
        ]);
        $rekrutmen = Rekrutmen::findOrFail($id);
        $rekrutmen->update($request->only(['judul','deskripsi','kualifikasi','status','tanggal_buka','tanggal_tutup']));
        return redirect()->route('rekrutmen.index')->with('success', 'Lowongan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rekrutmen = Rekrutmen::findOrFail($id);
        $rekrutmen->delete();
        return redirect()->route('rekrutmen.index')->with('success', 'Lowongan berhasil dihapus');
    }
}
