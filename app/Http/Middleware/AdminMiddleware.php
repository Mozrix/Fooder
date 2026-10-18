<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) return redirect()->guest(route('login'));
        abort_unless($request->user()->role === 'admin', 403);
        return $next($request);
    }
}
