<?php
use App\Http\Controllers\Api\JwtAuthController;
use Illuminate\Support\Facades\Route;

// Los endpoints web con sesión permanecen separados de esta API.
Route::post('/auth/login', [JwtAuthController::class, 'login'])
    ->middleware('throttle:5,1');
Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [JwtAuthController::class, 'me']);
    Route::post('/auth/logout', [JwtAuthController::class, 'logout']);
});
