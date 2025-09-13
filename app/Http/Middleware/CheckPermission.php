<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permissionCodes): mixed
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Please login.'
            ], 401);
        }

        $user = Auth::user();

        // Check if user has a role assigned
        if (!$user->role) {
            return response()->json([
                'status' => 'error',
                'message' => 'User has no assigned role.'
            ], 403);
        }

        // Check if user has any of the required permissions
        $hasPermission = false;
        foreach ($permissionCodes as $permissionCode) {
            if ($user->role->permissions->contains('slug', $permissionCode)) {
                $hasPermission = true;
                break;
            }
        }

        if (!$hasPermission) {
            abort(404, '');
        }
        return $next($request);
    }
}
