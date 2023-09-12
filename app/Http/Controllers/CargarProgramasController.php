<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\EjerciciosFiscales;
use App\ProgramasPresupuestales;
use App\ProgramasPresupuestalesComponentes;
use App\ActividadesInstitucionalesAccion;
use App\ActividadesInstitucionales;
use App\ProgramasProyectosInversion;
use App\MirCaratula;
use App\MirComponente;
use App\MirActividad;
use App\MirFin;
use App\MirProposito;

class CargarProgramasController extends BaseController
{
    public function CargarProgramas(Request $request)
    {
        $file = $request->file("archivo");
        $nuevo_ef = 2024;

        if (($handle = fopen($file->path(), "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                // buscar el programa, si está solo actualizarlo, 
                //eliminar caracteres no alfanumericos para elimianr bug
                $idClasificacion = preg_replace("/[^A-Za-z0-9 ]/", '', $data[0]);

                $q = DB::table("PROGRAMATICO")
                    ->where("idClasificacion","=", $idClasificacion)
                    ->where("idObjetivoPED","=",$data[1])
                    ->where("Anticorrupcion","=",$data[2])
                    ->where("idTipologia","=",$data[3])
                    ->where("Consecutivo","=",$data[4])
                    ->where("ejercicioFiscal","=",$nuevo_ef);

                $programa = $q->first();

                if($programa != null)
                {
                    // hay que eliminar todo el programa con
                    // sus componentes y lo que tenga en la MIR

                    //componentes
                    $componentes_eliminar = 
                        DB::table("PROGRAMATICO_COMP")
                        ->select("Id")
                        ->where("ProgramaticoId", "=", $programa->Id);

                    $arr_comp = $componentes_eliminar->get();
                    $ids = array();
                    foreach ($arr_comp as $key => $value) {
                        # code...
                        $ids[] = $value->Id;
                    }

                    $comp_eliminados = $componentes_eliminar->delete();

                    //componentes de mir a eliminar
                    $componentes_mir = DB::table("COMPONENTE1")
                    ->whereIn("ComponenteId", $ids)
                    ->delete();

                    //mirs
                    $mir_eliminar = DB::table("MIR_CARATULA")
                    ->where("ProgramaticoId", "=", $programa->Id)
                    ->delete();

                    DB::table("PROGRAMATICO")->delete($programa->Id);
                }

                //
                $programa = new ProgramasPresupuestales();
                $programa->idClasificacion = $idClasificacion;
                $programa->idObjetivoPED = $data[1];
                $programa->Anticorrupcion = $data[2];
                $programa->idTipologia = $data[3];  //CONAC TIPOLOGIA
                $programa->Consecutivo = $data[4];
                $programa->DescripcionPrograma = $data[5];
                $programa->idSecretaria = $data[6];
                $programa->idUA = $data[7];
                $programa->ejercicioFiscal = $nuevo_ef;

                $programa->save();

                // solo los programas presupuestarios (PP) tienen MIR
                if($programa->idClasificacion == "PP")
                {
                    //insertar la caratula de mir
                    $mir = new MirCaratula();

                    $mir->Consecutivo = $programa->Consecutivo;
                    $mir->EjercicioFiscal = $nuevo_ef;
                    $mir->Estatus = "CARGADO";

                    $mir->idEje = null;
                    $mir->idTema = null;
                    $mir->idObjetivo = $programa->idObjetivoPED;

                    $mir->ProgramaticoId = $programa->Id;

                    $mir->save();
                }

                $pivote_comp = 8;
                for($i = 0; $i < 6; $i++) {
                    //agregar los componentes
                    // CORREGIR: LAS DOS TABLAS SON IGUALES,
                    // SE DEBERÍA FUSIONAR EN UNA SOLA TABLA
                    if($programa->idClasificacion == "PP") {
                        $reg = new ProgramasPresupuestalesComponentes();
                    }
                    else
                        $reg = new ActividadesInstitucionalesAccion();

                    $reg->idObjetivoPED = $programa->idObjetivoPED;
                    $reg->idClasificacion = $programa->idClasificacion;
                    $reg->Consecutivo = $programa->Consecutivo;
                    $reg->idSecretaria = $programa->idSecretaria;

                    $reg->DescripcionComponente = $data[$pivote_comp + $i];
                    $reg->Componente = substr($reg->DescripcionComponente, 0, 2);
                    if($reg->Componente == "")
                        continue;

                    $reg->idUA = $data[$pivote_comp + $i + 6];
                    $reg->Observaciones = "";
                    $reg->ConacF = null;
                    $reg->ejercicioFiscal = $nuevo_ef;
                    $reg->ProgramaticoId = $programa->Id;

                    $reg->save();

                    if($programa->idClasificacion == "PP"){
                        //agregar componentes de mir
                        $mirc = new MirComponente();
                        $mirc->ComponenteId = $reg->Id;
                        $mirc->ClasProgramatica = $mir->Consecutivo;
                        $mirc->idComponente = $reg->Componente;
                        $mirc->EjercicioFiscal = $nuevo_ef;
                        $mirc->save();
                    }
                }
            }
        }

        return response()->json(array('error' => false, 'data' => '', 'code' => 200));
    }
}

?>
