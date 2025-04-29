<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth()->user()->role == 'admin' || Auth()->user()->role == 'teacher') {
            return $next($request);
        } else if (Auth()->user()->role == 'student') {
            return redirect()->route('student.dashboard');
        }
        abort(401);
    }
}
