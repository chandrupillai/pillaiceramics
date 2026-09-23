<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\{AdminAuthController,GodownController,DashboardController};
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LocationController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::match(['get', 'post'], '/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/shops', [PageController::class, 'shops'])->name('shops');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Location-Specific SEO Sub-Pages
Route::get('/shops/{location}', [PageController::class, 'shopDetail'])->name('shops.detail');


/*
|--------------------------------------------------------------------------
| Public Admin Auth Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
});


/*
|--------------------------------------------------------------------------
| Protected Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:super_admin,admin,staff'])->group(function () {

    // Auth & Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    

    // Locations Management (Accessible by Super Admin, Admin, Staff)
    Route::get('locations/fetch', [LocationController::class, 'fetch'])->name('locations.fetch');
    Route::resource('locations', LocationController::class);

    // Restricted Access Routes (Super Admin & Admin Only)
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('users/fetch', [UserController::class, 'fetch'])->name('users.fetch');
        Route::resource('users', UserController::class);
    });

    //Godown
    // AJAX fetch route for table pagination & search filters
    Route::get('godowns/fetch', [GodownController::class, 'fetch'])->name('godowns.fetch');

    // RESTful CRUD routes (index, store, show, update, destroy)
    Route::resource('godowns', GodownController::class);
});
