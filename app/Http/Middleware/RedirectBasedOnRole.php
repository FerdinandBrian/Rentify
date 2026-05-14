<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user) {
            // Check if user is admin (role_id = 1, assuming admin role)
            if ($user->role_id == 1) {
                // If trying to access user routes, redirect to admin
                if ($request->is('user/*')) {
                    return redirect('/admin/dashboard');
                }
            } else {
                // Regular user trying to access admin routes
                if ($request->is('admin/*')) {
                    return redirect('/user/dashboard');
                }
            }
        }
        
        return $next($request);
    }
}
