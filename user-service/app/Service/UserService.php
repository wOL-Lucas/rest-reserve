<?php

namespace App\Service;

use App\Models\Role;
use App\Models\User;
use App\Rules\ValidRole;
use App\Service\Interface\QueuePublisherInterface;
use App\Service\Interface\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'role' => Role::USER,
            'image_url' => $imagePath ? url('storage/' . $imagePath) : null
        ]);

        $this->queuePublisher->publish('Welcome to Rest Reserve', $user->email, 'Thanks for registering to Rest Reserve');

        return $this->userRepository::find($user->id);
    }

    public function list(Request $request)
    {
        return $this->userRepository::all();
    }

    public function listById(Request $request)
    {
        return $this->userRepository::find($request->id);
    }
}