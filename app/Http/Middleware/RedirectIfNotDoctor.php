<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotDoctor
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $guard
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, $guard = 'doctor')
    {
        if (Auth::guard($guard)->check()) {
            auth()->setDefaultDriver($guard);

            return $next($request);
        }

        $redirectToRoute = '';
        if (!$request->expectsJson()) {
            $redirectToRoute = '/';
            toast(__('Unauthenticated Please Login First'));
        }

        throw new AuthenticationException(
            'Unauthenticated.',
            [$guard],
            $redirectToRoute,
        );
    }
}
