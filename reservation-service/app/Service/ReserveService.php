<?php

namespace App\Service;

use App\Models\Reserve;
use App\Service\Interface\ReserveServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ReserveService implements ReserveServiceInterface
{
    private $reserveRepository;

    function __construct(Reserve $reserveRepository)
    {
        $this->reserveRepository = $reserveRepository;
    }

    public function registerReserve(Request $request)
    {

        if (!$this->validatePermission($request, 'user')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $request->merge(['status' => 'created']);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'restaurant_id' => 'required|integer',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_people' => 'required|integer',
            'observation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $reserve = $this->reserveRepository->create($request->all());

        return response()->json($reserve, 201);
    }

    public function cancelReserve(Request $request, $id)
    {

        if (!$this->validatePermission($request, 'user')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $reserve = $this->reserveRepository->find($id);

        if (!$reserve) {
            return response()->json(['error' => 'Reserve not found'], 404);
        }

        $reserve->status = 'cancelled';
        $reserve->save();

        return response()->json($reserve, 200);
    }

    public function getAll(Request $request)
    {
        if (!$this->validatePermission($request, 'user')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $payload = JWTAuth::setToken($request->bearerToken())->getPayload();

        $reserves = $this->reserveRepository->where('user_id', $payload->get('id'))->get();

        return response()->json($reserves, 200);
    }

    public function findByUserId(Request $request, $userId)
    {

        if (!$this->validatePermission($request, 'user')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $reserves = $this->reserveRepository->where('user_id', $userId)->get();

        return response()->json($reserves, 200);
    }

    public function findByRestaurantId(Request $request, $restaurantId)
    {

        if (!$this->validatePermission($request, 'manager')) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        $reserves = $this->reserveRepository->where('restaurant_id', $restaurantId)->get();

        return response()->json($reserves, 200);
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
