<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIfAuthenticated
{ /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Redirige a la página de inicio de sesión si el usuario no está autenticado
            return redirect()->route('login');
        }
        return $next($request);
    }
}