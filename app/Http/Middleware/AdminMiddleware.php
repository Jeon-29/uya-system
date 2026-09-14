<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure user is authenticated and possesses the required role
        if (! auth()->check() || ! in_array(auth()->user()->role ?? 'member', ['admin', 'officer'])) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
