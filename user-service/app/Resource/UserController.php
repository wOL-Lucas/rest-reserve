<?php

namespace App\Resource;

use App\Service\Interface\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        return response()->json(
            $this->userService->register($request), 201
        );
    }

    public function list(Request $request)
    {
        return response()->json(
            $this->userService->list($request), 201
        );
    }

    public function listById(Request $request)
    {
        return response()->json(
            $this->userService->listById($request), 201
        );
    }
}