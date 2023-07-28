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
        $query = "SELECT * FROM EJERCICIOS_FISCALES ORDER BY Id DESC;";
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
            $programa->DescripcionPrograma = $d->DescripcionPrograma ;
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
            $reg->DescripcionComponente = $d->DescripcionComponente ;
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
            $reg->DescripcionComponente = $d->DescripcionComponente ;
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
            $reg->DescripcionComponente = $d->DescripcionComponente ;
            $reg->Anticorrupcion = $d->Anticorrupcion;
            $reg->idTipologia = $d->idTipologia;
            $reg->DescripcionPrograma = $d->DescripcionPrograma ;
            $reg->ejercicioFiscal = $nuevo_ef;

            $reg->save();
        }

        $ef = new EjerciciosFiscales();
        $ef->Id = $nuevo_ef;
        $ef->Estatus = 'A';

        return $this->guardarCambios($ef);
        //return response()->json(array('error' => false, 'data' => $ef, 'code' => 200));
    }
}

?>