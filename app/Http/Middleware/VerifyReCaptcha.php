<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class VerifyReCaptcha
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);

        return $next($request);
    }
}
