<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->role) {
            abort(403, 'Unauthorized');
        }

        $allowedRoles = array_map('strval', $roles);
        $userRoleId = (string) $user->role_id;
        $userRoleName = (string) $user->role->name;

        if (! in_array($userRoleId, $allowedRoles, true) && ! in_array($userRoleName, $allowedRoles, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
