<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }

        $user = Auth::user();

        if ($role === 'admin' && $user->is_admin) {
            return $next($request);
        }

        if ($role === 'dokter' && !is_null($user->dokter_id)) {
            return $next($request);
        }

        if ($role === 'member' && !is_null($user->member_id) && !$user->is_admin) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. You don\'t have access to this page!');
    }
}
