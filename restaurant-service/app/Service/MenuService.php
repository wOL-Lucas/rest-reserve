<?php

namespace App\Service;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Service\Interface\MenuServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MenuService implements MenuServiceInterface
{

    private $menuRepository;
    private $menuItemRepository;

    public function __construct(Menu $menuRepository, MenuItem $menuItemRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->menuItemRepository = $menuItemRepository;
    }

    public function register(Request $request)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|int',
            'menu_items.*.name' => 'required|string|max:255',
            'menu_items.*.description' => 'nullable|string',
            'menu_items.*.price' => 'required|numeric',
            'menu_items.*.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $menu = $this->menuRepository->create([
            'restaurant_id' => $request->input('restaurant_id')
        ]);

        $menuItems = $request->input('menu_items');
        foreach ($menuItems as $index => $item) {
            $imagePath = null;
            if ($request->hasFile("menu_items.$index.image")) {
                $image = $request->file("menu_items.$index.image");
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('menu_item_images', $imageName, 'public');
            }

            $menu->menuItem()->create([
                'menu_id' => $menu->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'image_url' => $imagePath ? url('storage/' . $imagePath) : null
            ]);
        }

        return response()->json(['message' => 'Menu registered successfully'], 200);
    }

    public function delete(Request $request, $id) 
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $menu = $this->menuRepository->find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $menu->menuItem()->delete();
        $menu->delete();

        return response()->json(['message' => 'Menu deleted successfully'], 200);
    }

    public function deleteItem(Request $request, $id) 
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $menuItem = $this->menuItemRepository->find($id);
        if (!$menuItem) {
            return response()->json(['message' => 'Menu item not found'], 404);
        }

        $menuItem->delete();

        return response()->json(['message' => 'Menu item deleted successfully'], 200);
    }

    public function addItem(Request $request)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $menu = $this->menuRepository->find($request->input('menu_id'));
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'menu_items.*.name' => 'required|string|max:255',
            'menu_items.*.description' => 'nullable|string',
            'menu_items.*.price' => 'required|numeric',
            'menu_items.*.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $menuItems = $request->input('menu_items');
        foreach ($menuItems as $index => $item) {
            $imagePath = null;
            if ($request->hasFile("menu_items.$index.image")) {
                $image = $request->file("menu_items.$index.image");
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('menu_item_images', $imageName, 'public');
            }

            $menu->menuItem()->create([
                'menu_id' => $menu->id,
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'image_url' => $imagePath ? url('storage/' . $imagePath) : null
            ]);
        }

        return response()->json(['message' => 'Menu item added successfully'], 200);
    }

    private function validatePermission(Request $request, String $requiredRole) 
    {

        Log::info('validatePermission method called');

        $token = trim($request->bearerToken());

        Log:info($token);

        if (!$token) {  
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $response = Http::post('http://user-service:8081/validate-token', [
            'token' => $token,
            'requiredRole' => $requiredRole
        ]);

        Log::info('Response from user-service: ' . $response->body());

        $status = $response->json()['message'];

        Log::info($status);

        return $status === 'AUTHORIZED';
    }

}