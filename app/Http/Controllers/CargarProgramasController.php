<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Basecontroller;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargarProgramasController extends BaseController
{
    public function CargarProgramas(Request $request)
    {
        $file = $request->file("archivo");

        $archivo = fopen($file->path());

        if (($handle = fopen($archivo, "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                //
            $programa = new ProgramasPresupuestales();
            $programa->idObjetivoPED = $data[1];
            $programa->idClasificacion = $data[0];
            $programa->Consecutivo = $data[4];
            $programa->Anticorrupcion = $data[2];
            $programa->idTipologia = $data[3];
            $programa->DescripcionPrograma = $data[5];
            $programa->idSecretaria = $data[6];
            $programa->idUA = $data[7];
            $programa->ejercicioFiscal = 2023;

            $programa->save();

            $pivote_comp = 8;
            for($i = 0; i < 6; $i++) {
                //agregar los componentes
                $reg = new ProgramasPresupuestalesComponentes();

                $reg->idObjetivoPED = $programa->idObjetivoPED;
                $reg->idClasificacion = $programa->idClasificacion;
                $reg->Consecutivo = $programa->Consecutivo;
                $reg->idSecretaria = $d->idSecretaria;
                $reg->idUA = $data[$pivote_comp + $i + 6];
                $reg->DescripcionComponente = $data[$pivote_comp + $i];
                $reg->Componente = substr($reg->DescripcionComponente, 0, 2);
                $reg->Observaciones = "";
                $reg->ConacF = null;
                $reg->ejercicioFiscal = $nuevo_ef;

                $reg->save();
            }
        }
    }


        return response()->json(array('error' => false, 'data' => '', 'code' => 200));
    }
}

?>
