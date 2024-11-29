<?php

namespace App\Service;

use App\Models\Role;
use App\Models\User;
use App\Rules\ValidRole;
use App\Service\Interface\AuthServiceInterface;
use App\Service\Interface\QueuePublisherInterface;
use App\Service\Interface\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserService implements UserServiceInterface
{
    private $userRepository;
    
    function __construct(User $userRepository, private QueuePublisherInterface $queuePublisher)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:8',
          'role' => ['required', 'string', new ValidRole],
          'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagePath = null;
        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('user_images', $imageName, 'public');
        }

        $user = $this->userRepository->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'image_url' => $imagePath ? url('storage/' . $imagePath) : null
        ]);

        $this->queuePublisher->publish('Welcome to Rest Reserve', $user->email, 'Thanks for registering to Rest Reserve');

        return response()->json($this->userRepository::find($user->id), 201);
    }

    public function listById(Request $request, $id)
    {
        $user = $this->userRepository::find($id);

        $payload = JWTAuth::setToken($request->bearerToken())->getPayload();
        $role = $payload->get('role');
    
        if ($role != $user->role) {
            return response()->json([
                'status' => 'Failed to authenticate',
                'message' => 'UNAUTHORIZED',
            ], 401);
        }

        return response()->json($user, 200);
    }
}