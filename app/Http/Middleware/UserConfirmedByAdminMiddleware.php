<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserConfirmedByAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()){
            
            if($request->user()->confirmed_by_admin){
                
                return $next($request);
            }
            return abort(403, "Vous n'êtes pas authorisé");
        }
        return redirect(route('login'));
    }
}
