<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'inicio'])->name('inicio');

Route::middleware('sso.guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:login')->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('sso.auth')
    ->name('logout');

Route::middleware('sso.auth')->group(function (): void {
    Route::resource('/products', ProductController::class)->parameters(['products' => 'producto']);
});

Route::get('/adultos', function () {
    return 'Bienvenido, eres mayor de edad.';
})->middleware('check.age');
