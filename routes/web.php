<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DendaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/admin/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/admin/pesanan/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/admin/pesanan/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/admin/pesanan/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/admin/pesanan/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::redirect('/denda', '/admin/denda');
    Route::get('/admin/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('/admin/denda/create', [DendaController::class, 'create'])->name('denda.create');
    Route::post('/admin/denda', [DendaController::class, 'store'])->name('denda.store');
    Route::get('/admin/denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
    Route::put('/admin/denda/{id}', [DendaController::class, 'update'])->name('denda.update');
    Route::delete('/admin/denda/{id}', [DendaController::class, 'destroy'])->name('denda.destroy');
});

require __DIR__.'/auth.php';
