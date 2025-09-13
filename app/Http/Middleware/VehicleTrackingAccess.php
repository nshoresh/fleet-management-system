<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VehicleTrackingAccess
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->hasVehicleTrackingAccess()) {
            abort(403, 'You do not have permission to access vehicle tracking.');
        }

        return $next($request);
    }
}
