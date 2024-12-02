<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->hasRole('user')) {
            return redirect(route('filament.user')); // Redirect to user panel route
        } elseif (auth()->user()->hasRole('admin')) {
            return redirect(route('filament.admin')); // Redirect to admin panel route
        } elseif (auth()->user()->hasRole('super_admin')) {
            return redirect(route('filament.admin'));
        }
        
        // return $next($request);
        
        // if (auth()->user()->hasRole('super_admin')) {
        //     return redirect(route('filament.admin'));
        // } elseif (auth()->user()->hasRole('admin')) {
        //     return redirect(route('filament.admin')); // Redirect to admin panel
        // } else if (auth()->user()->hasRole('user')) {
        //     return $next($request); // Allow user panel access
        // }
    
        return abort(403); 
    }
}
