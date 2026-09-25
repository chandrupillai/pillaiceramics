<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;




// Public Route
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/locations', [DataController::class, 'locations']);
Route::get('/godowns', [DataController::class, 'godowns']);
Route::get('/products/stocks', [DataController::class, 'getAllProductsStock']);
Route::get('/products/{id}', [DataController::class, 'getAllProductsStock']);
// New Catalog endpoints
Route::get('/categories', [DataController::class, 'categories']);
Route::get('/types', [DataController::class, 'types']);
Route::get('/sizes', [DataController::class, 'sizes']);

Route::get('/company', [DataController::class, 'company']);
// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [DataController::class, 'users']);
    
Route::put('/user/profile', [DataController::class, 'updateProfile']);
});
