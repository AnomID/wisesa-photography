<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (auth()->user()->role !== 'user') {
            return redirect()->route('landing')->with('error', 'Akses ditolak. Hanya user yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
