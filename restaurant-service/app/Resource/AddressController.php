<?php

namespace App\Resource;

use App\Service\Interface\AddressServiceInterface;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    private $addressService;

    public function __construct(AddressServiceInterface $addressService) 
    {
        $this->addressService = $addressService;
    }

    public function register(Request $request) 
    {
        return response()->json(
            $this->addressService->register($request), 201
        );
    }

    public function update(Request $request) 
    {
        return response()->json(
            $this->addressService->update($request), 200
        );
    }   

    public function delete($id) 
    {
        return response()->json(
            $this->addressService->delete($id), 204
        );
    }

    public function find_by_restaurant_id($restaurant_id) 
    {
        return response()->json(
            $this->addressService->find_by_restaurant_id($restaurant_id), 200
        );
    }
}