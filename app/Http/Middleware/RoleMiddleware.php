<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role === 'admin') {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login');
            }
            return $next($request);
        }

        if ($role === 'pengurus') {
            if (!Auth::guard('member')->check() || Auth::guard('member')->user()->role !== 'pengurus') {
                return redirect()->route('login')->withErrors(['role' => 'Akses khusus Pengurus.']);
            }
            return $next($request);
        }

        if ($role === 'anggota') {
            if (!Auth::guard('member')->check()) {
                return redirect()->route('login');
            }
            return $next($request);
        }

        return $next($request);
    }
}
