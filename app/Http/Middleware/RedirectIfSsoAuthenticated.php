<?php

namespace App\Http\Middleware;

use App\Support\SsoSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfSsoAuthenticated
{
    public function __construct(private SsoSession $ssoSession) {}

    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->ssoSession->isAuthenticated()) {
            return redirect()->route('products.index');
        }

        return $next($request);
    }
}
