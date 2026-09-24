<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;




// Public Route
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/company', [DataController::class, 'company']);
// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/users', [DataController::class, 'users']);
    // Resource Lists
    Route::get('/users', [DataController::class, 'users']);
    Route::get('/locations', [DataController::class, 'locations']);
    Route::get('/godowns', [DataController::class, 'godowns']);


    Route::put('/user/profile', [DataController::class, 'updateProfile']);
});