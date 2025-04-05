<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // If the user is an admin and trying to access regular user routes
            if (Auth::user()->is_admin && $request->routeIs('dashboard') && !$request->routeIs('admin.*')) {
                return redirect()->route('admin.dashboard');
            }
            
            // If the user is not an admin and trying to access admin routes
            if (!Auth::user()->is_admin && $request->routeIs('admin.*')) {
                return redirect()->route('dashboard');
            }
        }
        
        return $next($request);
    }
}
