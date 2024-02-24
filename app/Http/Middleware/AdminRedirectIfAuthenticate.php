<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminRedirectIfAuthenticate
{
    /**
     * Handle an incoming request.`
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {

            if (Auth::guard('admin')->check()) {
                 return redirect()->route('admin.dashboard');
            }


        return $next($request);
    }
}
