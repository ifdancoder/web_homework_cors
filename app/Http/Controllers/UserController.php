<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController
{
    private UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function create(CreateUserRequest $request)
    {
        $user = $this->service->create($request->validated());

        Auth::login($user);

        $token = $user->createToken('my-app-token')->plainTextToken;

        $userResource = [
            'token' => $token,
            'user' => new UserResource($user)
        ];
        
        return response()->json($userResource, 200);
    }

    public function login(LoginUserRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();

            $token = $user->createToken('my-app-token')->plainTextToken;

            $userResource = [
                'token' => $token,
                'user' => new UserResource($user)
            ];

            return response()->json($userResource, 200);
        }

        return response()->json('Неверный адрес электронной почты или пароль', 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return response()->json('Вы успешно вышли', 200);
    }

    public function user(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json('Unauthorized', 401);
        }

        return response()->json(new UserResource($user), 200);
    }
}
