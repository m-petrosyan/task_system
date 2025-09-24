<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AuthRequest;
use App\Http\Resources\User\AuthResource;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController
{
    public function __construct(protected UserService $userService)
    {

    }

    public function login(AuthRequest $request): JsonResponse|AuthResource
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return new AuthResource($this->userService->login());
    }


    public function auth(): UserResource
    {
        return new UserResource(auth()->user()->load('roles'));
    }
}