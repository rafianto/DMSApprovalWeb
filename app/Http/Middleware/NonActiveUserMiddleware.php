<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonActiveUserMiddleware
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
        // dd($request);
        if(!is_null($request->user()))
        {
            // jika user belum aktif
            if($request->user()->isactive != "Y")
            {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return route('login');
            }
        }
        return $next($request);
    }
}
