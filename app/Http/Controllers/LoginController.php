<?php

namespace App\Http\Controllers;

use App\Login;
use App\UsuariosEnLinea;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;

date_default_timezone_set('America/Monterrey');

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $usuario = Login::select()
                        ->where('idUsuario', '=', $request->id_usuario)
                        // solo los activos pueden iniciar sesión
                        ->where('Estatus','=','A')
                        ->first();

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

            $Nombre = $usuario->Nombre;
            $ApPaterno = $usuario->APaterno;
            $ApMaterno = $usuario->AMaterno;
            $AdminMIR = $usuario->AdminMIR;
            $AdminEvalua = $usuario->AdminEvalua;
            $TipoUsuario = $usuario->TipoUsuario;
            $CatalogosPbR = $usuario->CatalogosPbR;
            $ClasProgramatica = $usuario->ClasProgramatica;

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

            if($this->validar_sesion_expirada($request->id_usuario)) {
                //eliminar el registro para posteriormente agregar uno nuevo
                UsuariosEnLinea::where('idUsuario',$request->id_usuario)->delete();
            }
            else {
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
        
        session(['tipo_usuario' => $TipoUsuario]);
        session(['admin_evalua' => $AdminEvalua]);
        session(['catalogos_pbr' => $CatalogosPbR]); 
        session(['programatica' => $ClasProgramatica]);
        session(['admin_mir' => $AdminMIR]);

        session()->put("usuario", $request->id_usuario);

        return response()->json(
            array(
                'error' => false, 
                'data' => $usuario, 
                'code' => 200
            )
        );
    }

//  CÓDIGO ORIGINAL
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

            if($this->validar_sesion_expirada($request->id_usuario)) {
                //eliminar el registro para posteriormente agregar uno nuevo
                UsuariosEnLinea::where('idUsuario',$request->id_usuario)->delete();
            }
            else {
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
        session(['tipo_usuario' => $usuario->TipoUsuario]);
        session(['admin_evalua' => $usuario->AdminEvalua]);
        session(['catalogos_pbr' => $usuario->CatalogosPbR]);
        session(['programatica' => $usuario->ClasProgramatica]);
        session(['admin_mir' => $usuario->AdminMIR]);

        return response()->json(
            array(
                'error' => false, 
                'data' => $usuario, 
                'code' => 200
            )
        );
    }


    private function validar_sesion_expirada($id_usuario) {
        $usuario_activo = DB::table('USUARIOS_LINEA')
                        ->where('idUsuario', $id_usuario)
                        ->get();

        if (count($usuario_activo) > 0){
            $usuario = $usuario_activo[0];

            $fecha_login = new DateTime($usuario->FechaLogin);
            $hoy = new DateTime();
            $diferencia = $hoy->diff($fecha_login);

            $dif = 
                ($diferencia->days * 1440) + 
                ($diferencia->h) * 60 + 
                $diferencia->i;

            $max_minutos = 10;

            if($dif < $max_minutos){
                return false;
            }
            else{
                
                return true;
            }
        }
        return true;
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
