<?php

namespace App\Http\Controllers;

use App\ActividadesInstitucionales;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadesInstitucionalesController extends BaseController
{
    public function all(Request $request)
    {
        $query = "SELECT A.* FROM 
            PROGRAMATICO AS A 
            INNER JOIN SECRETARIAS AS B 
            ON A.idSecretaria = B.idSecretaria 
            WHERE A.idClasificacion IN ('AI') AND A.ejercicioFiscal = $request->ejercicio_fiscal
            ORDER BY A.Consecutivo;";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function countall(Request $request)
    {
        $query = "SELECT 
            (SELECT COUNT(*) FROM PROGRAMATICO AS A 
                INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
                WHERE A.idClasificacion IN ('AI') AND A.ejercicioFiscal = $request->ejercicio_fiscal
                ORDER BY A.Consecutivo) AS 'Programas',
            (SELECT COUNT(*) FROM PROGRAMATICO_AI_COMP AS A 
                INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad AND A.idSecretaria = B.idSecretaria
                WHERE A.ejercicioFiscal = $request->ejercicio_fiscal
                ) AS 'Componentes';";
        // $informacion = DB::select($query);
        // return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        return $this->executeQuery($query);
    }

    public function count(Request $request)
    {
        $query = "SELECT 
            (SELECT COUNT(*) FROM PROGRAMATICO AS A 
                INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
                WHERE A.idClasificacion IN ('AI') 
                    AND A.idSecretaria = '$request->id_secretaria' 
                    AND A.ejercicioFiscal = $request->ejercicio_fiscal
                    ORDER BY A.Consecutivo) AS 'Programas',
            (SELECT COUNT(*) FROM PROGRAMATICO_AI_COMP AS A 
                INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad 
                AND A.idSecretaria = B.idSecretaria 
                WHERE A.idSecretaria = '$request->id_secretaria'
                AND A.ejercicioFiscal = $request->ejercicio_fiscal
                ) AS 'Componentes';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function index(Request $request)
    {
        $query = "SELECT A.* FROM PROGRAMATICO AS A 
            INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
            WHERE A.idClasificacion IN ('AI') AND A.idSecretaria = '$request->id_secretaria' 
            AND A.ejercicioFiscal = $request->ejercicio_fiscal
            ORDER BY A.Consecutivo;";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function info(Request $request)
    {
        $query = "SELECT 
                    B.idSecretaria, 
                    B.Descripcion 'Descripcion_Secretaria', 
                    C.Descripcion 'Descripcion_Topologia', 
                    A.idClasificacion, 
                    A.Anticorrupcion, 
                    A.idTipologia, 
                    C.Descripcion, 
                    A.Consecutivo, 
                    A.DescripcionPrograma,
                    D.IdObjetivo, 
                    D.Descripcion AS 'Descripcion_Objetivo',
                    A.idUA,
                    U.Descripcion as 'Descripcion_UA'
                FROM PROGRAMATICO AS A
                INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria
                INNER JOIN TIPOLOGIA AS C ON A.idTipologia = C.IdTipologia
                INNER JOIN OBJETIVO AS D ON A.idObjetivoPED = D.IdObjetivo
                INNER JOIN UNIDADES AS U ON A.idUA = U.idUnidad AND A.idSecretaria = U.idSecretaria
                WHERE 
                    -- A.idClasificacion IN ('AI') 
                    -- AND A.idSecretaria = '$request->id_secretaria' 
                    -- AND A.idObjetivoPED = '$request->id_objetivo' 
                    -- AND A.idClasificacion = '$request->id_clasificacion' 
                    -- AND A.Consecutivo = '$request->consecutivo' 
                    -- AND A.ejercicioFiscal = $request->ejercicio_fiscal
                    A.Id = $request->id
                    ORDER BY A.Consecutivo;";
        $informacion = DB::select($query);

        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function components(Request $request)
    {

        $id = $request->id;
        $query = "SELECT A.Id, A.idUA, B.Descripcion, A.Componente, A.DescripcionComponente
                FROM PROGRAMATICO_AI_COMP AS A
                left join PROGRAMATICO p on p.Id = A.ProgramaticoId 
                left JOIN UNIDADES AS B ON A.idUA = B.idUnidad 
                    and B.idSecretaria = p.idSecretaria 
                WHERE A.ProgramaticoId = $request->id";

        $informacion = DB::select($query);

        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function updatecomponent(Request $request)
    {
        if(!$this->validarEjercicioFiscal($request->ejercicio_fiscal))
        {
            return response()->json(array('error' => true , 'result' => "El ejercicio que está intentando modificar está cerrado", 'code' => 500));
        }
        try {
            $update = DB::table('PROGRAMATICO_AI_COMP')
                ->where('Id', '=', $request->id)
                ->update(
                    array(
                        'DescripcionComponente' => $request->descripcion_componente,
                        'idUA' => $request->unidad_componente
                    )
                );

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update, 'code' => 200));
    }

    public function updatepp(Request $request)
    {
        if(!$this->validarEjercicioFiscal($request->ejercicio_fiscal))
        {
            return response()->json(array('error' => true , 'result' => "El ejercicio que está intentando modificar está cerrado", 'code' => 500));
        }
        try {
            $update = DB::table('PROGRAMATICO')
                // ->where('idObjetivoPED', '=', $request->id_objetivo_real)
                // ->where('idClasificacion', '=', $request->id_clasificacion_real)
                // ->where('Consecutivo', '=', $request->consecutivo_real)
                // ->where('Anticorrupcion', '=', $request->id_anticorrupcion_real)
                // ->where('idTipologia', '=', $request->id_topologia_real)
                // ->where('idSecretaria', '=', $request->id_secretaria_real)
                // ->where('ejercicioFiscal', '=', $request->ejercicio_fiscal)
                // ->limit(1)
                ->where('Id', '=', $request->id)
                ->update(
                    array(
                        'idSecretaria' => $request->id_secretaria,
                        'idObjetivoPED' => $request->id_objetivo,
                        'Anticorrupcion' => $request->id_anticorrupcion,
                        'idTipologia' => $request->id_topologia,
                        'DescripcionPrograma' => $request->descripcion,
                        'idUA' => $request->id_ua
                    )
                );
            

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update, 'code' => 200));
    }

}
