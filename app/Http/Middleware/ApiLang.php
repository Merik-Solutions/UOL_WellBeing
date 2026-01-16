<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class ApiLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Accept-Language')) {
            app()->setLocale($request->header('Accept-Language'));
            Carbon::setLocale($request->header('Accept-Language'));
        }
        return $next($request);
    }
}
