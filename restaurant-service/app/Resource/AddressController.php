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
        return $this->addressService->register($request);
    }

    public function update(Request $request) 
    {
        return $this->addressService->update($request);
    }   

    public function delete(Request $request, $id) 
    {
        return $this->addressService->delete($request, $id);
    }

    public function find_by_restaurant_id(Request $request, $restaurant_id) 
    {
        return $this->addressService->find_by_restaurant_id($request, $restaurant_id);
    }
}