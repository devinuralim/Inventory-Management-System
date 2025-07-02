<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
if (Auth::check() && Auth::user()->usertype != 'user') {
    return redirect('/dashboard');
        }

        return $next($request);
    }
}
