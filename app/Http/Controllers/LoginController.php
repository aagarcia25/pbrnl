<?php

namespace App\Http\Controllers;

use App\Login;
use App\UsuariosEnLinea;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

date_default_timezone_set('America/Monterrey');

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $usuario = Login::select()
                        ->where('idUsuario', '=', $request->id_usuario)
                        ->first();
            
            $Nombre = $usuario->Nombre;
            $ApPaterno = $usuario->APaterno;
            $ApMaterno = $usuario->AMaterno;

            if ($usuario == null) {
                return response()->json(
                    array(
                        'error' => true, 
                        'data' => null, 
                        'message' => "No se encontró el Usuario en Interfaz Evalúa PbR NL. Favor de volver a intentar", 
                        'code' => 200
                    )
                );
            }

            $usuario = DB::table('USUARIOS')
                        ->where('idUsuario', $request->id_usuario)
                        ->where('password', $request->password)
                        ->get();
            
            if (count($usuario) == 0){
                return response()->json(
                    array(
                        'error' => true, 
                        'data' => null, 
                        'message' => "La Contraseña indicada no coincide con los datos del Usuario. Favor de volver a intentar", 
                        'code' => 200
                    )
                );
            }

            $Hora = date('H') - 1;
            $Fecha = date('Y-m-d ') . $Hora . date(':i:s');

            $usuario_activo = DB::table('USUARIOS_LINEA')
                        ->where('idUsuario', $request->id_usuario)
                        ->get();

            if (count($usuario_activo) > 0){
                return response()->json(
                    array(
                        'error' => true, 
                        'data' => null, 
                        'message' => "El Usuario ya ha iniciado sesión en otro dispositivo.", 
                        'code' => 200
                    )
                );
            }

            $insert                 = new UsuariosEnLinea;
            $insert->idUsuario      = $request->id_usuario;
            $insert->FechaLogin     = $Fecha;
            $insert->save();
            

        }catch (Exception $e) {
            return response()->json(
                array(
                    'error' => true , 
                    'message' => $e->getMessage(), 
                    'code' => 500
                )
            );
        }
        
        session(['sesion' => 'activa']);
        session(['id_usuario' => $request->id_usuario]);
        session(['nombre' => $Nombre]);
        session(['ap_paterno' => $ApPaterno]);
        session(['ap_materno' => $ApMaterno]);

        return response()->json(
            array(
                'error' => false, 
                'data' => $usuario, 
                'code' => 200
            )
        );
    }

    public function recover(Request $request)
    {
        try {
            $usuario = Login::select()
                        ->where('idUsuario', '=', $request->id_usuario)
                        ->first();
            
            $Nombre = $usuario->Nombre;
            $ApPaterno = $usuario->APaterno;
            $ApMaterno = $usuario->AMaterno;

            if ($usuario == null) {
                return response()->json(
                    array(
                        'error' => true, 
                        'data' => null, 
                        'message' => "No se encontró el Usuario en Interfaz Evalúa PbR NL. Favor de volver a intentar", 
                        'code' => 200
                    )
                );
            }

            $usuario_activo = DB::table('USUARIOS_LINEA')
                        ->where('idUsuario', $request->id_usuario)
                        ->get();

            if (count($usuario_activo) > 0){
                return response()->json(
                    array(
                        'error' => true, 
                        'data' => null, 
                        'message' => "El usuario que intenta cambiar la contraseña tiene una sesión iniciada en otro dispositivo.", 
                        'code' => 200
                    )
                );
            }

            $usuario->Password    = $request->password;
            $usuario->save();

            $Hora = date('H') - 1;
            $Fecha = date('Y-m-d ') . $Hora . date(':i:s');

            $insert                 = new UsuariosEnLinea;
            $insert->idUsuario      = $request->id_usuario;
            $insert->FechaLogin     = $Fecha;
            $insert->save();

        }catch (Exception $e) {
            return response()->json(
                array(
                    'error' => true , 
                    'message' => $e->getMessage(), 
                    'code' => 500
                )
            );
        }
        
        session(['sesion' => 'activa']);
        session(['id_usuario' => $request->id_usuario]);
        session(['nombre' => $Nombre]);
        session(['ap_paterno' => $ApPaterno]);
        session(['ap_materno' => $ApMaterno]);

        return response()->json(
            array(
                'error' => false, 
                'data' => $usuario, 
                'code' => 200
            )
        );
    }

    public function logout()
    {
        $id_usuario = session('id_usuario');
        
        UsuariosEnLinea::where('idUsuario',$id_usuario)->delete();

        session()->forget('sesion');
        session()->forget('id_usuario');
        session()->forget('tiempo');
        
        return redirect("/");
    }
    
}

?>
