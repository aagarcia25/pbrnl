<?php

namespace App\Http\Controllers;

use App\Ods;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OdsController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM ODS WHERE Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function insert(Request $request)
    {
        try {
            $insert                     = new Ods;
            $insert->IdODS              = $request->id_ods;
            $insert->DescripcionCorta   = $request->descripcion_corta;
            $insert->DescripcionLarga   = $request->descripcion_larga;
            $insert->Activo             = "S";
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }

    public function update(Request $request)
    {
        $update = Ods::find($request->id_ods);

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El ods que intenta editar no existe.", 'code' => 404));
        }
        
        try {
            $update->DescripcionCorta    = $request->descripcion_corta;
            $update->DescripcionLarga    = $request->descripcion_larga;
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {

        $delete = Ods::find($request->id_ods);

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "El ods que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->Activo             = "N";
        $delete->save();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
}
