<?php

use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/ping", fn () => ["message" => "Welcome"]);

Route::resource("users", UsersController::class);
Route::resource("tasks", TasksController::class);
