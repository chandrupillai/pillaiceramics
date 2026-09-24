<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;




// Public Route
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/locations', [DataController::class, 'locations']);
Route::get('/godowns', [DataController::class, 'godowns']);
// New Catalog endpoints
Route::get('/categories', [DataController::class, 'categories']);
Route::get('/types', [DataController::class, 'types']);
Route::get('/sizes', [DataController::class, 'sizes']);
// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [DataController::class, 'users']);
    // Resource Lists
    Route::get('/users', [DataController::class, 'users']);
});
