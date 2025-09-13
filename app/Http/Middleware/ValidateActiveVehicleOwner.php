<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ValidateActiveVehicleOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check authentication
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Validate client user with vehicle owner status
        if ($user->isClientUser() && $user->isVehicleOwner()) {
            $vehicleOwner = $user->vehicleOwner;
            // Check if vehicle owner is inactive
            if (!$vehicleOwner->isActive()) {
                return redirect()->route('app.client.onbaord.account-pending-approval');
            }
        }

        return $next($request);
    }
}
