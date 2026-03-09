<?php

use App\Http\Controllers\Admin\User\UserCreateController;
use App\Http\Controllers\Admin\User\UserDestroyController;
use App\Http\Controllers\Admin\User\UserEditController;
use App\Http\Controllers\Admin\User\UserIndexController;
use App\Http\Controllers\Admin\User\UserShowController;
use App\Http\Controllers\Admin\User\UserStoreController;
use App\Http\Controllers\Admin\User\UserUpdateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', UserIndexController::class)->name('users.index');
    Route::get('/users/create', UserCreateController::class)->name('users.create');
    Route::post('/users', UserStoreController::class)->name('users.store');
    Route::get('/users/{user}', UserShowController::class)->name('users.show');
    Route::get('/users/{user}/edit', UserEditController::class)->name('users.edit');
    Route::put('/users/{user}', UserUpdateController::class)->name('users.update');
    Route::delete('/users/{user}', UserDestroyController::class)->name('users.destroy');
});

require __DIR__.'/auth.php';
