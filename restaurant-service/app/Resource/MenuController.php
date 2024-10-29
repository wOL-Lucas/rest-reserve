<?php

namespace App\Resource;

use App\Service\Interface\MenuServiceInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menuService;

    public function __construct(MenuServiceInterface $menuService) 
    {
        $this->menuService = $menuService;
    }

    public function register(Request $request) 
    {
        return response()->json(
            $this->menuService->register($request), 201
        );
    }

    public function delete($id) 
    {
        return response()->json(
            $this->menuService->delete($id), 204
        );
    }

}