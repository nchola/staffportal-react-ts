<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::all();
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
        Departemen::create($request->only(['nama', 'deskripsi']));
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $departemen = Departemen::findOrFail($id);
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, $id)
    {
        $departemen = Departemen::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
        $departemen->update($request->only(['nama', 'deskripsi']));
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil dihapus.');
    }

    public function show($id)
    {
        $departemen = \App\Models\Departemen::with('jabatans')->findOrFail($id);
        return view('departemen.show', compact('departemen'));
    }

    public function jabatans($id)
    {
        $jabatans = \App\Models\Jabatan::where('departemen_id', $id)->get(['id', 'nama']);
        return response()->json($jabatans);
    }
} 