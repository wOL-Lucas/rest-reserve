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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
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

        $address = $this->addressRepository->find($request->id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->update($request->all());

        return $address;
    }

    public function delete($id)
    {
        $address = $this->addressRepository->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();
    }

    public function find_by_restaurant_id($restaurant_id)
    {
        $addresses = $this->addressRepository->where('restaurant_id', $restaurant_id)->get();

        if (!$addresses) {
            return response()->json(['message' => 'Restaurant with no addresses registereds'], 404);
        }

        return $addresses;
    }
}