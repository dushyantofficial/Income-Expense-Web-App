<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (Auth::user() && Auth::user()->role == 'admin') {
            return $next($request);
        } elseif (Auth::user() && Auth::user()->role == 'user' && $user->status == "active") {

            return $next($request);
        } else
            Auth::logout();
        return redirect()->route('login')->with('danger', 'User Block Contact Admin....');
    }

}
