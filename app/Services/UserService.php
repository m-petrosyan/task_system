<?php

namespace App\Services;

class UserService
{
    public function login(): string
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return $user->createToken('auth_token')->plainTextToken;
    }
}