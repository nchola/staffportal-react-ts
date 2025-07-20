<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['HRD', 'Kepala Unit'])) {
            abort(403);
        }
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'HRD') {
            abort(403);
        }
        $pegawais = \App\Models\Pegawai::whereDoesntHave('user')->get();
        return view('user.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'HRD') {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:HRD,Kepala Unit,Karyawan,Calon Karyawan',
            'pegawai_id' => 'nullable|exists:pegawais,id',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        if ($validated['role'] === 'Karyawan') {
            $validated['pegawai_id'] = $request->pegawai_id;
        } else {
            $validated['pegawai_id'] = null;
        }
        User::create($validated);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $auth = Auth::user();
        if (!in_array($auth->role, ['HRD', 'Kepala Unit'])) {
            abort(403);
        }
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $auth = Auth::user();
        if ($auth->role !== 'HRD') {
            abort(403);
        }
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $auth = Auth::user();
        if ($auth->role !== 'HRD') {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'role' => 'required|in:HRD,Kepala Unit,Karyawan,Calon Karyawan',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->role = $validated['role'];
        $user->save();
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $auth = Auth::user();
        if ($auth->role !== 'HRD') {
            abort(403);
        }
        if ($auth->id === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus user sendiri.');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
} 