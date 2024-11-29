<?php

namespace App\Service;

use App\Models\Address;
use App\Service\Interface\AddressServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

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

        return response()->json($address, 201);
    }

    public function update(Request $request)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
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

        return response()->json($address, 200);
    }

    public function delete(Request $request, $id)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $address = $this->addressRepository->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();

        return response()->json(['message' => 'Address deleted'], 200); 
    }

    public function find_by_restaurant_id(Request $request, $restaurant_id)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $addresses = $this->addressRepository->where('restaurant_id', $restaurant_id)->get();

        if (!$addresses) {
            return response()->json(['message' => 'Restaurant with no addresses registereds'], 404);
        }

        return response()->json($addresses, 200);
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