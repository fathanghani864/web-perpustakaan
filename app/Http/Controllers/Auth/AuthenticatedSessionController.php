<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    { 
        $request->authenticate();

        $request->session()->regenerate();

        // LOGIKA ROLE-BASED REDIRECT
        // Pastikan nama route yang dipanggil sudah benar
        if(Auth::user()->role === 'admin'){
            // PERBAIKAN: Menggunakan helper route() untuk nama route yang didefinisikan di routes/web.php
            return redirect()->route('admin.index'); 
        }

        if(Auth::user()->role === 'siswa'){
            // PERBAIKAN: Menggunakan path absolut untuk route resource siswa.index (yaitu /siswa)
            return redirect('/siswa.index'); 
        }
        
        // Fallback untuk role lain
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    // Hapus method 'authenticated' yang ada di bawah ini karena redundan.
    // protected function authenticated(Request $request, $user) { ... }
}
