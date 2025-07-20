<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('jabatan.index', compact('jabatans'));
    }

    public function create(Request $request)
    {
        $departemens = \App\Models\Departemen::all();
        $selectedDepartemen = $request->departemen_id;
        return view('jabatan.create', compact('departemens', 'selectedDepartemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'level' => 'required|integer',
            'departemen_id' => 'required|exists:departemens,id',
        ]);
        $jabatan = Jabatan::create($request->only(['nama', 'deskripsi', 'level', 'departemen_id']));
        return redirect()->route('departemen.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $departemens = \App\Models\Departemen::all();
        return view('jabatan.edit', compact('jabatan', 'departemens'));
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'level' => 'required|integer',
        ]);
        $jabatan->update($request->only(['nama', 'deskripsi', 'level']));
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus.');
    }
} 