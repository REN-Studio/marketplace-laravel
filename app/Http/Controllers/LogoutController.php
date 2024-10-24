<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json([
            'data' => [
                'message' => 'Logout Successfully'
            ]
            ]);
    }
}
