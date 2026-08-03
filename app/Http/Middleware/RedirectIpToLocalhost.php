<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIpToLocalhost
{
    public function handle(Request $request, Closure $next): Response
    {
        $appUrl = parse_url((string) config('app.url'));

        if (
            $request->getHost() === '127.0.0.1'
            && ($appUrl['host'] ?? null) === 'localhost'
        ) {
            $scheme = $appUrl['scheme'] ?? $request->getScheme();
            $port = isset($appUrl['port']) ? ':'.$appUrl['port'] : '';
            $url = $scheme.'://localhost'.$port.$request->getRequestUri();

            return redirect()->away($url);
        }

        return $next($request);
    }
}