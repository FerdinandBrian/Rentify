<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DocumentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes accessible by both Admin and Organizer
    Route::middleware('role:1,2')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Order Admin (Index & Show)
        Route::get('/admin/pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/admin/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');

        // CRUD Denda Admin (Index)
        Route::redirect('/denda', '/admin/denda');
        Route::get('/admin/denda', [DendaController::class, 'index'])->name('denda.index');

        // CRUD Car & Addon Admin (Index & Show)
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('cars', [CarController::class, 'index'])->name('cars.index');
            Route::get('cars/{series_number}', [CarController::class, 'show'])->name('cars.show');
            Route::get('addons', [AddOnController::class, 'index'])->name('addons.index');
            Route::get('addons/{id}', [AddOnController::class, 'show'])->name('addons.show');
        });

        // Brand Routes Admin (Index)
        Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');

        // Document Management Routes Admin (Index & Show)
        Route::get('/admin/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/admin/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    });

    // Routes accessible ONLY by Admin
    Route::middleware('role:1')->group(function () {
        // CRUD Order Admin (Edit, Update, Destroy)
        Route::get('/admin/pesanan/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/admin/pesanan/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/admin/pesanan/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // CRUD Denda Admin (Create, Store, Edit, Update, Destroy)
        Route::get('/admin/denda/create', [DendaController::class, 'create'])->name('denda.create');
        Route::post('/admin/denda', [DendaController::class, 'store'])->name('denda.store');
        Route::get('/admin/denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
        Route::put('/admin/denda/{id}', [DendaController::class, 'update'])->name('denda.update');
        Route::delete('/admin/denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');

        // CRUD Car & Addon Admin (Modify)
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

        // Brand Routes Admin (Modify)
        Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/admin/brands/{id}', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

        // Document Management Routes Admin (Modify)
        Route::put('/admin/documents/{id}/change-status', [DocumentController::class, 'changeStatus'])->name('document.changeStatus');
        Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    });
});

require __DIR__ . '/auth.php';
