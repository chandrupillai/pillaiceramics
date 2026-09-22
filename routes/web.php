<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UserController;

Route::match(['get', 'post'], '/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/shops', [PageController::class, 'shops'])->name('shops');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Location-Specific SEO Sub-Pages (Crucial for Local SEO in Trichy, Karaikal, etc.)
Route::get('/shops/{location}', [PageController::class, 'shopDetail'])->name('shops.detail');


// Public Admin Auth Routes (Guest Only)
Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Protected Admin Panel Routes
Route::prefix('admin')->middleware(['auth', 'role:super_admin,admin,staff'])->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Super Admin / Admin Only User Management
    Route::middleware('role:super_admin,admin')->group(function () {
        // Route::resource('users', UserController::class);
    });

Route::middleware('role:super_admin,admin')->group(function () {
        // User Routes -> Names automatically resolve with 'admin.' prefix
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/fetch', [UserController::class, 'fetch'])->name('admin.users.fetch'); // Resolves to: admin.users.fetch
        Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::put('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
    
});
