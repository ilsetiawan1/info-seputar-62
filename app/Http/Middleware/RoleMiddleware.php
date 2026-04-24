<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle role-based access.
     *
     * Usage di route: middleware('role:admin,editor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return $request->wantsJson() 
                ? response()->json(['message' => 'Unauthenticated.'], 401)
                : redirect()->route('login');
        }

        if (!$user->is_active) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Akun Anda dinonaktifkan.'], 403)
                : abort(403, 'Akun Anda dinonaktifkan.');
        }

        if (!$user->hasRole($roles)) {
            return $request->wantsJson()
                ? response()->json([
                    'message' => 'Akses ditolak. Role Anda tidak memiliki izin untuk aksi ini.',
                    'your_role' => $user->role,
                    'required_roles' => $roles,
                ], 403)
                : abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
