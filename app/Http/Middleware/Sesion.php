<?php

namespace App\Http\Middleware;

use App\UsuariosEnLinea;
use Closure;

/**
 * 29/06/2023: Omar -> middleware para mover la fecha y hora de la 
 * ultima actividad del usuario en la tabla de sesiones abiertas 
 * para evitar el bloqueo del inicio de sesión
 */
class Sesion
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
        date_default_timezone_set('America/Monterrey');
        $id = session()->get("id_usuario");
        if(strlen($id) > 0) {
            //leemos el usuario y le actualizamos la hora de la sesión
            $usr = UsuariosEnLinea::find($id);
            if($usr == null)
                return $next($request);

            $usr->FechaLogin = date("Y-m-d H:i:s");
            $usr->save();
        }
        return $next($request);
    }
}

?>