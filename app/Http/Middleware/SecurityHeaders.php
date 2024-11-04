<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! app()->environment('testing')) {
            $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000');
            $response->headers->set(
                'Content-Security-Policy',
                "default-src 'self' 'unsafe-inline' 'unsafe-eval'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net"
            );
            $response->headers->set('Expect-CT', 'enforce, max-age=30');
            $response->headers->set(
                'Permissions-Policy',
                'autoplay=(self), camera=(), encrypted-media=(self), fullscreen=(), geolocation=(self),'
                    . ' gyroscope=(self), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(self), usb=()'
            );
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,PATCH,DELETE,OPTIONS');
            $response->headers->set(
                'Access-Control-Allow-Headers',
                'Content-Type,Authorization,X-Requested-With,X-CSRF-Token'
            );

            // remove unwanted headers
            foreach (['Server', 'server', 'X-Powered-By'] as $header) {
                header_remove($header);
                $response->headers->remove(
                    key: $header,
                );
            }
        }

        return $response;
    }
}
