<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    public function login($request)
    {
        $credentials = $request->only("email", "password");

        if (!Auth::attempt($credentials))
            throw new UnauthorizedHttpException("", "Invalid credentials");

        return $this->generateToken($credentials);
    }

    private function generateToken($credentials)
    {
        $user = User::where("email", $credentials["email"])->first();
        return $user->createToken($credentials["email"])->plainTextToken;
    }
}
