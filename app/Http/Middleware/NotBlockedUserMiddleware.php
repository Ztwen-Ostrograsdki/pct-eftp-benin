<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotBlockedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()){
            
            if($request->user()->blocked == false){
                
                return $next($request);
            }
            else{

                Auth::logout();

                request()->session()->invalidate();

                request()->session()->regenerateToken();

                return abort(403, "Vous n'êtes pas authorisé");
            }
            
        }
        return redirect(route('login'));
    }
}
