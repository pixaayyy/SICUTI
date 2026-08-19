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

        $role = $request->user()->role;

        if ($role === 'mandor') {
            return redirect()->route('mandor.dashboard');
        } elseif ($role === 'supervisor') {
            return redirect()->route('supervisor.dashboard'); // Jika route ini belum ada, bisa ditambahkan nanti
        } elseif ($role === 'hr') {
            return redirect()->route('hr.dashboard'); // Jika route ini belum ada, bisa ditambahkan nanti
        }

        return redirect()->route('karyawan.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
