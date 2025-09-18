<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PortalMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$portals)
    {

        if (Auth::check()) {
            foreach ($portals as $portal) {
                if (auth()->user()->role === $portal) {
                    return $next($request);
                }
            }

            return redirect()->route(Auth::user()->role . '.portal');
        }

 return redirect()->route('welcome');
    }


}
