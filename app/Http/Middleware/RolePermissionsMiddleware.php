<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roleOrPermission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (Auth::check()) {
            if (Auth::user()->role->hasAllPermissions($permissions)) {
                return $next($request);
            } else {
                abort(404, 'Not Found');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
