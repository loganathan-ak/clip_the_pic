<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
           // Check if the user is NOT logged in
    if (!Auth::check()) {
        // Store the intended URL in the session before redirecting
        return redirect()->guest(route('login'))->with('status', 'You need to login to access for this page.');
    }

    // If the user is logged in, check their role
    if (Auth::user()->role !== 'superadmin') {
        return abort(403, 'Access denied. Only Super admin can view this page.');
    }


    return $next($request);
    }
}
