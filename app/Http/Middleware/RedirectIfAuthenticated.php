<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Check if accessing admin routes
                if ($request->is('admin*')) {
                    // Only allow admin users to access admin routes
                    if (Auth::guard($guard)->user()->is_admin) {
                        // Admin user is already authenticated and trying to access login
                        return redirect(RouteServiceProvider::ADMIN_HOME);
                    } else {
                        // Not an admin, redirect to user dashboard
                        return redirect(RouteServiceProvider::HOME);
                    }
                }
                
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
} 