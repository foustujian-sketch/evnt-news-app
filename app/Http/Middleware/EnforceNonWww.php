<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnforceNonWww
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->header('host');
        
        if ($host && str_starts_with(strtolower($host), 'www.')) {
            $nonWwwHost = substr($host, 4);
            $redirectUrl = $request->scheme() . '://' . $nonWwwHost . $request->getRequestUri();
            return redirect()->to($redirectUrl, 301);
        }

        return $next($request);
    }
}
