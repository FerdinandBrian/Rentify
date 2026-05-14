<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserCarController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserDocumentController;
use App\Http\Controllers\User\UserProfileController;

Route::get('/', function () {
    $user = Auth::user();
    if ($user && $user->role_id == 1) {
        return redirect('/admin/dashboard');
    }
    return redirect('/user/dashboard');
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && $user->role_id == 1) {
        return redirect('/admin/dashboard');
    }
    return redirect('/user/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

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
    Route::get('/admin/documents', [App\Http\Controllers\Admin\DocumentController::class, 'index'])->name('documents.index');
    Route::get('/admin/documents/{id}', [App\Http\Controllers\Admin\DocumentController::class, 'show'])->name('documents.show');
    Route::put('/admin/documents/{id}/change-status', [App\Http\Controllers\Admin\DocumentController::class, 'changeStatus'])->name('document.changeStatus');
    Route::delete('/admin/documents/{id}', [App\Http\Controllers\Admin\DocumentController::class, 'destroy'])->name('document.destroy');

    // User Routes - Only accessible by regular users
    Route::prefix('user')->name('user.')->middleware('redirect.role')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        
        // Profile
        Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        
        // Cars
        Route::get('/cars', [UserCarController::class, 'index'])->name('cars');
        Route::get('/cars/{id}', [UserCarController::class, 'show'])->name('cars.show');
        
        // Orders
        Route::get('/orders', [UserOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{id}', [UserOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');
        Route::post('/orders/{id}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');
        
        // Documents
        Route::get('/documents', [UserDocumentController::class, 'index'])->name('documents');
        Route::get('/documents/create', [UserDocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [UserDocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{id}', [UserDocumentController::class, 'show'])->name('documents.show');
        Route::get('/documents/{id}/edit', [UserDocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{id}', [UserDocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{id}', [UserDocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('/documents/{id}/download', [UserDocumentController::class, 'download'])->name('documents.download');
    });
});

require __DIR__.'/auth.php';