<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $userType): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->user_type->slug === $userType) {
            return $next($request);
        }

        // If the user doesn't have the required role
        abort(403, 'Unauthorized action.');
    }
}
