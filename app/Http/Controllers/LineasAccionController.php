<?php

namespace App\Http\Controllers;

use App\LineasAccion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LineasAccionController extends Controller
{
    public function all()
    {
        $query = "SELECT * FROM LINEASACCION WHERE Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function index(Request $request)
    {
        $query = "SELECT * FROM LINEASACCION WHERE IdEje = '$request->id_eje' AND IdTema = '$request->id_tema' AND IdObjetivo = '$request->id_objetivo' AND IdEstrategia = '$request->id_estrategia' AND Activo = 'S';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function insert(Request $request)
    {
        try {
            $insert                 = new LineasAccion();
            $insert->IdEje          = $request->id_eje;
            $insert->IdTema         = $request->id_tema;
            $insert->IdObjetivo     = $request->id_objetivo;
            $insert->IdEstrategia   = $request->id_estrategia;
            $insert->IdLineaAccion  = $request->id_lineaccion;
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
        // $update = LineasAccion::
        //         where('IdEje', '=', $request->id_eje)
        //         ->where('IdTema', '=', $request->id_tema)
        //         ->where('IdObjetivo', '=', $request->id_objetivo)
        //         ->where("IdEstrategia", '=', $request->id_estrategia)
        //         ->where('IdLineaAccion', '=', $request->id_lineaccion)
        //         ->first();

        // if (is_null($update)) {
        //     return response()->json(array('error' => true, 'result' => "El objetivo que intenta editar no existe.", 'code' => 404));
        // }
        
        try {
            // $update->Descripcion    = $request->descripcion;
            // $update->Activo         = "S";

            $update = DB::table("LINEASACCION")
                ->where('IdEje', '=', $request->id_eje)
                ->where('IdTema', '=', $request->id_tema)
                ->where('IdObjetivo', '=', $request->id_objetivo)
                ->where('IdEstrategia', '=', $request->id_estrategia)
                ->where('IdLineaAccion', '=', $request->id_lineaccion)
                ->update(array(
                    'Descripcion' => $request->descripcion,
                    'Activo' => 'S'
                ));

            //$update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }
        
        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {
        $delete = LineasAccion::
                where('IdEje', '=', $request->id_eje)
                ->where('IdTema', '=', $request->id_tema)
                ->where('IdObjetivo', '=', $request->id_objetivo)
                ->where('IdEstrategia', '=', $request->id_estrategia)
                ->where('IdLineaAccion', '=', $request->id_lineaccion)
                ->first();

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "El objetivo que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->Activo             = "N";
        $delete->save();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
}

?>
