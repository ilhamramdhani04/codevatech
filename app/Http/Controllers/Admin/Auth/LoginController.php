<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $dashboard = Auth::user()->isTeknisi() ? 'teknisi.dashboard' : 'admin.dashboard';
            return redirect()->route($dashboard);
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (!Auth::user()->hasRole(['admin', 'teknisi'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun tidak memiliki akses ke portal ini.']);
            }

            $dashboard = Auth::user()->isTeknisi() ? 'teknisi.dashboard' : 'admin.dashboard';
            return redirect()->intended(route($dashboard));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
