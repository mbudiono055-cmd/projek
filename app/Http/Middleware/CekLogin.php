<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('login')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
