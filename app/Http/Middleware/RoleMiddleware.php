<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request and check user roles.
     *
     * Usage in routes: middleware('role:admin') or middleware('role:admin,teknisi')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        if (!empty($roles) && !$user->hasRole($roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
