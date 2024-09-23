<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($data)) {
            if (!$request->hasSession()) {
                $request->setLaravelSession(Session::driver());
            }

            $request->session()->regenerate();
            if (Auth::user()->id_cargo === 1) {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('home');
            }
        }
        return response()->json([
            'message' => 'Email ou senha incorreta'
        ], 403);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login');
    }
}
