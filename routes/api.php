<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\{DataController, DealerEnquiryController};

/*
|--------------------------------------------------------------------------
| API Routes - Pillai Ceramics
|--------------------------------------------------------------------------
|
| Versioned RESTful API endpoints for mobile & external client applications.
| Base prefix: /api/v1
|
*/

Route::prefix('v1')->group(function () {

    // ==========================================
    // Public Endpoints
    // ==========================================

    // Authentication
    Route::post('/login', [AuthController::class, 'login'])->name('api.v1.login');

    // Company & Organization Info
    Route::get('/company', [DataController::class, 'company'])->name('api.v1.company.show');

    // Master Data & Catalog Routes
    Route::prefix('catalog')->group(function () {
        Route::get('/categories', [DataController::class, 'categories'])->name('api.v1.catalog.categories');
        Route::get('/types', [DataController::class, 'types'])->name('api.v1.catalog.types');
        Route::get('/sizes', [DataController::class, 'sizes'])->name('api.v1.catalog.sizes');
    });

    // Infrastructure & Storage Locations
    Route::get('/locations', [DataController::class, 'locations'])->name('api.v1.locations.index');
    Route::get('/godowns', [DataController::class, 'godowns'])->name('api.v1.godowns.index');

    // Products & Stock Management
    Route::prefix('products')->group(function () {
        Route::get('/', [DataController::class, 'products'])->name('api.v1.products.index');
        Route::get('/{id}', [DataController::class, 'products'])
            ->whereNumber('id')
            ->name('api.v1.products.show');
    });

    // ==========================================
    // Protected Endpoints (Sanctum Authenticated)
    // ==========================================

    Route::middleware('auth:sanctum')->group(function () {
        // Auth Management
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.logout');

        // User Profile & Management
        Route::get('/users', [DataController::class, 'users'])->name('api.v1.users.index');
        Route::put('/profile', [DataController::class, 'updateProfile'])->name('api.v1.profile.update');
        Route::get('/dealers/list', [DataController::class, 'dealersList'])->name('api.v1.dealers.update');
        Route::post('/enquiries', [DealerEnquiryController::class, 'store']);
        Route::get('/my-enquiries', [DealerEnquiryController::class, 'myEnquiries']);
    });
});
