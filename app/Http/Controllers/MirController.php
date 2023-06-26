<?php

namespace App\Http\Controllers;

use App\Mir;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MirController extends Controller
{
    public function index(Request $request)
    {

        if ($request->id_secretaria == 0 && $request->id_ua == 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else if ($request->id_secretaria != 0 && $request->id_ua == 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View WHERE idSecretaria = '$request->id_secretaria' ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else if ($request->id_secretaria == 0 && $request->id_ua != 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View WHERE idUA = '$request->id_ua' ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else{

            $query = "SELECT * FROM MIR_CARATULA_View WHERE idSecretaria = '$request->id_secretaria' AND idUA = '$request->id_ua' ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }
    }

    public function caratula(Request $request)
    {
        $info = DB::table('MIR_CARATULA_View')
            ->where('Consecutivo', $request->consecutivo)
            ->where('EjercicioFiscal', $request->ejercicio)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function fin(Request $request)
    {
        $info = DB::table('FIN1')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function proposito(Request $request)
    {
        $info = DB::table('PROPOSITO')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function componentes(Request $request)
    {
        $query = "SELECT * FROM COMPONENTE1 WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function actividades(Request $request)
    {
        $query = "SELECT * FROM ACTIVIDAD WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function auditoriacarga(Request $request)
    {
        $query = "SELECT * FROM LogCargaMIR WHERE Consecutivo = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function auditoriaformulas(Request $request)
    {
        $query = "SELECT * FROM LogFormulasMIR WHERE Consecutivo = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    /*
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
    */
    
}

?>
