<?php

namespace App\Service;

use App\Models\Reserve;
use App\Service\Interface\ReserveServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReserveService implements ReserveServiceInterface
{
    private $reserveRepository;

    function __construct(Reserve $reserveRepository)
    {
        $this->reserveRepository = $reserveRepository;
    }

    public function registerReserve(Request $request)
    {
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

        return $reserve;
    }

    public function cancelReserve($id)
    {
        $reserve = $this->reserveRepository->find($id);

        if (!$reserve) {
            return response()->json(['error' => 'Reserve not found'], 404);
        }

        $reserve->status = 'cancelled';
        $reserve->save();

        return $reserve;
    }

    public function findByUserId($userId)
    {
        $reserves = $this->reserveRepository->where('user_id', $userId)->get();

        return $reserves;
    }

    public function findByRestaurantId($restaurantId)
    {
        $reserves = $this->reserveRepository->where('restaurant_id', $restaurantId)->get();

        return $reserves;
    }
}