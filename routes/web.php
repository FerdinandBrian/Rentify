<?php

use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && in_array($user->role_id, [1, 2], true)) {
        return redirect('/admin/dashboard');
    }

    abort(403, 'Unauthorized');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:1,2')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/admin/pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/admin/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');

        Route::redirect('/denda', '/admin/denda');
        Route::get('/admin/denda', [DendaController::class, 'index'])->name('denda.index');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('cars', [CarController::class, 'index'])->name('cars.index');
            Route::middleware('role:1')->group(function () {
                Route::get('cars/create', [CarController::class, 'create'])->name('cars.create');
                Route::post('cars', [CarController::class, 'store'])->name('cars.store');
                Route::get('cars/{series_number}/edit', [CarController::class, 'edit'])->name('cars.edit');
                Route::put('cars/{series_number}', [CarController::class, 'update'])->name('cars.update');
                Route::delete('cars/{series_number}', [CarController::class, 'destroy'])->name('cars.destroy');
            });
            Route::get('cars/{series_number}', [CarController::class, 'show'])
                ->where('series_number', '^(?!create$).+')
                ->name('cars.show');

            Route::get('addons', [AddOnController::class, 'index'])->name('addons.index');
            Route::middleware('role:1')->group(function () {
                Route::get('addons/create', [AddOnController::class, 'create'])->name('addons.create');
                Route::post('addons', [AddOnController::class, 'store'])->name('addons.store');
                Route::get('addons/{id}/edit', [AddOnController::class, 'edit'])->name('addons.edit');
                Route::put('addons/{id}', [AddOnController::class, 'update'])->name('addons.update');
                Route::delete('addons/{id}', [AddOnController::class, 'destroy'])->name('addons.destroy');
            });
            Route::get('addons/{id}', [AddOnController::class, 'show'])->name('addons.show');
        });

        Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');

        Route::get('/admin/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/admin/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    });

    Route::middleware('role:1')->group(function () {
        Route::get('/admin/pesanan/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/admin/pesanan/{id}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/admin/pesanan/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('/admin/denda/create', [DendaController::class, 'create'])->name('denda.create');
        Route::post('/admin/denda', [DendaController::class, 'store'])->name('denda.store');
        Route::get('/admin/denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
        Route::put('/admin/denda/{id}', [DendaController::class, 'update'])->name('denda.update');
        Route::delete('/admin/denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');

        Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/admin/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

        Route::put('/admin/documents/{id}/change-status', [DocumentController::class, 'changeStatus'])->name('document.changeStatus');
        Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    });
});

require __DIR__ . '/auth.php';
