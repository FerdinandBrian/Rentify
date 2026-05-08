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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Order Admin
    Route::get('/admin/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/admin/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/admin/pesanan/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/admin/pesanan/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/admin/pesanan/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // CRUD Denda Admin
    Route::redirect('/denda', '/admin/denda');
    Route::get('/admin/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('/admin/denda/create', [DendaController::class, 'create'])->name('denda.create');
    Route::post('/admin/denda', [DendaController::class, 'store'])->name('denda.store');
    Route::get('/admin/denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
    Route::put('/admin/denda/{id}', [DendaController::class, 'update'])->name('denda.update');
    Route::delete('/admin/denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');

    // CRUD Car & Addon Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('cars', CarController::class)->names('cars');
        Route::resource('addons', AddOnController::class)->names('addons');
    });

    // Brand Routes Admin
    Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/admin/brands/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // Document Management Routes Admin
    Route::get('/admin/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/admin/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::put('/admin/documents/{id}/change-status', [DocumentController::class, 'changeStatus'])->name('document.changeStatus');
    Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
});

require __DIR__.'/auth.php';