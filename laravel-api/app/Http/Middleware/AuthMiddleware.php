<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthMiddleware
{
    public function handle($request, \Closure $next)
    {
        if (auth()->guest()) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }
}
