<?php

namespace App\Http\Middleware;

use App\Services\SsoAuthClient;
use App\Support\SsoSession;
use Closure;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSsoIsAuthenticated
{
    public function __construct(
        private SsoAuthClient $ssoAuthClient,
        private SsoSession $ssoSession,
    ) {}

    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $this->ssoSession->token();

        if ($token === null) {
            return redirect()->guest(route('login'));
        }

        try {
            $user = $this->ssoAuthClient->check($token);
        } catch (ConnectionException|RequestException) {
            $this->ssoSession->forget();

            return redirect()->route('login')->withErrors([
                'email' => 'No se pudo validar la sesión con el servicio SSO.',
            ]);
        }

        if ($user === null) {
            $this->ssoSession->forget();

            return redirect()->route('login')->withErrors([
                'email' => 'La sesión SSO expiró. Iniciá sesión de nuevo.',
            ]);
        }

        $this->ssoSession->store($token, $user);

        return $next($request);
    }
}
