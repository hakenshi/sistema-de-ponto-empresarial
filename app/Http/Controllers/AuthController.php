<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($data)) {
            return response()->json([
                'user' => Auth::user(),
                'token' => $request->user()->createToken('auth_token')->plainTextToken
            ], 200);
        }
        return response()->json([
            'message' => 'Email ou senha incorreta'
        ], 403);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response('', 204);
    }

}
