<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCdnHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Reemplaza 'https://mi-cdn.com' con la URL de tu CDN
        $response->header('Content-Delivery-Network', 'https://cdn.tailwindcss.com');

        return $response;    }
}
