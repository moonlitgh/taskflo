<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareUserData
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            View::share('user', Auth::user());
        }
        return $next($request);
    }
} 