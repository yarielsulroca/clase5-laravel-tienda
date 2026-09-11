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
   // Route::resource('/products', ProductController::class)->parameters(['products' => 'producto']);
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{producto}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{producto}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{producto}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{producto}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::get('/adultos', function () {
    return 'Bienvenido, eres mayor de edad.';
})->middleware('check.age');
