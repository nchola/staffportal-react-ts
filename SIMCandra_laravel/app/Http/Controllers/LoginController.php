<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in using 'username'
        // Make sure your User model uses the Authenticatable trait
        // and has a 'username' field.
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->filled('remember')))
        {
            // Authentication successful...
            $user = Auth::user();

            // Redirect khusus untuk Calon Karyawan
            if ($user->role === 'Calon Karyawan') {
                return redirect()->intended(route('rekrutmen.index'));
            }
            // Redirect default
            return redirect()->intended(route('dashboard'));
        }

        // Authentication failed...
        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // Public function logout(Request $request)
    // {
    //     Auth::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/'); // Redirect ke halaman utama atau login setelah logout
    // }
} 