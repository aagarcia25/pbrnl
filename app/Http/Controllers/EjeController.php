<?php

namespace App\Http\Controllers;

use App\Eje;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EjeController extends Controller
{
    public function index()
    {
        $query = "SELECT * FROM EJE WHERE Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function insert(Request $request)
    {
        try {
            $insert                 = new Eje;
            $insert->IdEje          = $request->id_Eje;
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
        $update = Eje::find($request->id_Eje);

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El eje que intenta editar no existe.", 'code' => 404));
        }
        
        try {
            $update->Descripcion    = $request->descripcion;
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {

        $delete = Eje::find($request->id_eje);

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "El eje que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->Activo             = "N";
        $delete->save();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
    
}

?>
