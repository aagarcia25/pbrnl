<?php

namespace App\Http\Controllers;

use App\Secretaria;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SecretariaController extends BaseController
{
    public function index()
    {
        $usuario = $this->getUsuarioActual();

        //6-> enlace pbr, 1 administrador
        if($usuario->TipoUsuario == 1)
            $query = "SELECT * FROM SECRETARIAS WHERE Activo = 'S'";
        else
            $query = "SELECT * FROM SECRETARIAS WHERE  Activo = 'S'  AND idSecretaria=$usuario->idSecretaria";

        $secretarias = DB::select($query);
        return response()->json(array('error' => false, 'data' => $secretarias, 'code' => 200));
    }
    /*
    public function save(Request $request)
    {
        $query = "CALL sp_secretarias('".$request->id_secretaria."','".$request->descripcion."','".$request->id_conac."','".$request->accion."');";
        //echo $query;
        $response = DB::select($query);

        return response()->json(array('error' => false, 'data' => $response, 'code' => 200));
    }
    */
    public function insert(Request $request)
    {
        try {
            $secretaria                 = new Secretaria;
            $secretaria->idSecretaria   = $request->id_secretaria;
            $secretaria->Conac          = $request->id_conac;
            $secretaria->Descripcion    = $request->descripcion;
            $secretaria->Activo         = "S";
            $secretaria->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $secretaria , 'code' => 200));
    }

    public function update(Request $request)
    {
        $secretaria = Secretaria::find($request->id_secretaria);

        if (is_null($secretaria)) {
            return response()->json(array('error' => true, 'result' => "La secretaría que intenta editar no existe.", 'code' => 404));
        }

        try {
            $secretaria->Conac          = $request->id_conac;
            $secretaria->Descripcion    = $request->descripcion;
            $secretaria->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $secretaria , 'code' => 200));
    }

    public function delete(Request $request)
    {

        $secretaria = Secretaria::find($request->id_secretaria);

        if (is_null($secretaria)) {
            return response()->json(array('error' => true, 'result' => "La secretaría que intenta eliminar no existe.", 'code' => 404));
        }

        $secretaria->activo             = "N";
        $secretaria->save();

        return response()->json(array('error' => false, 'result' => $secretaria , 'code' => 200));
    }
    
}

?>
