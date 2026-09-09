<?php

use App\Models\Producto;

test('the catalog home shows product cards and a login link', function () {
    $producto = Producto::factory()->create([
        'nombre' => 'Cafe especial',
        'descripcion' => 'Granos tostados de origen unico.',
        'precio' => 12.5,
        'stock' => 8,
    ]);

    $this->get(route('inicio'))
        ->assertSuccessful()
        ->assertSee('Productos destacados', false)
        ->assertSee('Iniciar sesión', false)
        ->assertSee($producto->nombre, false)
        ->assertSee('Stock bajo', false);
});

test('the catalog home paginates products', function () {
    Producto::factory()->count(13)->create();

    $this->get(route('inicio'))
        ->assertSuccessful()
        ->assertSee('rel="next"', false);
});
