<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah pernah digunakan',
            'email.email' => 'Email ini tidak valid',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa string.',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
            'password' => ['The provided credentials are incorrect.'],
            ]);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token,
            ],
        ]);
    }
}
