<?php

namespace App\Resource;

use App\Service\Interface\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $authService;

    function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        return response()->json($this->authService->login($request), 200);
    }

    public function validateToken(Request $request)
    {
        return response()->json($this->authService->validateToken($request), 200);
    }
}