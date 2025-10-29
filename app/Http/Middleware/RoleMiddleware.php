<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Jika belum login
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Jika role user tidak sesuai dengan salah satu role yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Access denied for role: ' . $user->role);
        }

        return $next($request);
    }
}
