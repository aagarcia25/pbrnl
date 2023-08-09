<?php

namespace App\Http\Controllers;

use App\Beneficiarios;
use App\TipoBeneficiarios;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BeneficiariosController extends Controller
{
    public function types()
    {
        $query = "SELECT * FROM TIPO_BENEFICIARIO";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function all(Request $request)
    {
        try {
            $query = "SELECT * FROM CAT_BENEFICIARIO;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $informacion , 'code' => 200));
    }
    
    public function index(Request $request)
    {
        try {
            $query = "SELECT * FROM CAT_BENEFICIARIO WHERE idBeneficiario = $request->id_TipoBeneficiario;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $informacion , 'code' => 200));
    }
    
    public function insert(Request $request)
    {
        //obtener el que ya exista

        try {
            $insert                     = new Beneficiarios;
            $insert->idCatBeneficiario  = $request->id_beneficiario;
            $insert->idBeneficiario     = $request->id_tipobeneficiario;
            $insert->Poblacion          = $request->descripcion;
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }
    
    public function update(Request $request)
    {
        $update = Beneficiarios::find($request->id_beneficiario);

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El beneficiario que intenta editar no existe.", 'code' => 404));
        }
        
        try {
            $update->idBeneficiario = $request->id_tipobeneficiario;
            $update->Poblacion      = $request->descripcion;
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function delete(Request $request)
    {
        //return response()->json(array('error' => true, 'result' => "función deshabilitada", 'code' => 500));

        $delete = Beneficiarios::find($request->id_beneficiario);

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "El beneficiario que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->delete();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
    
    public function insert_tipo(Request $request)
    {
        try {
            $insert                     = new TipoBeneficiarios;
            $insert->idBeneficiario     = $request->id_tipobeneficiario;
            $insert->TipoBeneficiario   = $request->descripcion;
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }
    
    public function update_tipo(Request $request)
    {
        $update = TipoBeneficiarios::find($request->id_tipobeneficiario);

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El tipo beneficiario que intenta editar no existe.", 'code' => 404));
        }

        try {
            $update->idBeneficiario     = $request->id_tipobeneficiario;
            $update->TipoBeneficiario   = $request->descripcion;
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }

    public function eliminar_tipo(Request $request)
    {
        $update = TipoBeneficiarios::find($request->id);

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El tipo beneficiario que intenta eliminar no existe.", 'code' => 404));
        }

        try {
            $update->Estatus   = 'E';   //eliminado
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }
    
    public function get_ultimo_tipo_beneficiario() {
        try {
            $query = "SELECT idBeneficiario FROM TIPO_BENEFICIARIO ORDER BY idBeneficiario DESC LIMIT 1,1";
            $ultimo = DB::select($query)[0];
            $nuevo = intval($ultimo->idBeneficiario) + 1;

            if($nuevo >= 99)
                throw new Exception("Ha alcanzado el límite de tipos de beneficiarios");

            if($nuevo < 10)
                $retorno = '0' . $nuevo;
            else
                $retorno = '' . $nuevo;

            return response()->json(array('error' => false, 'data' => $retorno, 'code' => 200));

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }
    }
}

?>
