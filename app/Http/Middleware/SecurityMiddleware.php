<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Closure;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        Log::info("Entering SecurityMiddleware in handle() at path " . $path);
        
        $securityCheck = true;
        
        if($request->is('/') ||
            $request->is('home') ||
            $request->is('login') ||
            $request->is('processRegister') ||
            $request->is('processLogin') ||
            $request->is('register') ||
            Session::get('principal') == true)
        {
            $securityCheck = false;
        }
        
        Log::info($securityCheck ? "Security Middleware in handle() needs security" :
            "Security Middleware in handle() No Security Required");
        
        $enable = true;
        
        if($securityCheck && $enable)
        {
            Log::info("Leaving MySecurityMiddleware in handle() doing a redirect to login");
            return redirect('/login');
        }
        return $next($request);
    }
}
