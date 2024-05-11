<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function token(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request->email)->first();

        $tokenName = 'Default Token';
        $abilities = ['*'];

        $tokenResult = $user->createToken($tokenName, $abilities, now()->addDay());

        $token = $tokenResult->plainTextToken;
        return ['token' => $token];
    }
}
