<?php

namespace App\Resource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $roles = $user->role;

        $customClaims = ['roles' => $roles];
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);

    }
}