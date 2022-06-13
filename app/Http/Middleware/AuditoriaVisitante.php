<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuditoriaVisitante extends Middleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next) {

        try {
            $token = $request->header('X-Authorization');
            /*$tokenValido = \App\Helpers\Auth::Check($token);
            if (!$tokenValido) {
                $result = ['message' => "mensajes.no_login", 'success' => false];
                return response()->json( $result, 401);
            }*/
        } catch (\Exception $exc) {
            logger('error en middlerware ' . $exc->getMessage() .  ', archivo: ' . $exc->getFile() . '( linea: ' . $exc->getLine() );
            $result = ['message' => "servicio no disponible", 'success' => false];
            return response()->json( $result, 404);
        }

        return $next($request);
    }

}
