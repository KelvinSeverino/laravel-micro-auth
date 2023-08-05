<?php

use App\Http\Controllers\Api\{
    MenuResourceController,
    PermissionUserController,
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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/resources', [MenuResourceController::class, 'index']);

    Route::get('/users/can/{permission}', [PermissionUserController::class, 'userHasPermission']);
    Route::post('/users/permissions', [PermissionUserController::class, 'addPermissionsUser']);
    Route::get('/users/{indentify}/permissions', [PermissionUserController::class, 'permissionsUser']);
    Route::apiResource('/users', UserController::class);
});

Route::get('/', function () {
    return response()->json(['message' => 'ok']);
});
