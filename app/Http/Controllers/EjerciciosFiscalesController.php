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
use App\MirCaratula;
use App\MirComponente;
use App\MirActividad;
use App\MirFin;
use App\MirProposito;


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
        $MIR_CARATULA = DB::select("SELECT * FROM MIR_CARATULA where EjercicioFiscal=$anterior_ef");
        $MIR_COMPONENTES = DB::select("SELECT * FROM COMPONENTE1  WHERE EjercicioFiscal=$anterior_ef");
        $MIR_COMPONENTES_ACTIVIDADES = DB::select("SELECT * FROM ACTIVIDAD  WHERE EjercicioFiscal=$anterior_ef");
        $FIN = DB::select("SELECT * FROM FIN1  WHERE EjercicioFiscal=$anterior_ef");
        $PROPOSITO = DB::select("SELECT * FROM PROPOSITO  WHERE EjercicioFiscal=$anterior_ef");

        //copiar programaticos
        foreach ($programatico as $key => $d) {
            $programa = new ProgramasPresupuestales();

            $programa->idObjetivoPED = $d->idObjetivoPED;
            $programa->idClasificacion = $d->idClasificacion;
            $programa->Consecutivo = $d->Consecutivo;
            $programa->Anticorrupcion = $d->Anticorrupcion;
            $programa->idTipologia = $d->idTipologia;
            $programa->DescripcionPrograma = $d->DescripcionPrograma;
            $programa->idSecretaria = $d->idSecretaria;
            $programa->idUA = $d->idUA;
            $programa->ejercicioFiscal = $nuevo_ef;

            $programa->save();
        }
        $componentes = array();
        //copiar componentes
        foreach ($programatico_comp as $key => $d) {
            $reg = new ProgramasPresupuestalesComponentes();
            
            $reg->idObjetivoPED = $d->idObjetivoPED;
            $reg->idClasificacion = $d->idClasificacion;
            $reg->Consecutivo = $d->Consecutivo;
            $reg->Componente = $d->Componente;
            $reg->idSecretaria = $d->idSecretaria;
            $reg->idUA = $d->idUA;
            $reg->DescripcionComponente = $d->DescripcionComponente;
            $reg->Observaciones = $d->Observaciones;
            $reg->ConacF = $d->ConacF;
            $reg->ejercicioFiscal = $nuevo_ef;

            $reg->save();
            $componentes["" . $d->Id] = $reg->Id;
        }

        //ACTUALIZAR COMPONENTES DEL NUEVO EJERCICIO
        $query = "UPDATE PROGRAMATICO_COMP c SET ProgramaticoId = 
                (SELECT Id FROM PROGRAMATICO AS p 
                    WHERE p.idObjetivoPED = c.idObjetivoPED
                    AND p.idClasificacion = c.idClasificacion
                    AND p.Consecutivo = c.Consecutivo
                    AND p.idSecretaria = c.idSecretaria
                    AND p.ejercicioFiscal = $nuevo_ef
                    ) where c.ejercicioFiscal = $nuevo_ef";
        $reg = DB::update($query);

        //copiar ais
        foreach ($PROGRAMATICO_AI_COMP as $key => $d) {
            $reg = new ActividadesInstitucionales();
            
            $reg->idObjetivoPED = $d->idObjetivoPED;
            $reg->idClasificacion = $d->idClasificacion;
            $reg->Consecutivo = $d->Consecutivo;
            $reg->Componente = $d->Componente;
            $reg->ClaveFuncional = $d->ClaveFuncional;
            $reg->DescripcionComponente = $d->DescripcionComponente;
            $reg->idSecretaria = $d->idSecretaria;
            $reg->idUA = $d->idUA;
            $reg->Observaciones = $d->Observaciones;
            $reg->ejercicioFiscal = $nuevo_ef;

            $reg->save();
        }

        //ACTUALIZAR AIS
        $query = "UPDATE PROGRAMATICO_AI_COMP c SET ProgramaticoId = 
                (SELECT Id FROM PROGRAMATICO AS p 
                    WHERE p.idObjetivoPED = c.idObjetivoPED
                    AND p.idClasificacion = c.idClasificacion
                    AND p.Consecutivo = c.Consecutivo
                    AND p.idSecretaria = c.idSecretaria
                    AND p.ejercicioFiscal = $nuevo_ef
                    ) where c.ejercicioFiscal = $nuevo_ef";
        $reg = DB::update($query);

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
            $reg->DescripcionComponente = $d->DescripcionComponente;
            $reg->Anticorrupcion = $d->Anticorrupcion;
            $reg->idTipologia = $d->idTipologia;
            $reg->DescripcionPrograma = $d->DescripcionPrograma;
            $reg->ejercicioFiscal = $nuevo_ef;

            $reg->save();
        }

        //ACTUALIZAR PPI
        $query = "UPDATE PROGRAMATICO_PI_COMP c SET ProgramaticoId = 
                (SELECT Id FROM PROGRAMATICO AS p 
                    WHERE p.idObjetivoPED = c.idObjetivoPED
                    AND p.idClasificacion = c.idClasificacion
                    AND p.Consecutivo = c.Consecutivo
                    AND p.idSecretaria = c.idSecretaria
                    AND p.ejercicioFiscal = $nuevo_ef
                    ) where c.ejercicioFiscal = $nuevo_ef";
        $reg = DB::update($query);

        //copiar MIR
        foreach ($MIR_CARATULA as $key => $d) {
            $reg = new MirCaratula();
            
            $reg->Consecutivo = $d->Consecutivo;
            $reg->EjercicioFiscal = $nuevo_ef;
            $reg->Estatus = $d->Estatus;
            $reg->CONAC = $d->CONAC;
            $reg->idCatBeneficiario = $d->idCatBeneficiario;
            $reg->idEje = $d->idEje;
            $reg->idTema = $d->idTema;
            $reg->idObjetivo = $d->idObjetivo;
            $reg->idEstrategia = $d->idEstrategia;
            $reg->idLineaAccion = $d->idLineaAccion;
            $reg->idLineaAccion2 = $d->idLineaAccion2;
            $reg->ProgramaSectorial = $d->ProgramaSectorial;
            $reg->idCatBeneficiario2 = $d->idCatBeneficiario2;
            $reg->LineaBase = $d->LineaBase;
            $reg->StatusMirId=1;

            $reg->save();
        }

        //copiar mir componentes
        foreach ($MIR_COMPONENTES as $k => $d) {
            $reg = new MirComponente();

            foreach (get_object_vars($d) as $key => $value) {
                $reg->$key = $value;
            }
            $reg->EjercicioFiscal = $nuevo_ef;
            $reg->Id = null;
            try{
                $reg->ComponenteId = $componentes[$d->ComponenteId];
            }
            catch (Exception $exception) {
                $reg->ComponenteId = null;
            }
            $reg->save();
        }

        //Actualizar las MIR para que tengan la asociación con el programa presupuestario
        $query = "UPDATE MIR_CARATULA mc 
        SET ProgramaticoId = (SELECT Id FROM PROGRAMATICO p 
        WHERE p.idObjetivoPED = mc.idObjetivo 
        AND p.idClasificacion = 'PP' 
        AND p.Consecutivo = mc.Consecutivo
        AND p.EjercicioFiscal = $nuevo_ef)
        where mc.EjercicioFiscal = $nuevo_ef"
        ;

        DB::update($query);

        //copiar mir actividades
        foreach ($MIR_COMPONENTES_ACTIVIDADES as $k => $d) {
            $reg = new MirActividad();

            foreach (get_object_vars($d) as $key => $value) {
                $reg->$key = $value;
            }
            $reg->EjercicioFiscal = $nuevo_ef;
            $reg->Id = null;
            $reg->ComponenteMirId = null;

            $reg->save();
        }

        $query = "UPDATE ACTIVIDAD a SET ComponenteMirId = 
            (SELECT Id 
                FROM COMPONENTE1 mc 
                WHERE mc.ClasProgramatica = a.ClasProgramatica 
                AND mc.idComponente = a.idComponente
                and mc.ejercicioFiscal=$nuevo_ef
                )
            where a.EjercicioFiscal=$nuevo_ef";
        DB::update($query);

        //copiar fin
        foreach ($FIN as $k => $d) {
            $reg = new MirFin();

            foreach (get_object_vars($d) as $key => $value) {
                $reg->$key = $value;
            }
            $reg->EjercicioFiscal = $nuevo_ef;
            $reg->Id = null;

            $reg->save();
        }

        //copiar proposito
        foreach ($PROPOSITO as $k => $d) {
            $reg = new MirProposito();

            foreach (get_object_vars($d) as $key => $value) {
                $reg->$key = $value;
            }
            $reg->EjercicioFiscal = $nuevo_ef;
            $reg->Id = null;

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
