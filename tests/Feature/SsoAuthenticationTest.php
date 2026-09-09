<?php

use App\Models\Producto;
use Illuminate\Support\Facades\Http;

function ssoUserPayload(): array
{
    return [
        'id' => 7,
        'name' => 'Ada Lovelace',
        'email' => 'ada@example.com',
        'dni' => 30123456,
    ];
}

function fakeSuccessfulSsoLogin(): void
{
    Http::preventStrayRequests();

    Http::fake([
        '*/api/v1/auth/login' => Http::response([
            'message' => 'Authenticated.',
            'token' => '1|sso-token-de-prueba',
            'token_type' => 'Bearer',
            'user' => ssoUserPayload(),
        ]),
        '*/api/v1/auth/check' => Http::response([
            'authenticated' => true,
            'user' => ssoUserPayload(),
        ]),
        '*/api/v1/auth/logout' => Http::response([
            'message' => 'Logged out.',
        ]),
    ]);
}

test('guests cannot open the products table', function () {
    $this->get(route('products.index'))
        ->assertRedirect(route('login'));
});

test('the login page is available to guests', function () {
    $this->get(route('login'))
        ->assertSuccessful()
        ->assertSee('Iniciar sesión', false)
        ->assertSee('SSO-APP', false);
});

test('a valid sso login opens the products table', function () {
    fakeSuccessfulSsoLogin();

    Producto::factory()->create(['nombre' => 'Te verde']);

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'ada@example.com',
            'password' => 'password',
        ])
        ->assertRedirect(route('products.index'));

    $this->get(route('products.index'))
        ->assertSuccessful()
        ->assertSee('Listado de productos', false)
        ->assertSee('Te verde', false)
        ->assertSee('Ada Lovelace', false);
});

test('invalid sso credentials stay on login', function () {
    Http::preventStrayRequests();

    Http::fake([
        '*/api/v1/auth/login' => Http::response([
            'message' => 'The provided credentials are incorrect.',
        ], 401),
    ]);

    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'ada@example.com',
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');
});
