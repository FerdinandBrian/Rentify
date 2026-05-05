<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Brand Routes Admin
    Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/admin/brands/store', [BrandController::class, 'store'])->name('brands.store');    
    Route::get('/admin/brands/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/admin/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/admin/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
});

require __DIR__.'/auth.php';
