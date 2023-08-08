<?php

namespace App\Http\Controllers;

use App\MetaOds;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MetaOdsController extends Controller
{
    public function index(Request $request)
    {
        $query = "SELECT * FROM METAODS WHERE idODS = '$request->id_ods' AND Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function insert(Request $request)
    {
        try {
            $insert                 = new MetaOds;
            $insert->idODS          = $request->id_ods;
            $insert->idMETAODS      = $request->id_metaods;
            $insert->Descripcion    = $request->descripcion;
            $insert->Activo         = "S";
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }

    public function update(Request $request)
    {
        try {
            $update =  DB::table("METAODS")
            ->where('IdODS', '=', $request->id_ods)
            ->where('IdMETAODS', '=', $request->id_metaods)
            ->update(array(
                "IdODS" => $request->id_ods,
                "IdMETAODS" =>$request->id_metaods,
                "Descripcion" => $request->descripcion,
                "Activo" => "S"
            ));
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }
        
        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {
        $delete = MetaOds::where('IdODS', '=', $request->id_ods)->where('IdMETAODS', '=', $request->id_metaods)->first();

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "La meda ODS que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->Activo             = "N";
        $delete->save();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }

}

?>
