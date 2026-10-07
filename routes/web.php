<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PageController, SitemapController};
use App\Http\Controllers\Admin\{AdminAuthController, StaffCustomerController, ShopController, GodownController, DashboardController, TileCategoryController, TileTypeController};
use App\Http\Controllers\Admin\{UserController, ProductionCompanyController, AdminEnquiryController, QuotationController, TileSizeController, TileProductController, CompanyController};
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Api\{DealerEnquiryController};

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
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
// Location-Specific SEO Sub-Pages
Route::get('/shops/{location}', [PageController::class, 'shopDetail'])->name('shops.detail');
Route::get('/showrooms', [ShopController::class, 'index'])->name('showrooms');
Route::get('/showrooms/{slug}', [ShopController::class, 'show'])->name('showrooms.show');




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

    // Quotation Routes
    Route::get('/quotations/quick-create-new', [QuotationController::class, 'quickCreate'])->name('quotations.quick-create');
    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/create', [QuotationController::class, 'create'])->name('quotations.create');
    Route::post('/quotations', [QuotationController::class, 'store'])->name('quotations.store');
    Route::get('/quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::patch('/quotations/{quotation}/status', [QuotationController::class, 'updateStatus'])->name('quotations.update-status');
    // Locations Management (Accessible by Super Admin, Admin, Staff)
    Route::get('locations/fetch', [LocationController::class, 'fetch'])->name('locations.fetch');
    Route::resource('locations', LocationController::class);

    Route::get('/dealer-enquiries', [DealerEnquiryController::class, 'index'])->name('dealer-enquiries.index');
    Route::patch('/dealer-enquiries/{id}/status', [DealerEnquiryController::class, 'updateStatus'])->name('dealer-enquiries.updateStatus');
    Route::delete('/dealer-enquiries/{id}', [DealerEnquiryController::class, 'destroy'])->name('dealer-enquiries.destroy');

    // Restricted Access Routes (Super Admin & Admin Only)
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('users/fetch', [UserController::class, 'fetch'])->name('users.fetch');
        Route::resource('users', UserController::class);
    });
    Route::resource('shops', App\Http\Controllers\Admin\ShopController::class);
    //Godown
    // AJAX fetch route for table pagination & search filters
    Route::get('godowns/fetch', [GodownController::class, 'fetch'])->name('godowns.fetch');

    // RESTful CRUD routes (index, store, show, update, destroy)
    Route::resource('godowns', GodownController::class);

    Route::resource('tile-categories', TileCategoryController::class)->except(['create', 'show']);
    Route::resource('tile-types', TileTypeController::class)->except(['create', 'show']);

    Route::resource('tile-sizes', TileSizeController::class)->except(['create', 'show']);

    Route::get('/tile-products/print-all', [TileProductController::class, 'printAll'])->name('tile-products.printAll');
    Route::patch('/tile-products/{product}/update-quantity', [TileProductController::class, 'updateQuantity'])->name('tile-products.update-quantity');
    Route::patch('/tile-products/{product}/toggle-display-front', [TileProductController::class, 'toggleDisplayFront'])->name('tile-products.toggle-display-front');
    Route::resource('tile-products', TileProductController::class);
    Route::resource('production-companies', ProductionCompanyController::class)->except(['create', 'edit', 'show']);

    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company', [CompanyController::class, 'store'])->name('company.store');

    Route::post('/quotations/quick-store', [QuotationController::class, 'quickStore'])->name('quotations.quick-store');
    Route::middleware(['role:staff,sales_person'])->prefix('staff')->name('staff.')->group(function () {

        // My Dealers Route (explicitly passes type => 'dealer')
        Route::get('/dealers', [StaffCustomerController::class, 'index'])
            ->name('dealers.index')
            ->defaults('type', 'dealer');

        // My Customers Route (explicitly passes type => 'customer')
        Route::get('/customers', [StaffCustomerController::class, 'index'])
            ->name('customers.index')
            ->defaults('type', 'customer');

        // Store Route
        Route::post('/users', [StaffCustomerController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}/edit', [StaffCustomerController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [StaffCustomerController::class, 'update'])->name('users.update');
        Route::get('/products/{id}', [TileProductController::class, 'show'])->name('admin.products.show');
        Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
        Route::patch('/enquiries/{enquiry}/status', [AdminEnquiryController::class, 'updateStatus'])->name('enquiries.update-status');
    });
});
