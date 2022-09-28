<?php

namespace App\Http\Controllers;

use App\Http\Errors\ErrorHandler;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(Request $request)
    {
        try {
            $token = $this->authService->login($request);

            return response()->json([
                "message" => "Login was successful",
                "token" => $token,
            ]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }
}
