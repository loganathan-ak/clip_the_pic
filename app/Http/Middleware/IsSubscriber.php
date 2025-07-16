<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSubscriber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Check if the user is NOT logged in
    if (!Auth::check()) {
        // Store the intended URL in the session before redirecting
        return redirect()->guest(route('login'))->with('status', 'You need to login to access for this page.');
    }


    $user = Auth::user();

    // Redirect based on role
    if ($user->role === 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'qualitychecker') {
        return redirect()->route('qc.dashboard');
    }

    return $next($request);
}

}
