<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users|email',
            'password' => 'required|string'
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.string' => 'Nama produk harus berupa string.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah pernah digunakan',
            'email.email' => 'Email ini tidak valid',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa string.',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token,
            ],
        ]);
    }
}
