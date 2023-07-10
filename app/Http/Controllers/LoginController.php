<?php

namespace App\Http\Controllers;

use App\Login;
use App\UsuariosEnLinea;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DateTime;
use App\Helpers;

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

    public function solicitar_recuperacion(Request $request) {
        try {
            $usuario = Login::select()
                        ->where('idUsuario', '=', $request->id_usuario)
                        ->first();
            $nombre_usuario = $usuario->Nombre . " " . $usuario->APaterno . " " . $usuario->AMaterno;

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

            $usuario->TokenRecuperacion    = $token = bin2hex(random_bytes(32));;
            $usuario->save();

            $enlace = "http://evalua-pbr.nl.gob.mx/interfaz/RecuperacionCredencial/" . $token;
            $mensaje = "<h2>Interfaz Eval&uacute;a PbR NL</h2><br>
            <b>Estimado $nombre_usuario</b><br>
            ID de usuario: <strong>$usuario->idUsuario</strong><br>
            <br>
            Se ha solicitado la recuperación de su contraseña<br>
            <br>
            Para recuperarla, siga el siguiente enlace que se 
            muestra a continuaci&oacute;n, donde se pedir&aacute; que genere su nueva contrase&ntilde;a:<br>
            <a href='$enlace'>Recuperar contrase&ntilde;a</a><br>
            <br>
            <b>Saludos cordiales,<br>
            <br>
            Interfaz Eval&uacute;a PbR NL<br>
            Secretaría de Finanzas y Tesorería General del Estado</b>";

            $result = Helpers::EnviarCorreo($usuario->eMail, "Recuperación de contraseña", $mensaje);
            if($result)
            {
                return response()->json(
                    array(
                        'error' => false , 
                        'message' => "Correo enviado", 
                        'code' => 200
                    )
                );
            }
            else {
                return response()->json(
                    array(
                        'error' => true , 
                        'message' => "Error al enviar el correo electrónico", 
                        'code' => 500
                    )
                );
            }

        }catch (Exception $e) {
            return response()->json(
                array(
                    'error' => true , 
                    'message' => $e->getMessage(), 
                    'code' => 500
                )
            );
        }
    }

//  CÓDIGO ORIGINAL
     public function recover(Request $request)
    {
        try {
            $usuario = Login::select()
                        ->where('TokenRecuperacion', '=', $request->id_usuario)
                        ->first();

            if ($usuario == null) {
                return response()->json(
                    array(
                        'error' => true, 
                        'data' => null, 
                        'message' => "No se encontró el Usuario en Interfaz Evalúa PbR NL. Favor de volver a intentar", 
                        'code' => 500
                    )
                );
            }

            $usuario->Password    = $request->password;
            $usuario->TokenRecuperacion    = null;
            $usuario->save();
        }catch (Exception $e) {
            return response()->json(
                array(
                    'error' => true , 
                    'message' => $e->getMessage(), 
                    'code' => 500
                )
            );
        }

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
