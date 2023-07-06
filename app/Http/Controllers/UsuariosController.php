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

class UsuariosController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM USUARIOS WHERE Estatus = 'A';";
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

            $correo_usuario = $usuario->eMail;
            $nombre_usuario = $usuario->Nombre . " " . $usuario->APaterno;
            $enlace = "http://evalua-pbr.nl.gob.mx/interfaz/RecuperacionCredencial/".$request->id_usuario;
            
            // $remitente = "testeoevaluapbrnl@gmail.com";
            // $passowrd = "jhzgzzrhbpagbqlf";
            // $host = "smtp.gmail.com";
            // $port = 465;
            
            $remitente = "evalua.pbrnl";
            $passowrd = "*Ev4035*";
            $host = "correo.nl.gob.mx";
            $port = 25;

            //Load Composer's autoloader
            require base_path("vendor/autoload.php");

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $host;                                  //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $remitente;                             //SMTP username
            $mail->Password   = $passowrd;                              //SMTP password
            $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
            $mail->Port       = $port;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
        
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->setFrom($remitente, utf8_decode('Evalúa PbR NL'));
            //Recipients
            $mail->addAddress($correo_usuario, $nombre_usuario);       //Add a recipient
            $mail->addBCC('lvilleba@hotmail.com', 'Luis VG');    // CCO
            $mail->Subject = utf8_decode("Bienvenido a Interfaz Evalúa PbR NL");
            $mail->Body    = utf8_decode("<h2>Interfaz Eval&uacute;a PbR NL</h2><br><b>Estimado(a) $nombre_usuario,</b><br><br><br>Bienvenido a Interfaz Eval&uacute;a PbR NL.<br><br>Para ingresar, siga el siguiente enlace que se muestra a continuaci&oacute;n, donde se pedir&aacute; que actualice su contrase&ntilde;a:<br><a href='$enlace'>Actualizar contrase&ntilde;a</a><br><br><b>Saludos cordiales,<br><br>Interfaz Eval&uacute;a PbR NL</b>");
        
            if( !$mail->send() ) {
                return response()->json(array('error' => false, 'result' => "La notificación no ha podido ser enviada, favor de intentarlo de nuevo.", 'code' => 200));
            }
            
            $usuario->Notificado           = "S";
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
            $insert->CambiarPwd         = "N";
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
            

            $delete->Estatus             = "I";
            $delete->save();

        } catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
    
}

?>
