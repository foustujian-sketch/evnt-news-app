<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIndex
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->getRequestUri();
        
        // If the URL explicitly contains /index.php or /index.html, strip it and 301 redirect.
        if (str_contains(strtolower($uri), '/index.php') || str_contains(strtolower($uri), '/index.html')) {
            $newUri = str_ireplace(['/index.php', '/index.html'], '', $uri);
            if ($newUri === '') {
                $newUri = '/';
            }
            return redirect()->to($newUri, 301);
        }

        return $next($request);
    }
}
