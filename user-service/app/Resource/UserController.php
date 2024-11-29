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
        return $this->userService->register($request);
    }

    public function listById(Request $request, $id)
    {
        return $this->userService->listById($request, $id);
    }
}