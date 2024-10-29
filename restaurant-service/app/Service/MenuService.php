<?php

namespace App\Service;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Service\Interface\MenuServiceInterface;
use Illuminate\Http\Request;
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

        return $menu->load('menuItem');
    }

    public function delete($id) 
    {
        $menu = $this->menuRepository->find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $menu->menuItem()->delete();
    }

}