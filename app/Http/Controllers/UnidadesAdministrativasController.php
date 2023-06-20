<?php

namespace App\Http\Controllers;

use App\UnidadesAdministrativas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UnidadesAdministrativasController extends Controller
{
    public function all()
    {
        $query = "SELECT * FROM UNIDADES WHERE Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function index(Request $request)
    {
        $query = "SELECT * FROM UNIDADES WHERE idSecretaria = '$request->id_Secretaria' AND Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function insert(Request $request)
    {
        try {
            $insert                 = new UnidadesAdministrativas;
            $insert->idSecretaria   = $request->id_secretaria;
            $insert->idUnidad       = $request->id_unidad;
            $insert->Descripcion    = $request->descripcion;
            $insert->idConacFun     = $request->id_conacfuncional;
            $insert->Activo         = "S";
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }

    public function update(Request $request)
    {
        $update = UnidadesAdministrativas::where('idSecretaria', '=', $request->id_secretaria)->where('idUnidad', '=', $request->id_unidad)->first();

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "La unidad administrativa que intenta editar no existe.", 'code' => 404));
        }
        
        try {
            $update->idSecretaria   = $request->id_secretaria;
            $update->idUnidad       = $request->id_unidad;
            $update->Descripcion    = $request->descripcion;
            $update->idConacFun     = $request->id_conacfuncional;
            $update->Activo         = "S";
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }
        

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {
        $delete = UnidadesAdministrativas::where('idSecretaria', '=', $request->id_secretaria)->where('idUnidad', '=', $request->id_unidad)->first();

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "La unidad administrativa que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->activo             = "N";
        $delete->save();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }

}

?>
