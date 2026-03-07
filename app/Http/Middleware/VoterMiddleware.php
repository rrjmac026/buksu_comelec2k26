<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VoterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'voter') {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}