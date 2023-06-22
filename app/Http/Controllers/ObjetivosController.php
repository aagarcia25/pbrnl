<?php

namespace App\Http\Controllers;

use App\Objetivos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObjetivosController extends Controller
{
    public function all()
    {
        $query = "SELECT * FROM OBJETIVO WHERE Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function index(Request $request)
    {
        $query = "SELECT * FROM OBJETIVO WHERE IdEje = '$request->id_eje' AND IdTema = '$request->id_tema' AND Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function insert(Request $request)
    {
        try {
            $insert                 = new Objetivos;
            $insert->IdEje          = $request->id_eje;
            $insert->IdTema         = $request->id_tema;
            $insert->IdObjetivo     = $request->id_objetivo;
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
        $update = Objetivos::
                where('IdEje', '=', $request->id_eje)
                ->where('IdTema', '=', $request->id_tema)
                ->where('IdObjetivo', '=', $request->id_objetivo)
                ->first();
        
        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El objetivo que intenta editar no existe.", 'code' => 404));
        }
        
        try {
            $update->Descripcion    = $request->descripcion;
            $update->Activo         = "S";
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }
        
        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {
        $delete = Objetivos::
                where('IdEje', '=', $request->id_eje)
                ->where('IdTema', '=', $request->id_tema)
                ->where('IdObjetivo', '=', $request->id_objetivo)
                ->first();

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "El objetivo que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->Activo             = "N";
        $delete->save();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
}
