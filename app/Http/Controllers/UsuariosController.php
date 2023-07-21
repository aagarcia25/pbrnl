<?php

namespace App\Http\Controllers;

use App\Usuarios;
use App\UsuariosEnLinea;
use Exception as GlobalException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers;

class UsuariosController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM USUARIOS WHERE Estatus <> 'E';";    //E es para eliminados
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function close(Request $request)
    {
        $usuario = Usuarios::select()
            ->where('idUsuario', '=', $request->id_usuario)
            ->first();

        if ($usuario == null) {
            return response()->json(
                array(
                    'error' => true, 
                    'data' => null, 
                    'message' => "No se encontró el usuario seleccionado. Favor de volver a intentar", 
                    'code' => 200
                )
            );
        }

        $usuarioenlinea = UsuariosEnLinea::select()
            ->where('idUsuario', '=', $request->id_usuario)
            ->first();

        if ($usuarioenlinea == null) {
            return response()->json(
                array(
                    'error' => true, 
                    'data' => null, 
                    'message' => "El usuario no cuenta con una sesión activa. Favor de volver a intentar", 
                    'code' => 200
                )
            );
        }
        
        UsuariosEnLinea::where('idUsuario', $request->id_usuario)->delete();
        
        return response()->json(array('error' => false, 'data' => $usuario, 'code' => 200));
    }

    public function validar_id(Request $request) {
        $id = $request->id;

        $usuarios = DB::table("USUARIOS")
        ->where('idUsuario', '=', $id)
        ->get();

        $encontrados = count($usuarios);
        if($encontrados == 0)
        {
            return response()->json(array(
                'error' => false, 
                'data' => $id, 
                'message' => "", 
                'code' => 200
            ));
        }
        else{
            return response()->json(array(
                'error' => false, 
                'data' => $id . ($encontrados + 1),
                'message' => "", 
                'code' => 200
            ));
        }
    }

    public function notif(Request $request)
    {
        try {
            $usuario = Usuarios::select()
                ->where('idUsuario', '=', $request->id_usuario)
                ->first();

            if (is_null($usuario)) {
                return response()->json(
                    array(
                        'error' => true, 
                        'data' => null, 
                        'message' => "No se encontró el usuario seleccionado para notificar. Favor de volver a intentar", 
                        'code' => 200
                    )
                );
            }

            $token = bin2hex(random_bytes(32));

            $correo_usuario = $usuario->eMail;
            $nombre_usuario = $usuario->Nombre . " " . $usuario->APaterno . " " . $usuario->AMaterno;
            $enlace = "http://evalua-pbr.nl.gob.mx/interfaz/RecuperacionCredencial/" . $token;
            $mensaje = "<h2>Interfaz Eval&uacute;a PbR NL</h2><br>
            <b>Estimado(a) $nombre_usuario</b><br>
            ID de usuario: <strong>$usuario->idUsuario</strong><br>
            <br>
            Bienvenido(a) a la Interfaz Eval&uacute;a PbR NL.<br>
            <br>
            Para ingresar, siga el siguiente enlace que se 
            muestra a continuaci&oacute;n, donde se pedir&aacute; que genere su contrase&ntilde;a:<br>
            <a href='$enlace'>Generar contrase&ntilde;a</a><br>
            <br>
            <b>Saludos cordiales,<br>
            <br>
            Interfaz Eval&uacute;a PbR NL<br>
            Secretaría de Finanzas y Tesorería General del Estado</b>";

            //Load Composer's autoloader
            require base_path("vendor/autoload.php");

            $result = Helpers::EnviarCorreo($usuario->eMail, "Bienvenido a la Interfaz Evalúa PbR NL", $mensaje);

            if( !$result ) {
                return response()->json(array('error' => false, 'result' => "La notificación no ha podido ser enviada, favor de intentarlo de nuevo.", 'code' => 200));
            }

            $usuario->Notificado           = "S";
            $usuario->TokenRecuperacion = $token;
            $usuario->save();

        } catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => "La notificación ha sido enviada correctamente.", 'code' => 200));
    }

    public function insert(Request $request)
    {
        try {
            $usuario = Usuarios::select()
                ->where('idUsuario', '=', $request->id_usuario)
                ->first();

            if ($usuario != null) {
                return response()->json(
                    array(
                        'error' => true,
                        'result' => "El id de usuario seleccionado ya existe. Favor de volver a intentar", 
                        'code' => 200
                    )
                );
            }
            
            $insert                     = new Usuarios;
            $insert->idUsuario          = $request->id_usuario;
            $insert->Nombre             = $request->nombre_usuario;
            $insert->APaterno           = $request->appaterno_usuario;
            $insert->AMaterno           = $request->apmaterno_usuario;
            $insert->RFC                = $request->rfc_usuario;
            $insert->eMail              = $request->correo_usuario;
            $insert->TelefonoOficina    = $request->telefono_usuario;
            $insert->TelefonoParticular = $request->movil_usuario;
            $insert->idSecretaria       = $request->secretaria_usuario;
            $insert->idUnidad           = $request->ua_usuario;
            $insert->Puesto             = $request->puesto_usuario;
            $insert->Estatus            = $request->check_Activo;
            $insert->TipoUsuario        = $request->select_roles;

            if($insert->TipoUsuario == "1") {
                $insert->AdminEvalua = true;
            }
            else {
                $insert->AdminEvalua = false;
            }

            $insert->FechaNacimiento    = $request->fechanacimiento_usuario;
            $insert->CatalogosPbR       = $request->check_CatalogoPbR;
            $insert->ClasProgramatica   = $request->check_Clasificacion;
            $insert->AdminMIR           = $request->check_Mir;
            $insert->CambiarPwd         = "S";
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }

    public function update(Request $request)
    {
        
        try {

            $update = Usuarios::select()
                    ->where('idUsuario', '=', $request->id_usuario)
                    ->first();

            if (is_null($update)) {
                return response()->json(
                    array(
                        'error' => true,
                        'result' => "El usuario que intenta editar no existe. Favor de volver a intentar", 
                        'code' => 200
                    )
                );
            }

            $update->idUsuario          = $request->id_usuario;
            $update->Nombre             = $request->nombre_usuario;
            $update->APaterno           = $request->appaterno_usuario;
            $update->AMaterno           = $request->apmaterno_usuario;
            $update->RFC                = $request->rfc_usuario;
            $update->eMail              = $request->correo_usuario;
            $update->TelefonoOficina    = $request->telefono_usuario;
            $update->TelefonoParticular = $request->movil_usuario;
            $update->idSecretaria       = $request->secretaria_usuario;
            $update->idUnidad           = $request->ua_usuario;
            $update->Puesto             = $request->puesto_usuario;
            $update->Estatus            = $request->check_Activo;
            $update->TipoUsuario        = $request->select_roles;
            if($update->TipoUsuario == "1") {
                $update->AdminEvalua = true;
            }
            else {
                $update->AdminEvalua = false;
            }
            $update->FechaNacimiento    = $request->fechanacimiento_usuario;
            $update->CatalogosPbR       = $request->check_CatalogoPbR;
            $update->ClasProgramatica   = $request->check_Clasificacion;
            $update->AdminMIR           = $request->check_Mir;
            $update->save();
            
        } catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {

        try { 
            
            $delete = Usuarios::select()
                    ->where('idUsuario', '=', $request->id_usuario)
                    ->first();

            if (is_null($delete)) {
                return response()->json(
                    array(
                        'error' => true,
                        'result' => "El usuario que intenta dar de baja no existe. Favor de volver a intentar", 
                        'code' => 200
                    )
                );
            }

            // 08/07/2023: Se le pone estatus E para marcar que está eliminado
            $delete->Estatus             = "E";
            $delete->save();

        } catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
    
}

?>
