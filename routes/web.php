<?php

use App\Http\Controllers\Admin\AddOnController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserCarController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserDocumentController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\UserProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Initial Redirection after Login (show welcome for guests)
Route::get('/', function () {
    if (! Auth::check()) {
        return view('welcome');
    }

    $user = Auth::user();

    if ($user && in_array($user->role_id, [1, 2], true)) {
        return redirect('/admin/dashboard');
    }

    return redirect('/user/dashboard');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && in_array($user->role_id, [1, 2], true)) {
        return redirect('/admin/dashboard');
    }

    return redirect('/user/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'redirect.role'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:1,2')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/admin/pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/admin/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');

        Route::get('/admin/returns', [ReturnController::class, 'index'])->name('returns.index');
        Route::get('/admin/returns/create/{orderId}', [ReturnController::class, 'create'])->name('returns.create');
        Route::post('/admin/returns', [ReturnController::class, 'store'])->name('returns.store');
        Route::get('/admin/returns/{id}', [ReturnController::class, 'show'])->name('returns.show');

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
        Route::put('/admin/pesanan/{id}/approve', [OrderController::class, 'approve'])->name('orders.approve');
        Route::put('/admin/pesanan/{id}/reject', [OrderController::class, 'reject'])->name('orders.reject');

        Route::get('/admin/denda/create', [DendaController::class, 'create'])->name('denda.create');
        Route::post('/admin/denda', [DendaController::class, 'store'])->name('denda.store');
        Route::get('/admin/denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
        Route::put('/admin/denda/{id}', [DendaController::class, 'update'])->name('denda.update');
        Route::delete('/admin/denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('addons/create', [AddOnController::class, 'create'])->name('addons.create');
            Route::post('addons', [AddOnController::class, 'store'])->name('addons.store');
            Route::get('addons/{id}/edit', [AddOnController::class, 'edit'])->name('addons.edit');
            Route::put('addons/{id}', [AddOnController::class, 'update'])->name('addons.update');
            Route::delete('addons/{id}', [AddOnController::class, 'destroy'])->name('addons.destroy');
        });

        Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/admin/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

        Route::put('/admin/documents/{id}/change-status', [DocumentController::class, 'changeStatus'])->name('document.changeStatus');
        Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    });

    Route::prefix('user')->name('user.')->middleware('role:3')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::get('/cars', [UserCarController::class, 'index'])->name('cars.index');
        Route::get('/cars/{id}', [UserCarController::class, 'show'])->name('cars.show');

        Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{id}', [UserOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');

        Route::get('/documents', [UserDocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/create', [UserDocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [UserDocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{id}', [UserDocumentController::class, 'show'])->name('documents.show');
        Route::get('/documents/{id}/edit', [UserDocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{id}', [UserDocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{id}', [UserDocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('/documents/{id}/download', [UserDocumentController::class, 'download'])->name('documents.download');

        Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.index');
        Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__ . '/auth.php';
