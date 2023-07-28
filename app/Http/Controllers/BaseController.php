<?php
namespace App\Http\Controllers;
use Exception;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller {
    
    public function validarEjercicioFiscal($e) {
        $ejercicio = DB::table("EJERCICIOS_FISCALES")
            ->where("Id","=",$e)
            ->first();

        if($ejercicio->Estatus != "A")
        {
            return false;
        }

        return true;
    }

    public function guardarCambios($entidad) {
        try {
            $entidad->save();
        }
        catch (Exception $e) {
            $mensaje = "";
            if($e->getCode() == 23000)
                $mensaje = "La clave (Id) que está intentando introducir ya está registrada y no se puede duplicar";
            else
                $mensaje = $e->getMessage();

            return response()->json(array('error' => true , 'result' => $mensaje, 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $entidad , 'code' => 200));
    }

    public function executeQuery($query) {
        try{
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
        }
        catch(Exception $e) {
            return response()->json(array('error' => true, 'result' => $e->getMessage(), 'code' => 200));
        }
    }
}
?>