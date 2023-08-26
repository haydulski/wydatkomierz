<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GlobalLoginCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->missing('current-user') || session()->get('current-user') !== config('app.user')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
