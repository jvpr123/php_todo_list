<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/ping", function () {
    return  ["message" => "Welcome"];
});

// Authentication routes
Route::prefix("auth")->group(function () {
    Route::post("login", [AuthController::class, "login"]);
    Route::post("logout", [AuthController::class, "logout"]);
});

// Users routes
Route::middleware("auth:sanctum")->resource("users", UsersController::class, ["except" => ["store"]]);
Route::post("/users", [UsersController::class, "store"]);

// Categories routes
Route::middleware("auth:sanctum")->resource("categories", CategoriesController::class);

// Tasks routes
Route::middleware("auth:sanctum")->resource("tasks", TasksController::class);
