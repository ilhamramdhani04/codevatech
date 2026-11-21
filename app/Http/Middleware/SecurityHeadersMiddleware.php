<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Tambahkan security headers ke setiap response.
     *
     * Headers:
     * - X-Frame-Options: Cegah clickjacking
     * - X-Content-Type-Options: Cegah MIME type sniffing
     * - X-XSS-Protection: Legacy XSS filter (untuk browser lama)
     * - Referrer-Policy: Batasi informasi referrer
     * - Strict-Transport-Security: Paksa HTTPS (HSTS)
     * - Content-Security-Policy: Batasi sumber resource
     * - Permissions-Policy: Batasi akses fitur browser
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // HSTS — hanya aktif di production (HTTPS)
        if (app()->environment('production')) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        // CSP — cukup permisif untuk Vite/Tailwind, tapi tetap aman
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; "
            . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net; "
            . "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net data:; "
            . "img-src 'self' data: https:; "
            . "connect-src 'self' ws: wss:; "
            . "frame-src 'self' https://www.google.com https://*.google.com https://*.google.co.id; "
            . "frame-ancestors 'self';"
        );

        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=()'
        );

        return $response;
    }
}
