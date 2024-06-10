<?php

namespace App\Http\Controllers;

use App\Models\Konsul;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt started');

        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');
        Log::info('Attempting login with credentials:', $credentials);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin')->with('success', 'Login successful!');
            } elseif ($user->role === 'pasien') {
                return redirect()->route('histori.index')->with('success', 'Login successful!');
            } elseif ($user->role === 'ahligizi') {
                return redirect()->route('konsul.index')->with('success', 'Login successful!');
            } elseif ($user->role === 'chef') {
                return redirect()->route('konsul.index')->with('success', 'Login successful!');
            } 
        }

        // Authentication failed
        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
