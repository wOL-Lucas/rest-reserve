<?php

namespace App\Service;

use App\Models\Address;
use App\Service\Interface\AddressServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressService implements AddressServiceInterface
{
    private $addressRepository;

    function __construct(Address $addressRepository) 
    {
        $this->addressRepository = $addressRepository;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|int',
            'street' => 'required|string',
            'zip_code' => 'required|string|max:8',
            'neighborhood' => 'required|string',
            'state' => 'required|string|max:2',
            'city' => 'required|string',
            'country' => 'required|string',
            'complement' => 'nullable|string',
            'number' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $address = $this->addressRepository->create($request->all());

        return $address;
    }
}