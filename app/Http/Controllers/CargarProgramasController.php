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

class CargarProgramasController extends BaseController
{
    public function CargarProgramas(Request $request)
    {
        $file = $request->file("archivo");
        $nuevo_ef = 2024;

        if (($handle = fopen($file->path(), "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                //
                $programa = new ProgramasPresupuestales();
                $programa->idObjetivoPED = $data[1];
                $programa->idClasificacion = $data[0];
                $programa->Consecutivo = $data[4];
                $programa->Anticorrupcion = $data[2];
                $programa->idTipologia = $data[3];  //CONAC TIPOLOGIA
                $programa->DescripcionPrograma = $data[5];
                $programa->idSecretaria = $data[6];
                $programa->idUA = $data[7];
                $programa->ejercicioFiscal = $nuevo_ef;

                $programa->save();

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

                $pivote_comp = 8;
                for($i = 0; $i < 6; $i++) {
                    //agregar los componentes
                    $reg = new ProgramasPresupuestalesComponentes();

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

        return response()->json(array('error' => false, 'data' => '', 'code' => 200));
    }
}

?>