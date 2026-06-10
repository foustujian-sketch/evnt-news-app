<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (method_exists($response, 'headers')) {
            // Add modern security headers
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Content-Security-Policy', "frame-ancestors 'self'");
            $response->headers->set('Content-Type', 'text/html; charset=utf-8');
            
            // Remove deprecated headers flagged by scanners
            $response->headers->remove('X-Frame-Options');
            $response->headers->remove('X-XSS-Protection');
            $response->headers->remove('Expires');
        }

        return $response;
    }
}
