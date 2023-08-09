<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\EjerciciosFiscales;
use App\ProgramasPresupuestales;
use App\ProgramasPresupuestalesComponentes;
use App\ActividadesInstitucionales;
use App\ProgramasProyectosInversion;


class EjerciciosFiscalesController extends BaseController
{
    public function lista()
    {
        $query = "SELECT 
        EF.Id,
        EF.Comentarios,
        EF.Estatus,
        PPI_P.PPI_P,
        PPI_C.PPI_C,
        PP.PP,
        PP_C.PP_C,
        AI.AI,
        AI_C.AI_C
    FROM
        EJERCICIOS_FISCALES EF INNER JOIN
        -- programas y proyectos
        (SELECT A.ejercicioFiscal, COUNT(*) AS PPI_P FROM PROGRAMATICO AS A 
        INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
        WHERE A.idClasificacion IN ('I' , 'E', 'O') 
        GROUP BY A.ejercicioFiscal) PPI_P ON EF.Id = PPI_P.ejercicioFiscal
        INNER JOIN
        (SELECT A.ejercicioFiscal, COUNT(*) AS PPI_C FROM PROGRAMATICO_PI_COMP AS A 
        INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad AND A.idSecretaria = B.idSecretaria
        GROUP BY A.ejercicioFiscal
        ) PPI_C  ON PPI_C.ejercicioFiscal = EF.Id
        -- programas presupuestarios
        INNER JOIN
        (SELECT A.ejercicioFiscal, COUNT(*) AS PP
                FROM PROGRAMATICO AS A 
                INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
                WHERE A.idClasificacion IN ('PP')
                GROUP BY A.ejercicioFiscal) PP ON EF.Id = PP.ejercicioFiscal
         INNER JOIN
        (SELECT A.ejercicioFiscal, COUNT(*) AS PP_C 
                FROM PROGRAMATICO_COMP AS A 
                INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad 
                    AND A.idSecretaria = B.idSecretaria
                GROUP BY A.ejercicioFiscal) PP_C ON EF.Id = PP_C.ejercicioFiscal
    -- actividades especificas
        INNER JOIN
        (SELECT A.ejercicioFiscal, COUNT(*) AS AI FROM PROGRAMATICO AS A 
        INNER JOIN SECRETARIAS AS B ON A.idSecretaria = B.idSecretaria 
        WHERE A.idClasificacion IN ('AI')
        GROUP BY A.ejercicioFiscal) AI ON EF.Id = AI.ejercicioFiscal
        INNER JOIN
        (SELECT A.ejercicioFiscal, COUNT(*) AS AI_C FROM PROGRAMATICO_AI_COMP AS A 
        INNER JOIN UNIDADES AS B ON A.idUA = B.idUnidad AND A.idSecretaria = B.idSecretaria
        GROUP BY A.ejercicioFiscal) AI_C ON EF.Id = AI_C.ejercicioFiscal
    ORDER BY EF.Id desc";
        
        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
    
    public function guardar(Request $request) {
        $nuevo_ef = $request->ejercicio_fiscal;
        $anterior_ef = $nuevo_ef - 1;

        //obtener los programas del ejercicio anterior
        $programatico = DB::select("SELECT * FROM PROGRAMATICO where ejercicioFiscal=$anterior_ef");
        $programatico_comp = DB::select("SELECT * FROM PROGRAMATICO_COMP where ejercicioFiscal=$anterior_ef");
        $PROGRAMATICO_AI_COMP = DB::select("SELECT * FROM PROGRAMATICO_AI_COMP where ejercicioFiscal=$anterior_ef");
        $PROGRAMATICO_PI_COMP = DB::select("SELECT * FROM PROGRAMATICO_PI_COMP where ejercicioFiscal=$anterior_ef");

        //copiar programaticos
        foreach ($programatico as $key => $d) {
            $programa = new ProgramasPresupuestales();
            
            $programa->idObjetivoPED = $d->idObjetivoPED;
            $programa->idClasificacion = $d->idClasificacion;
            $programa->Consecutivo = $d->Consecutivo;
            $programa->Anticorrupcion = $d->Anticorrupcion;
            $programa->idTipologia = $d->idTipologia;
            $programa->DescripcionPrograma = $d->DescripcionPrograma . ' ' . $nuevo_ef;
            $programa->idSecretaria = $d->idSecretaria;
            $programa->idUA = $d->idUA;
            $programa->ejercicioFiscal = $nuevo_ef;

            $programa->save();
        }

        //copiar componentes
        foreach ($programatico_comp as $key => $d) {
            $reg = new ProgramasPresupuestalesComponentes();
            
            $reg->idObjetivoPED = $d->idObjetivoPED;
            $reg->idClasificacion = $d->idClasificacion;
            $reg->Consecutivo = $d->Consecutivo;
            $reg->Componente = $d->Componente;
            $reg->idSecretaria = $d->idSecretaria;
            $reg->idUA = $d->idUA;
            $reg->DescripcionComponente = $d->DescripcionComponente . ' ' . $nuevo_ef;
            $reg->Observaciones = $d->Observaciones;
            $reg->ConacF = $d->ConacF;
            $reg->ejercicioFiscal = $nuevo_ef;

            $reg->save();
        }

        //copiar ais
        foreach ($PROGRAMATICO_AI_COMP as $key => $d) {
            $reg = new ActividadesInstitucionales();
            
            $reg->idObjetivoPED = $d->idObjetivoPED;
            $reg->idClasificacion = $d->idClasificacion;
            $reg->Consecutivo = $d->Consecutivo;
            $reg->Componente = $d->Componente;
            $reg->ClaveFuncional = $d->ClaveFuncional;
            $reg->DescripcionComponente = $d->DescripcionComponente . ' ' . $nuevo_ef;
            $reg->idSecretaria = $d->idSecretaria;
            $reg->idUA = $d->idUA;
            $reg->Observaciones = $d->Observaciones;
            $reg->ejercicioFiscal = $nuevo_ef;

            $reg->save();
        }

        //copiar proyectos de inversion
        foreach ($PROGRAMATICO_PI_COMP as $key => $d) {
            $reg = new ProgramasProyectosInversion();
            
            $reg->idObjetivoPED = $d->idObjetivoPED;
            $reg->idClasificacion = $d->idClasificacion;
            $reg->Consecutivo = $d->Consecutivo;
            $reg->Componente = $d->Componente;
            $reg->idSecretaria = $d->idSecretaria;
            $reg->idUA = $d->idUA;
            $reg->ClaveFuncional = $d->ClaveFuncional;
            $reg->DescripcionComponente = $d->DescripcionComponente . ' ' . $nuevo_ef;
            $reg->Anticorrupcion = $d->Anticorrupcion;
            $reg->idTipologia = $d->idTipologia;
            $reg->DescripcionPrograma = $d->DescripcionPrograma . ' ' . $nuevo_ef;
            $reg->ejercicioFiscal = $nuevo_ef;

            $reg->save();
        }

        $ef = new EjerciciosFiscales();
        $ef->Id = $nuevo_ef;
        $ef->Estatus = 'A';

        return $this->guardarCambios($ef);
        //return response()->json(array('error' => false, 'data' => $ef, 'code' => 200));
    }

    public function set_status(Request $request) {
        try {
            $update = DB::table('EJERCICIOS_FISCALES')
                ->where('Id', '=', $request->Id)
                ->limit(1)
                ->update(
                    array(
                        'Estatus' => $request->Estatus,
                    )
                );
            return response()->json(array('error' => false, 'result' => $update, 'code' => 200));
        }
        catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }
    }
}

?>