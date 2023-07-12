<?php
namespace App\Http\Controllers;
use Exception;

class BaseController extends Controller {
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
}
?>