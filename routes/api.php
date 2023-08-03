<?php

use App\Http\Controllers\Api\{
    UserController,
};
use App\Http\Controllers\Api\Auth\{
    RegisterController,
    AuthController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth and Register Routes
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/auth', [AuthController::class, 'auth']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);
});

Route::get('/', function () {
    return response()->json(['message' => 'ok']);
});
