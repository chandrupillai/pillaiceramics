<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/shops', [PageController::class, 'shops'])->name('shops');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Location-Specific SEO Sub-Pages (Crucial for Local SEO in Trichy, Karaikal, etc.)
Route::get('/shops/{location}', [PageController::class, 'shopDetail'])->name('shops.detail');

