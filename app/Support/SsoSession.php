<?php

namespace App\Support;

class SsoSession
{
    public function token(): ?string
    {
        $token = session('sso.token');

        return is_string($token) && $token !== '' ? $token : null;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function user(): ?array
    {
        $user = session('sso.user');

        return is_array($user) ? $user : null;
    }

    public function isAuthenticated(): bool
    {
        return $this->token() !== null;
    }

    /**
     * @param  array<string, mixed>  $user
     */
    public function store(string $token, array $user): void
    {
        session([
            'sso.token' => $token,
            'sso.user' => $user,
        ]);
    }

    public function forget(): void
    {
        session()->forget(['sso.token', 'sso.user']);
    }
}
