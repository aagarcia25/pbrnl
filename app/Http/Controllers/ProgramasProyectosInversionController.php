<?php

namespace App\Http\Controllers;

use App\ProgramasProyectosInversion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramasProyectosInversionController extends Controller
{
    public function all()
    {
        $query = "SELECT A.* FROM PROGRAMATICO AS A INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria WHERE A.idClasificacion IN ('I' , 'E', 'O') ORDER BY CAST(A.Consecutivo AS SIGNED);";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function countall()
    {
        $query = "SELECT 
            (SELECT COUNT(*) FROM PROGRAMATICO AS A INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria WHERE A.idClasificacion IN ('I' , 'E', 'O') ORDER BY A.Consecutivo) AS 'Programas',
            (SELECT COUNT(*) FROM PROGRAMATICO_PI_COMP AS A INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad AND A.idSecretaria = B.idSecretaria) AS 'Componentes';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function count(Request $request)
    {
        $query = "SELECT 
            (SELECT COUNT(*) FROM PROGRAMATICO AS A INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria WHERE A.idClasificacion IN ('I' , 'E', 'O') AND A.idSecretaria = '$request->id_secretaria' ORDER BY A.Consecutivo) AS 'Programas',
            (SELECT COUNT(*) FROM PROGRAMATICO_PI_COMP AS A INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad AND A.idSecretaria = B.idSecretaria WHERE A.idSecretaria = '$request->id_secretaria') AS 'Componentes';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function index(Request $request)
    {
        $query = "SELECT A.* FROM PROGRAMATICO AS A INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria WHERE A.idClasificacion IN ('I' , 'E', 'O') AND A.idSecretaria = '$request->id_secretaria' ORDER BY CAST(A.Consecutivo AS SIGNED);";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function info(Request $request)
    {
        $query = "SELECT B.idSecretaria, B.Descripcion 'Descripcion_Secretaria', C.Descripcion 'Descripcion_Topologia', A.idClasificacion, A.Anticorrupcion, A.idTipologia, C.Descripcion, A.Consecutivo, A.DescripcionPrograma,
                D.IdObjetivo, D.Descripcion AS 'Descripcion_Objetivo'
                FROM PROGRAMATICO AS A
                INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria
                INNER JOIN TIPOLOGIA AS C ON A.idTipologia = C.IdTipologia
                INNER JOIN OBJETIVO AS D ON A.idObjetivoPED = D.IdObjetivo
                WHERE A.idClasificacion IN ('I' , 'E', 'O') AND A.idSecretaria = '$request->id_secretaria' AND A.idObjetivoPED = '$request->id_objetivo' AND A.idClasificacion = '$request->id_clasificacion' AND A.Consecutivo = '$request->consecutivo';";
        $informacion = DB::select($query);

        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function components(Request $request)
    {
        $query = "SELECT A.idUA, B.Descripcion, A.Componente, A.DescripcionComponente
                FROM PROGRAMATICO_PI_COMP AS A
                INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad AND A.idSecretaria = B.idSecretaria
                WHERE A.idSecretaria = '$request->id_secretaria' AND A.idObjetivoPED = '$request->id_objetivo' AND A.idClasificacion = '$request->id_clasificacion' AND A.Consecutivo = '$request->consecutivo';";
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }

    public function updatecomponent(Request $request)
    {
        
        try {
            $update = DB::table('PROGRAMATICO_PI_COMP')
                ->where('idObjetivoPED', '=', $request->id_objetivo)
                ->where('idSecretaria', '=', $request->id_secretaria)
                ->where('idClasificacion', '=', $request->id_clasificacion)
                ->where('Consecutivo', '=', $request->consecutivo)
                ->where('Componente', '=', $request->componente)
                ->limit(1)
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
        
        try {
            $update = DB::table('PROGRAMATICO')
                ->where('idObjetivoPED', '=', $request->id_objetivo_real)
                ->where('idClasificacion', '=', $request->id_clasificacion_real)
                ->where('Consecutivo', '=', $request->consecutivo_real)
                ->where('Anticorrupcion', '=', $request->id_anticorrupcion_real)
                ->where('idTipologia', '=', $request->id_topologia_real)
                ->where('idSecretaria', '=', $request->id_secretaria_real)
                ->limit(1)
                ->update(
                    array(
                        'idSecretaria' => $request->id_secretaria,
                        'idObjetivoPED' => $request->id_objetivo,
                        'Anticorrupcion' => $request->id_anticorrupcion,
                        'idTipologia' => $request->id_topologia,
                        'DescripcionPrograma' => $request->descripcion
                    )
                );
            
            /*if ($update == 0){
                return response()->json(array('error' => true, 'result' => "No ha sido posible editar el programa presupuestario, favor de intentarlo nuevamente.", 'code' => 404));
            }*/

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update, 'code' => 200));
    }

}
