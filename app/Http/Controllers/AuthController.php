<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\SsoAuthClient;
use App\Support\SsoSession;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(
        private SsoAuthClient $ssoAuthClient,
        private SsoSession $ssoSession,
    ) {}

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $authenticated = $this->ssoAuthClient->login(
                $request->validated('email'),
                $request->validated('password'),
            );
        } catch (ConnectionException|RequestException) {
            throw ValidationException::withMessages([
                'email' => 'El servicio SSO no está disponible. Confirmá que corre en '.config('services.sso.url').'.',
            ]);
        }

        $this->ssoSession->store($authenticated['token'], $authenticated['user']);

        return redirect()->intended(route('products.index'));
    }

    public function destroy(): RedirectResponse
    {
        $token = $this->ssoSession->token();

        if ($token !== null) {
            try {
                $this->ssoAuthClient->logout($token);
            } catch (ConnectionException|RequestException $exception) {
                report($exception);
            }
        }

        $this->ssoSession->forget();

        return redirect()->route('inicio')->with('success', 'Sesión cerrada correctamente.');
    }
}
