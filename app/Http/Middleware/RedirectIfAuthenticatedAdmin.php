<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        
        
        if (Auth::guard($guard)->check()) {
            if(Auth::guard('admin')->user()->otp_verification_status==2){
             return redirect()->intended('/admin/dashboard');

            }else{
                Auth::guard('admin')->logout();
                $request->session()->flush();
                $request->session()->regenerate();

            }
        }

        return $next($request);
    }
}
