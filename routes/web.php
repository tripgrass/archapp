<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'authentication'])->name('authentication');
    Route::match(['GET', 'POST'], 'register', [AuthController::class, 'register'])->name('register');

    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
    Route::get('logout', [AuthController::class, 'logout']);
});
require __DIR__.'/auth.php';
