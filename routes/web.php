<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/products', ProductController::class)->parameters(['products' => 'producto']);
//Route::get('/products', [ProductController::class, 'index']);
//Route::get('/products/create', [ProductController::class, 'create']);
//Route::post('/products', [ProductController::class, 'store']);
//Route::get('/products/{producto}', [ProductController::class, 'show']);
//Route::get('/products/{producto}/edit', [ProductController::class, 'edit']);
//Route::put('/products/{producto}', [ProductController::class, 'update']);
//Route::delete('/products/{producto}', [ProductController::class, 'destroy']);

Route::get('/adultos', function () {
    return 'Bienvenido, eres mayor de edad.';
})->middleware('check.age');
