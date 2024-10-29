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
    private $user;
    
    function __construct(User $user, private QueuePublisherInterface $queuePublisher)
    {
        $this->user = $user;
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

        $user = $this->user->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => Role::USER,
            'image_url' => $imagePath,
        ]);

        $this->queuePublisher->publish('Welcome to Rest Reserve', $user->email, 'Thanks for registering to Rest Reserve');

        if ($imagePath) {
          $user->image_url = url('storage/' . $imagePath);
        }

        return $user;
    }

    public function list(Request $request)
    {
        $users = $this->user::all();
        foreach ($users as $user) {
            if ($user->image_url) {
                $user->image_url = url('storage/' . $user->image_url);
            }
        }
        return $users;
    }

    public function listById(Request $request)
    {
        $user = $this->user::find($request->id);
        if ($user && $user->image_url) {
            $user->image_url = url('storage/' . $user->image_url);
        }
        return $user;
    }
}