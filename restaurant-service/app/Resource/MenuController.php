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
        return $this->menuService->register($request);
    }

    public function delete(Request $request, $id) 
    {
        return $this->menuService->delete($request, $id);
    }

    public function deleteItem(Request $request, $id) 
    {
        return $this->menuService->deleteItem($request, $id);
    }

    public function addItem(Request $request) 
    {
        return $this->menuService->addItem($request);
    }

}