<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserCarController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserDocumentController;
use App\Http\Controllers\User\UserProfileController;

// Initial Redirection after Login
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && in_array($user->role_id, [1, 2])) {
        return redirect('/admin/dashboard');
    }
    return redirect('/user/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'redirect.role'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin & Organizer Routes (role 1 and 2)
    Route::middleware('role:1,2')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Orders
        Route::get('/admin/pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/admin/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');

        // Denda
        Route::redirect('/denda', '/admin/denda');
        Route::get('/admin/denda', [DendaController::class, 'index'])->name('denda.index');

        // Cars & Addons
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('cars', [CarController::class, 'index'])->name('cars.index');
            Route::get('cars/{series_number}', [CarController::class, 'show'])->name('cars.show');
            Route::get('addons', [AddOnController::class, 'index'])->name('addons.index');
            Route::get('addons/{id}', [AddOnController::class, 'show'])->name('addons.show');
        });

        // Brands
        Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');

        // Documents
        Route::get('/admin/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/admin/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    });

    // Admin ONLY Routes (role 1)
    Route::middleware('role:1')->group(function () {
        // Orders Modify
        Route::get('/admin/pesanan/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/admin/pesanan/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/admin/pesanan/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Denda Modify
        Route::get('/admin/denda/create', [DendaController::class, 'create'])->name('denda.create');
        Route::post('/admin/denda', [DendaController::class, 'store'])->name('denda.store');
        Route::get('/admin/denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
        Route::put('/admin/denda/{id}', [DendaController::class, 'update'])->name('denda.update');
        Route::delete('/admin/denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');

        // Cars & Addons Modify
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('cars/create', [CarController::class, 'create'])->name('cars.create');
            Route::post('cars', [CarController::class, 'store'])->name('cars.store');
            Route::get('cars/{series_number}/edit', [CarController::class, 'edit'])->name('cars.edit');
            Route::put('cars/{series_number}', [CarController::class, 'update'])->name('cars.update');
            Route::delete('cars/{series_number}', [CarController::class, 'destroy'])->name('cars.destroy');

            Route::get('addons/create', [AddOnController::class, 'create'])->name('addons.create');
            Route::post('addons', [AddOnController::class, 'store'])->name('addons.store');
            Route::get('addons/{id}/edit', [AddOnController::class, 'edit'])->name('addons.edit');
            Route::put('addons/{id}', [AddOnController::class, 'update'])->name('addons.update');
            Route::delete('addons/{id}', [AddOnController::class, 'destroy'])->name('addons.destroy');
        });

        // Brands Modify
        Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/admin/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

        // Documents Modify
        Route::put('/admin/documents/{id}/change-status', [DocumentController::class, 'changeStatus'])->name('document.changeStatus');
        Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    });

    // Employee ONLY Routes (role 2)
    Route::middleware('role:2')->group(function () {
        Route::get('/admin/returns', [App\Http\Controllers\Admin\ReturnController::class, 'index'])->name('returns.index');
        Route::get('/admin/returns/create/{order_id}', [App\Http\Controllers\Admin\ReturnController::class, 'create'])->name('returns.create');
        Route::post('/admin/returns', [App\Http\Controllers\Admin\ReturnController::class, 'store'])->name('returns.store');
        Route::get('/admin/returns/{id}', [App\Http\Controllers\Admin\ReturnController::class, 'show'])->name('returns.show');
    });

    // Customer Routes (role 3)
    Route::middleware('role:3')->group(function () {
        Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
        
        // User Cars
        Route::get('/user/cars', [UserCarController::class, 'index'])->name('user.cars.index');
        Route::get('/user/cars/{id}', [UserCarController::class, 'show'])->name('user.cars.show');
        
        // User Orders
        Route::get('/user/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
        Route::post('/user/orders', [UserOrderController::class, 'store'])->name('user.orders.store');
        Route::get('/user/orders/{id}', [UserOrderController::class, 'show'])->name('user.orders.show');
        Route::post('/user/orders/{id}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
        
        // User Documents
        Route::get('/user/documents', [UserDocumentController::class, 'index'])->name('user.documents.index');
        Route::get('/user/documents/create', [UserDocumentController::class, 'create'])->name('user.documents.create');
        Route::post('/user/documents', [UserDocumentController::class, 'store'])->name('user.documents.store');
        Route::get('/user/documents/{id}', [UserDocumentController::class, 'show'])->name('user.documents.show');
        Route::get('/user/documents/{id}/edit', [UserDocumentController::class, 'edit'])->name('user.documents.edit');
        Route::put('/user/documents/{id}', [UserDocumentController::class, 'update'])->name('user.documents.update');
        Route::delete('/user/documents/{id}', [UserDocumentController::class, 'destroy'])->name('user.documents.destroy');
        Route::get('/user/documents/{id}/download', [UserDocumentController::class, 'download'])->name('user.documents.download');
        
        // User Profile
        Route::get('/user/profile', [UserProfileController::class, 'edit'])->name('user.profile.index');
        Route::patch('/user/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
    });
});

require __DIR__ . '/auth.php';
