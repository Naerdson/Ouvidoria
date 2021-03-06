<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class UsuarioAdministrador
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
        if(auth()->user()->nivel_id != 3){
            return redirect()->route('ouvidoria.home')->with(['message' => 'Você não tem permissão de super administrador', 'type' => 'danger']);
        }

        return $next($request);
    }
}
