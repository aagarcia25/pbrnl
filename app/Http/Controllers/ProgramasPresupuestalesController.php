<?php

namespace App\Http\Controllers;

use App\ProgramasPresupuestalesComponentes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramasPresupuestalesController extends BaseController
{
    public function all(Request $request)
    {
        $ef = $request->ejercicio_fiscal;
        $query = "SELECT A.* FROM 
            PROGRAMATICO AS A 
            INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
            WHERE A.idClasificacion IN ('PP') 
            AND A.ejercicioFiscal=$ef 
            ORDER BY A.Consecutivo";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function countall(Request $request)
    {
        return $this->count($request);
    }

    public function count(Request $request)
    {
        $usuario = $this->getUsuarioActual();
        if($usuario->TipoUsuario == 1) {
            //es un administrador
            $idSecretaria = $request->id_secretaria;
            $idUA = $request->id_unidad;
        }
        else{
            $idSecretaria = $usuario->idSecretaria;
            $idUA = $usuario->idUnidad;
        }
        $ejercicio_fiscal = $request->ejercicio_fiscal;

        $query = "SELECT 
            (SELECT COUNT(*) 
                FROM PROGRAMATICO AS A 
                INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
                WHERE A.idClasificacion IN ('PP') 
                    and A.ejercicioFiscal = $ejercicio_fiscal
                    AND case when '$idSecretaria' <> '' then A.idSecretaria = '$idSecretaria'  else 1 = 1 end
                    AND case when '$idUA' <> '' then A.idUA = '$idUA'  else 1 = 1 end
                ORDER BY A.Consecutivo) AS 'Programas',
            (SELECT COUNT(*) FROM PROGRAMATICO_COMP AS A 
                INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad 
                    AND A.idSecretaria = B.idSecretaria
                WHERE 
                A.ejercicioFiscal = $ejercicio_fiscal
                AND case when '$idSecretaria' <> '' then A.idSecretaria = '$idSecretaria'  else 1 = 1 end
                AND case when '$idUA' <> '' then A.idUA = '$idUA'  else 1 = 1 end
                ) 
                AS Componentes";

        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function index(Request $request)
    {
        $query = "SELECT A.* 
            FROM PROGRAMATICO AS A 
            INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
            WHERE A.idClasificacion IN ('PP') 
                AND A.idSecretaria = '$request->id_secretaria' 
                AND A.ejercicioFiscal = $request->ejercicio_fiscal ";

        $ua = $request->id_ua;
        if(isset($ua) && $ua != "" && $ua != "0")
            $query .= "AND A.idUA = $ua";

        $query.=" ORDER BY A.Consecutivo";
                
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
                LEFT JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria
                LEFT JOIN TIPOLOGIA AS C ON A.idTipologia = C.IdTipologia
                LEFT JOIN OBJETIVO AS D ON A.idObjetivoPED = D.IdObjetivo
                LEFT JOIN UNIDADES AS U ON A.idUA = U.idUnidad AND A.idSecretaria = U.idSecretaria
                WHERE 
                    A.Id = $request->id
                    ORDER BY A.Consecutivo;";
        $informacion = DB::select($query);

        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function components(Request $request)
    {
        $id = $request->id;

        $query = "SELECT A.Id, A.idUA, B.Descripcion, A.Componente, A.DescripcionComponente
                FROM PROGRAMATICO_COMP AS A
                INNER JOIN UNIDADES AS B 
                    ON A.idUA = B.idUnidad 
                    AND A.idSecretaria = B.idSecretaria
                WHERE A.ProgramaticoId = $id
                    ;";

        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function updatecomponent(Request $request) {
        if(!$this->validarEjercicioFiscal($request->ejercicio_fiscal))
        {
            return response()->json(array('error' => true , 'result' => "El ejercicio que está intentando modificar está cerrado", 'code' => 500));
        }

        try {
            $update = DB::table('PROGRAMATICO_COMP')
                ->where('Id', '=', $request->id)
                ->update(
                    array(
                        'DescripcionComponente' => $request->descripcion_componente,
                        'idUA' => $request->unidad_componente,
                        'idSecretaria' => $request->id_secretaria
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
