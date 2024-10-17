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
}