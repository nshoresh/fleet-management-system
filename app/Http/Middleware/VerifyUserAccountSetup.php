<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserAccountSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        // Check if user account is active
        if (!$user->isActive()) {
            abort(403, 'Your account is not active. Please contact support.');
        }
        // Check if user email is verified
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        // Check if user needs vehicle owner setup (the main requirement)
        // If user is NOT a vehicle owner, redirect them to complete setup
        if ($user->isClientUser() && !$user->isVehicleOwner()) {
            return redirect()->route('app.client.onbaord.index');
        }

        // All checks passed, allow the request to proceed
        return $next($request);
    }
}
