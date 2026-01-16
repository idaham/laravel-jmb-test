<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            // Staff → Filament
            if (auth()->user()->can('access system')) {
                return redirect('/system');
            }

            // Residents → portal (future)
            return redirect('/portal');
        }

        return $next($request);
    }
}
