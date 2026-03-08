<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return redirect()->back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => __('login.login_failed')]);
        }

        $user = Auth::user();

        if ($user->status === 'inactive') {
            Auth::logout();
            return redirect()->back()->withErrors([
                'message' => __('login.user_deactivated'),
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
