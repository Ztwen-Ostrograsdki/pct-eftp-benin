<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdminsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->hasRole(['admin-1', 'admin-2', 'admin-3', 'admin-4', 'admin-5'])) return $next($request);

        else return abort(403, "Vous n'êtes pas authorisé");
    }
}
