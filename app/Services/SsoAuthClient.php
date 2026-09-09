<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class SsoAuthClient
{
    /**
     * @return array{token: string, user: array<string, mixed>}
     */
    public function login(string $email, string $password): array
    {
        $response = $this->client()->post('/api/v1/auth/login', [
            'email' => $email,
            'password' => $password,
            'device' => config('services.sso.device'),
        ]);

        if ($response->unauthorized()) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no coinciden con el servicio SSO.',
            ]);
        }

        if ($response->tooManyRequests()) {
            throw ValidationException::withMessages([
                'email' => 'Demasiados intentos de inicio de sesión. Esperá un minuto.',
            ]);
        }

        if ($response->unprocessableEntity()) {
            throw ValidationException::withMessages([
                'email' => 'Revisá el email y la contraseña.',
            ]);
        }

        $response->throw();

        $token = $response->json('token');
        $user = $response->json('user');

        if (! is_string($token) || $token === '' || ! is_array($user)) {
            throw new RuntimeException('El servicio SSO devolvió una respuesta inválida.');
        }

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function check(string $token): ?array
    {
        $response = $this->client($token)->get('/api/v1/auth/check');

        if ($response->unauthorized()) {
            return null;
        }

        $response->throw();

        $user = $response->json('user');

        return is_array($user) ? $user : null;
    }

    public function logout(string $token): void
    {
        $this->client($token)->post('/api/v1/auth/logout');
    }

    private function client(?string $token = null): PendingRequest
    {
        $request = Http::sso();

        if (filled($token)) {
            return $request->withToken($token);
        }

        return $request;
    }
}
