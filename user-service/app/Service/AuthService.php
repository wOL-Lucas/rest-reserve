<?php

namespace App\Service;

use App\Service\Interface\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
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
        $role = $user->role;

        $customClaims = ['role' => $role, 'id' => $user->id];
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
            'role' => $role,
        ], 200);

    }

    public function validateToken(Request $request)
    {
        $token = $request->input('token');
        $requiredRole = $request->input('requiredRole');

        try {
            $payload = JWTAuth::setToken($token)->getPayload();
            $role = $payload->get('role');

            if ($role != $requiredRole) {
                return response()->json([
                    'status' => 'Failed to authenticate',
                    'message' => 'UNAUTHORIZED',
                ], 401);
            }

            return response()->json([
                'status' => 'Token is valid',
                'message' => 'AUTHORIZED',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }
    }


}
