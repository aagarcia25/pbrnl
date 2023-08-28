<?php

namespace App\Http\Controllers;

use App\MirCaratula;
use App\MirFin;
use App\MirProposito;
use App\MirComponente;
use App\MirActividad;
use App\LogCarga;
use App\LogFormula;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MirController extends Controller
{
    public function index(Request $request)
    {
        $ef = $request->ef;
        if ($request->id_secretaria == 0 && $request->id_ua == 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View where EjercicioFiscal=$ef ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else if ($request->id_secretaria != 0 && $request->id_ua == 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View WHERE idSecretaria = '$request->id_secretaria' and EjercicioFiscal=$ef ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else if ($request->id_secretaria == 0 && $request->id_ua != 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View WHERE idUA = '$request->id_ua' and EjercicioFiscal=$ef ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else{

            $query = "SELECT * FROM MIR_CARATULA_View WHERE idSecretaria = '$request->id_secretaria' AND idUA = '$request->id_ua' and EjercicioFiscal=$ef ORDER BY Consecutivo;";
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

    public function caratula_consecutivo(Request $request)
    {
        $info = DB::table('MIR_CARATULA_View')
            ->where('Consecutivo', $request->consecutivo)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function fin(Request $request)
    {
        $info = DB::table('FIN1')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function fin_validar(Request $request)
    {
        $info = DB::table('FIN1')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return $info;
    }

    public function proposito(Request $request)
    {
        $info = DB::table('PROPOSITO')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function proposito_validar(Request $request)
    {
        $info = DB::table('PROPOSITO')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return $info;
    }

    public function componentes(Request $request)
    {
        $query = "SELECT c1.*, cc.DescripcionComponente as Componente FROM 
            COMPONENTE1 c1
            INNER JOIN PROGRAMATICO_COMP cc
            on c1.ComponenteId = cc.Id
            WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function componentes_validar(Request $request)
    {
        $query = "SELECT * FROM COMPONENTE1 WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return $info;
    }

    public function actividades(Request $request)
    {
        $query = "SELECT * FROM ACTIVIDAD WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function actividades_validar(Request $request)
    {
        $query = "SELECT * FROM ACTIVIDAD WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return $info;
    }

    public function actividadescomponente($consecutivo, $id_componente)
    {
        $query = "SELECT * FROM ACTIVIDAD WHERE ClasProgramatica = '$consecutivo' AND idComponente = '$id_componente';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function actividadescomponente_validar($consecutivo, $id_componente)
    {
        $query = "SELECT * FROM ACTIVIDAD WHERE ClasProgramatica = '$consecutivo' AND idComponente = '$id_componente';";
        $info = DB::select($query);
        return $info;
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

    public function save(Request $request)
    {
        $info = array();

        // Eliminar información en carga
        $this->deleteCarga($request->caratula['consecutivo_caratula']);
        /*
        $delete = LogCarga::find($request->caratula['consecutivo_caratula']);
        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "No hay información en el log que eliminar.", 'code' => 404));
        }
        $delete->delete();
        */

        // C A R A T U L A
        try {
            
            $update_caratula = MirCaratula::
                where('EjercicioFiscal', '=', $request->caratula['ejercicio_fiscal'])
                ->where('Consecutivo', '=', $request->caratula['consecutivo_caratula'])->first();

            if (is_null($update_caratula)) {
                return response()->json(array('error' => true, 'result' => "No se ha encontrado la información de la carátula.", 'code' => 404));
            }

            // Validaciones de carátula
            $consecutivo_carga = $request->caratula['consecutivo_caratula'];
            $idelemento_carga = "C";
            $seccion_carga = "CARÁTULA";

            if (!isset($request->caratula['programa_sectorial']) || empty($request->caratula['programa_sectorial'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "PROGRAMA SECTORIAL", "REVISAR DESCRIPCIÓN");
            }

            $update_caratula->Consecutivo       = $request->caratula['consecutivo_caratula'];
                $update_caratula->EjercicioFiscal   = $request->caratula['ejercicio_fiscal'];
                $update_caratula->CONAC             = $request->caratula['conac_caratula'];
                $update_caratula->idCatBeneficiario = $request->caratula['select_descripcionampliabeneficiario1'];
                $update_caratula->idEje             = $request->caratula['select_ejeped'];
                $update_caratula->idTema            = $request->caratula['select_temaped'];
                $update_caratula->idObjetivo        = $request->caratula['select_objetivo'];
                $update_caratula->idEstrategia      = $request->caratula['select_estrategia'];
                $update_caratula->idLineaAccion     = $request->caratula['select_lineaaccion1'];
                $update_caratula->idLineaAccion2    = $request->caratula['select_lineaaccion2'];
                $update_caratula->ProgramaSectorial = $request->caratula['programa_sectorial'];
                $update_caratula->idCatBeneficiario2= $request->caratula['select_descripcionampliabeneficiario2'];
            $update_caratula->save();

            array_push($info, array("caratula" => true));
            
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar la caratula. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }

        // F I N
        try {
            $update_fin = MirFin::
                where('ClasProgramatica', '=', $request->fin['claseprogramatica_fin'])->first();

            if (is_null($update_fin)) {
                return response()->json(array('error' => true, 'result' => "No se ha encontrado la información del fin.", 'code' => 404));
            }
            
            // Validaciones de fin
            $consecutivo_carga = $request->fin['claseprogramatica_fin'];
            $idelemento_carga = "F";
            $seccion_carga = "Fin";

            if (!isset($request->fin['fin_fin']) || empty($request->fin['fin_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FIN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['nombreindicar_fin']) || empty($request->fin['nombreindicar_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->fin['nombreindicar_fin']) > 30) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "NUMERO DE PALABRAS MAYOR A 30. CONTEO = " . strlen($request->fin['nombreindicar_fin']));
            }

            if (!isset($request->fin['descripcionformula_fin']) || empty($request->fin['descripcionformula_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE FORMULA", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['variable1_fin']) || empty($request->fin['variable1_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V1", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['variable2_fin']) || empty($request->fin['variable2_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V2", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['variable3_fin']) || empty($request->fin['variable3_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FORMULA", "REVISAR FÓRMULA");
            }

            if ($request->fin['select_unidadmedida_fin'] == "A"){
                if (!isset($request->fin['descripcionunidadmedida_fin']) || empty($request->fin['descripcionunidadmedida_fin'])){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE UNIDAD DE MEDIDA", "REVISAR DESCRIPCIÓN");
                }
            }

            if ($request->fin['selectfrecuencia_fin'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FRECUENCIA", "REVISAR DESCRIPCIÓN");
            }

            if ($request->fin['metaanual_fin'] == "-" || !isset($request->fin['metaanual_fin']) || empty($request->fin['metaanual_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META ANUAL", "REVISAR VALOR");
            }

            if ($request->fin['lineabase_fin1'] == "-" || !isset($request->fin['lineabase_fin1']) || empty($request->fin['lineabase_fin1'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE", "REVISAR VALOR");
            }

            if ($request->fin['variable1numerador_fin'] == "-" || !isset($request->fin['variable1numerador_fin']) || empty($request->fin['variable1numerador_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "NUMERADOR", "REVISAR VALOR");
            }

            if ($request->fin['variable2numerador_fin'] == "-" || !isset($request->fin['variable2numerador_fin']) || empty($request->fin['variable2numerador_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DENOMINADOR", "REVISAR VALOR");
            }

            if ($request->fin['lineabaseV1_fin'] == "-" || !isset($request->fin['lineabaseV1_fin']) || empty($request->fin['lineabaseV1_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR");
            }

            if ($request->fin['lineabaseV2_fin'] == "-" || !isset($request->fin['lineabaseV2_fin']) || empty($request->fin['lineabaseV2_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR");
            }

            if (!isset($request->fin['mediosverificacion_fin']) || empty($request->fin['mediosverificacion_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MEDIOS DE VERIFICACIÓN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['fuentesinformacion_fin']) || empty($request->fin['fuentesinformacion_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FUENTES DE INFORMACIÓN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['supuestos_fin']) || empty($request->fin['supuestos_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SUPUESTOS", "REVISAR DESCRIPCIÓN");
            }

            if ($request->fin['select_sentidoindicador_fin'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SENTIDO DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->fin['select_tipoindicador_fin'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "TIPO DE INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->fin['select_dimensionindicador_fin'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DIMENSION DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['descripcionindicador_fin']) || empty($request->fin['descripcionindicador_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['descripcionnumerador_fin']) || empty($request->fin['descripcionnumerador_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN NUMERADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->fin['descripciondenominador_fin']) || empty($request->fin['descripciondenominador_fin'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DENOMINADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->fin['descripcionindicador_fin']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->fin['descripcionindicador_fin']));
            }

            if (strlen($request->fin['descripcionnumerador_fin']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL NUMERADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->fin['descripcionnumerador_fin']));
            }

            if (strlen($request->fin['descripciondenominador_fin']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL DENOMINADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->fin['descripciondenominador_fin']));
            }

            if ($request->fin['claridad_fin'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "CLARIDAD", "REVISAR REGISTRO");
            }

            if ($request->fin['relevancia_fin'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "RELEVANCIA", "REVISAR REGISTRO");
            }

            if ($request->fin['economia_fin'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ECONOMÍA", "REVISAR REGISTRO");
            }

            if ($request->fin['monitoreable_fin'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MONITOREABLE", "REVISAR REGISTRO");
            }

            if ($request->fin['adecuado_fin'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ADECUADO", "REVISAR REGISTRO");
            }

            if ($request->fin['aportemarginal_fin'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "APORTE MARGINAL", "REVISAR REGISTRO");
            }

            $update_fin->Fin                    = $request->fin['fin_fin'];
                $update_fin->Indicador              = $request->fin['nombreindicar_fin'];
                $update_fin->Formula                = $request->fin['descripcionformula_fin'];
                $update_fin->V1                     = $request->fin['variable1_fin'];
                $update_fin->V2                     = $request->fin['variable2_fin'];
                $update_fin->FormulaV1V2            = $request->fin['variable3_fin'];
                $update_fin->Frecuencia             = $request->fin['selectfrecuencia_fin'];
                $update_fin->MetaAnual              = $request->fin['metaanual_fin'];
                $update_fin->LineaBase              = $request->fin['lineabase_fin1'];
                $update_fin->MediosVerificacion     = $request->fin['mediosverificacion_fin'];
                $update_fin->FuenteInformacion      = $request->fin['fuentesinformacion_fin'];
                $update_fin->Supuestos              = $request->fin['supuestos_fin'];
                $update_fin->ValorNumerador         = $request->fin['variable1numerador_fin'];
                $update_fin->ValorDenominador       = $request->fin['variable2numerador_fin'];
                $update_fin->UnidadMedida           = $request->fin['select_unidadmedida_fin'];
                $update_fin->DescripAbsoluto        = $request->fin['descripcionunidadmedida_fin'];
                $update_fin->SentidoIndicador       = $request->fin['select_sentidoindicador_fin'];
                $update_fin->TipoIndicador          = $request->fin['select_tipoindicador_fin'];
                $update_fin->DimensionIndicador     = $request->fin['select_dimensionindicador_fin'];
                $update_fin->Claridad               = $request->fin['claridad_fin'];
                $update_fin->Relevancia             = $request->fin['relevancia_fin'];
                $update_fin->Economia               = $request->fin['economia_fin'];
                $update_fin->Monitoreable           = $request->fin['monitoreable_fin'];
                $update_fin->Adecuado               = $request->fin['adecuado_fin'];
                $update_fin->AporteMarginal         = $request->fin['aportemarginal_fin'];
                $update_fin->UnidadResponsable      = $request->fin['select_unidadresponsablereportar_fin'];
                $update_fin->DescripcionIndicador   = $request->fin['descripcionindicador_fin'];
                $update_fin->DescripcionNumerador   = $request->fin['descripcionnumerador_fin'];
                $update_fin->DescripcionDenominador = $request->fin['descripciondenominador_fin'];
                $update_fin->LineaBaseV1            = $request->fin['lineabaseV1_fin'];
                $update_fin->LineaBaseV2            = $request->fin['lineabaseV2_fin'];
            $update_fin->save();

            array_push($info, array("fin" => true));

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar el fin. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }

        // P R O P O S I T O
        try {
            $update_proposito = MirProposito::
                where('ClasProgramatica', '=', $request->proposito['claseprogramatica_proposito'])->first();

            if (is_null($update_proposito)) {
                return response()->json(array('error' => true, 'result' => "No se ha encontrado la información del proposito.", 'code' => 404));
            }

            // Validaciones de proposito
            $consecutivo_carga = $request->proposito['claseprogramatica_proposito'];
            $idelemento_carga = "P";
            $seccion_carga = "PROPÓSITO";

            if (!isset($request->proposito['fin_proposito']) || empty($request->proposito['fin_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FIN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['nombreindicar_proposito']) || empty($request->proposito['nombreindicar_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->proposito['nombreindicar_proposito']) > 30) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "NUMERO DE PALABRAS MAYOR A 30. CONTEO = " . strlen($request->proposito['nombreindicar_proposito']));
            }

            if (!isset($request->proposito['descripcionformula_proposito']) || empty($request->proposito['descripcionformula_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE FORMULA", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['variable1_proposito']) || empty($request->proposito['variable1_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V1", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['variable2_proposito']) || empty($request->proposito['variable2_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V2", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['variable3_proposito']) || empty($request->proposito['variable3_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FORMULA", "REVISAR FÓRMULA");
            }

            if ($request->proposito['select_unidadmedida_proposito'] == "A"){
                if (!isset($request->proposito['descripcionunidadmedida_proposito']) || empty($request->proposito['descripcionunidadmedida_proposito'])){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE UNIDAD DE MEDIDA", "REVISAR DESCRIPCIÓN");
                }
            }

            if ($request->proposito['selectfrecuencia_proposito'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FRECUENCIA", "REVISAR DESCRIPCIÓN");
            }

            if ($request->proposito['metaanual_proposito'] == "-" || !isset($request->proposito['metaanual_proposito']) || empty($request->proposito['metaanual_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META ANUAL", "REVISAR VALOR");
            }

            if ($request->proposito['lineabase_proposito1'] == "-" || !isset($request->proposito['lineabase_proposito1']) || empty($request->proposito['lineabase_proposito1'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE", "REVISAR VALOR");
            }

            if ($request->proposito['variable1numerador_proposito'] == "-" || !isset($request->proposito['variable1numerador_proposito']) || empty($request->proposito['variable1numerador_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "NUMERADOR", "REVISAR VALOR");
            }

            if ($request->proposito['variable2numerador_proposito'] == "-" || !isset($request->proposito['variable2numerador_proposito']) || empty($request->proposito['variable2numerador_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DENOMINADOR", "REVISAR VALOR");
            }

            if ($request->proposito['lineabaseV1_proposito'] == "-" || !isset($request->proposito['lineabaseV1_proposito']) || empty($request->proposito['lineabaseV1_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR");
            }

            if ($request->proposito['lineabaseV2_proposito'] == "-" || !isset($request->proposito['lineabaseV2_proposito']) || empty($request->proposito['lineabaseV2_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR");
            }

            if (!isset($request->proposito['mediosverificacion_proposito']) || empty($request->proposito['mediosverificacion_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MEDIOS DE VERIFICACIÓN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['fuentesinformacion_proposito']) || empty($request->proposito['fuentesinformacion_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FUENTES DE INFORMACIÓN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['supuestos_proposito']) || empty($request->proposito['supuestos_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SUPUESTOS", "REVISAR DESCRIPCIÓN");
            }

            if ($request->proposito['select_sentidoindicador_proposito'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SENTIDO DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->proposito['select_tipoindicador_proposito'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "TIPO DE INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->proposito['select_dimensionindicador_proposito'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DIMENSION DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['descripcionindicador_proposito']) || empty($request->proposito['descripcionindicador_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['descripcionnumerador_proposito']) || empty($request->proposito['descripcionnumerador_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN NUMERADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->proposito['descripciondenominador_proposito']) || empty($request->proposito['descripciondenominador_proposito'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DENOMINADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->proposito['descripcionindicador_proposito']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->proposito['descripcionindicador_proposito']));
            }

            if (strlen($request->proposito['descripcionnumerador_proposito']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL NUMERADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->proposito['descripcionnumerador_proposito']));
            }

            if (strlen($request->proposito['descripciondenominador_proposito']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL DENOMINADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->proposito['descripciondenominador_proposito']));
            }

            if ($request->proposito['claridad_proposito'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "CLARIDAD", "REVISAR REGISTRO");
            }

            if ($request->proposito['relevancia_proposito'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "RELEVANCIA", "REVISAR REGISTRO");
            }

            if ($request->proposito['economia_proposito'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ECONOMÍA", "REVISAR REGISTRO");
            }

            if ($request->proposito['monitoreable_proposito'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MONITOREABLE", "REVISAR REGISTRO");
            }

            if ($request->proposito['adecuado_proposito'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ADECUADO", "REVISAR REGISTRO");
            }

            if ($request->proposito['aportemarginal_proposito'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "APORTE MARGINAL", "REVISAR REGISTRO");
            }

            $update_proposito->Proposito              = $request->proposito['proposito_proposito'];
                $update_proposito->Indicador              = $request->proposito['nombreindicar_proposito'];
                $update_proposito->Formula                = $request->proposito['descripcionformula_proposito'];
                $update_proposito->V1                     = $request->proposito['variable1_proposito'];
                $update_proposito->V2                     = $request->proposito['variable2_proposito'];
                $update_proposito->FormulaV1V2            = $request->proposito['variable3_proposito'];
                $update_proposito->Frecuencia             = $request->proposito['selectfrecuencia_proposito'];
                $update_proposito->MetaAnual              = $request->proposito['metaanual_proposito'];
                $update_proposito->LineaBase              = $request->proposito['lineabase_proposito1'];
                $update_proposito->MediosVerificacion     = $request->proposito['mediosverificacion_proposito'];
                $update_proposito->FuenteInformacion      = $request->proposito['fuentesinformacion_proposito'];
                $update_proposito->Supuestos              = $request->proposito['supuestos_proposito'];
                $update_proposito->ValorNumerador         = $request->proposito['variable1numerador_proposito'];
                $update_proposito->ValorDenominador       = $request->proposito['variable2numerador_proposito'];
                $update_proposito->UnidadMedida           = $request->proposito['select_unidadmedida_proposito'];
                $update_proposito->DescripAbsoluto        = $request->proposito['descripcionunidadmedida_proposito'];
                $update_proposito->SentidoIndicador       = $request->proposito['select_sentidoindicador_proposito'];
                $update_proposito->TipoIndicador          = $request->proposito['select_tipoindicador_proposito'];
                $update_proposito->DimensionIndicador     = $request->proposito['select_dimensionindicador_proposito'];
                $update_proposito->Claridad               = $request->proposito['claridad_proposito'];
                $update_proposito->Relevancia             = $request->proposito['relevancia_proposito'];
                $update_proposito->Economia               = $request->proposito['economia_proposito'];
                $update_proposito->Monitoreable           = $request->proposito['monitoreable_proposito'];
                $update_proposito->Adecuado               = $request->proposito['adecuado_proposito'];
                $update_proposito->AporteMarginal         = $request->proposito['aportemarginal_proposito'];
                $update_proposito->UnidadResponsable      = $request->proposito['select_unidadresponsablereportar_proposito'];
                $update_proposito->DescripcionIndicador   = $request->proposito['descripcionindicador_proposito'];
                $update_proposito->DescripcionNumerador   = $request->proposito['descripcionnumerador_proposito'];
                $update_proposito->DescripcionDenominador = $request->proposito['descripciondenominador_proposito'];
                $update_proposito->LineaBaseV1            = $request->proposito['lineabaseV1_proposito'];
                $update_proposito->LineaBaseV2            = $request->proposito['lineabaseV2_proposito'];
            $update_proposito->save();
            
            array_push($info, array("proposito" => true));

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar el proposito. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }

        // C O M P O N E N T E
        try {
            
            $update_verify_componente = MirComponente::
                where('ClasProgramatica', '=', $request->componente['claseprogramatica_componente'])
                ->where('idComponente', '=', $request->componente['id_componente'])->first();

            if (is_null($update_verify_componente)) {
                return response()->json(array('error' => true, 'result' => "No se ha encontrado la información del componente.", 'code' => 404));
            }

            // Validaciones de componente
            $consecutivo_carga = $request->componente['claseprogramatica_componente'];
            $idelemento_carga = $request->componente['id_componente'];
            $seccion_carga = "COMPONENTE " . $request->componente['id_componente'];

            if (!isset($request->componente['nombre_componenteactividad']) || empty($request->componente['nombre_componenteactividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "COMPONENTE", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->componente['nombreindicar_componente']) || empty($request->componente['nombreindicar_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->componente['nombreindicar_componente']) > 30) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "NUMERO DE PALABRAS MAYOR A 30. CONTEO = " . strlen($request->componente['nombreindicar_componente']));
            }

            if (!isset($request->componente['descripcionformula_componente']) || empty($request->componente['descripcionformula_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE FORMULA", "REVISAR DESCRIPCIÓN");
            }
            
            if (!isset($request->componente['variable1_componente']) || empty($request->componente['variable1_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V1", "REVISAR DESCRIPCIÓN");
            }
            
            if (!isset($request->componente['variable2_componente']) || empty($request->componente['variable2_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V2", "REVISAR DESCRIPCIÓN");
            }
            
            if (!isset($request->componente['variable3_componente']) || empty($request->componente['variable3_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FORMULA", "REVISAR FÓRMULA");
            }
            
            if ($request->componente['select_unidadmedida_componente'] == "A"){
                if (!isset($request->componente['descripcionunidadmedida_componente']) || empty($request->componente['descripcionunidadmedida_componente'])){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE UNIDAD DE MEDIDA", "REVISAR DESCRIPCIÓN");
                }
            }
            
            if ($request->componente['selectfrecuencia_componente'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FRECUENCIA", "REVISAR DESCRIPCIÓN");
            }

            if ($request->componente['metaanual_componente'] == "-" || !isset($request->componente['metaanual_componente']) || empty($request->componente['metaanual_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META ANUAL", "REVISAR VALOR");
            }
            
            if ($request->componente['lineabaseV1_componente'] == "-" || !isset($request->componente['lineabaseV1_componente']) || empty($request->componente['lineabaseV1_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR");
            }
            
            if ($request->componente['lineabaseV2_componente'] == "-" || !isset($request->componente['lineabaseV2_componente']) || empty($request->componente['lineabaseV2_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR");
            }

            // Validación semestral
            if ($request->componente['selectfrecuencia_componente'] == "SEMESTRAL"){
                if ($request->componente['metasemestral1_componente'] == 0 || $request->componente['metasemestral1_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 1", "REVISAR VALOR");
                }

                if ($request->componente['metasemestral2_componente'] == 0 || $request->componente['metasemestral2_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 2", "REVISAR VALOR");
                }

                if ($request->componente['metasemestral1V1D_componente'] == 0 || $request->componente['metasemestral1V1D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 1 V1", "REVISAR VALOR");
                }

                if ($request->componente['metasemestral1V2D_componente'] == 0 || $request->componente['metasemestral1V2D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 1 V2", "REVISAR VALOR");
                }

                if ($request->componente['metasemestral2V1D_componente'] == 0 || $request->componente['metasemestral2V1D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 2 V1", "REVISAR VALOR");
                }

                if ($request->componente['metasemestral2V2D_componente'] == 0 || $request->componente['metasemestral2V2D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 2 V2", "REVISAR VALOR");
                }
            }
            
            // Validacion trimestral
            if ($request->componente['selectfrecuencia_componente'] == "TRIMESTRAL"){
                if ($request->componente['metatrimestral1_componente'] == 0 || $request->componente['metatrimestral1_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 1", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral2_componente'] == 0 || $request->componente['metatrimestral2_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 2", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral3_componente'] == 0 || $request->componente['metatrimestral3_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 3", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral4_componente'] == 0 || $request->componente['metatrimestral4_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 4", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral1V1D_componente'] == 0 || $request->componente['metatrimestral1V1D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 1 V1", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral1V2D_componente'] == 0 || $request->componente['metatrimestral1V2D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 1 V2", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral2V1D_componente'] == 0 || $request->componente['metatrimestral2V1D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 2 V1", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral2V2D_componente'] == 0 || $request->componente['metatrimestral2V2D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 2 V2", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral3V1D_componente'] == 0 || $request->componente['metatrimestral3V1D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 3 V1", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral3V2D_componente'] == 0 || $request->componente['metatrimestral3V2D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 3 V2", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral4V1D_componente'] == 0 || $request->componente['metatrimestral4V1D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 4 V1", "REVISAR VALOR");
                }

                if ($request->componente['metatrimestral4V2D_componente'] == 0 || $request->componente['metatrimestral4V2D_componente'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 4 V2", "REVISAR VALOR");
                }
            }

            if (!isset($request->componente['mediosverificacion_componente']) || empty($request->componente['mediosverificacion_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MEDIOS DE VERIFICACIÓN", "REVISAR DESCRIPCIÓN");
            }
            
            if (!isset($request->componente['fuentesinformacion_componente']) || empty($request->componente['fuentesinformacion_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FUENTES DE INFORMACIÓN", "REVISAR DESCRIPCIÓN");
            }
            
            if (!isset($request->componente['supuestos_componente']) || empty($request->componente['supuestos_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SUPUESTOS", "REVISAR DESCRIPCIÓN");
            }
            
            if ($request->componente['select_sentidoindicador_componente'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SENTIDO DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->componente['select_tipoindicador_componente'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "TIPO DE INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->componente['select_dimensionindicador_componente'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DIMENSION DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->componente['descripcionindicador_componente']) || empty($request->componente['descripcionindicador_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->componente['descripcionnumerador_componente']) || empty($request->componente['descripcionnumerador_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN NUMERADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->componente['descripciondenominador_componente']) || empty($request->componente['descripciondenominador_componente'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DENOMINADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->componente['descripcionindicador_componente']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->componente['descripcionindicador_componente']));
            }

            if (strlen($request->componente['descripcionnumerador_componente']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL NUMERADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->componente['descripcionnumerador_componente']));
            }

            if (strlen($request->componente['descripciondenominador_componente']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL DENOMINADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->componente['descripciondenominador_componente']));
            }

            if ($request->componente['claridad_componente'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "CLARIDAD", "REVISAR REGISTRO");
            }

            if ($request->componente['relevancia_componente'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "RELEVANCIA", "REVISAR REGISTRO");
            }

            if ($request->componente['economia_componente'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ECONOMÍA", "REVISAR REGISTRO");
            }

            if ($request->componente['monitoreable_componente'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MONITOREABLE", "REVISAR REGISTRO");
            }

            if ($request->componente['adecuado_componente'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ADECUADO", "REVISAR REGISTRO");
            }

            if ($request->componente['aportemarginal_componente'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "APORTE MARGINAL", "REVISAR REGISTRO");
            }

            $update_componente = DB::table('COMPONENTE1')
                ->where('ClasProgramatica', '=', $request->componente['claseprogramatica_componente'])
                ->where('idComponente', '=', $request->componente['id_componente'])
                ->limit(1)
                ->update(
                array(
                    'ClasProgramatica' => $request->componente['claseprogramatica_componente'],
                    'idComponente' => $request->componente['id_componente'],
                    'Componente' => $request->componente['nombre_componenteactividad'],
                    'Indicador' => $request->componente['nombreindicar_componente'],
                    'Formula' => $request->componente['descripcionformula_componente'],
                    'V1' => $request->componente['variable1_componente'],
                    'V2' => $request->componente['variable2_componente'],
                    'FormulaV1V2' => $request->componente['variable3_componente'],
                    'Frecuencia' => $request->componente['selectfrecuencia_componente'],
                    'MetaAnual' => $request->componente['metaanual_componente'],
                    'LineaBase' => $request->componente['lineabase_componente1'],
                    'FuenteInformacion' => $request->componente['fuentesinformacion_componente'],
                    'Supuestos' => $request->componente['supuestos_componente'],
                    'ValorNumerador' => $request->componente['variableV1_componente'],
                    'ValorDenominador' => $request->componente['variableV2_componente'],
                    'LineaBaseV1' => $request->componente['lineabaseV1_componente'],
                    'LineaBaseV2' => $request->componente['lineabaseV2_componente'],
                    'UnidadMedida' => $request->componente['select_unidadmedida_componente'],
                    'DescripAbsoluto' => $request->componente['descripcionunidadmedida_componente'],
                    'SentidoIndicador' => $request->componente['select_sentidoindicador_componente'],
                    'TipoIndicador' => $request->componente['select_tipoindicador_componente'],
                    'DimensionIndicador' => $request->componente['select_dimensionindicador_componente'],
                    'Claridad' => $request->componente['claridad_componente'],
                    'Relevancia' => $request->componente['relevancia_componente'],
                    'Economia' => $request->componente['economia_componente'],
                    'Monitoreable' => $request->componente['monitoreable_componente'],
                    'Adecuado' => $request->componente['adecuado_componente'],
                    'AporteMarginal' => $request->componente['aportemarginal_componente'],
                    'UnidadResponsable' => $request->componente['select_unidadresponsablereportar_componente'],
                    'DescripcionIndicador' => $request->componente['descripcionindicador_componente'],
                    'DescripcionNumerador' => $request->componente['descripcionnumerador_componente'],
                    'DescripcionDenominador' => $request->componente['descripciondenominador_componente'],
                    'MetaSemestre1' => $request->componente['metasemestral1_componente'],
                    'MetaSemestre2' => $request->componente['metasemestral2_componente'],
                    'MetaTrimestre1' => $request->componente['metatrimestral1_componente'],
                    'MetaTrimestre2' => $request->componente['metatrimestral2_componente'],
                    'MetaTrimestre3' => $request->componente['metatrimestral3_componente'],
                    'MetaTrimestre4' => $request->componente['metatrimestral4_componente'],
                    'MediosVerificacion' => $request->componente['mediosverificacion_componente'],
                    'ClaveIndicador' => $request->componente['claveindicador_componente'],
                    'Semestre1V1' => $request->componente['metasemestral1V1D_componente'],
                    'Semestre1V2' => $request->componente['metasemestral1V2D_componente'],
                    'Semestre2V1' => $request->componente['metasemestral2V1D_componente'],
                    'Semestre2V2' => $request->componente['metasemestral2V2D_componente'],
                    'Trimestre1V1' => $request->componente['metatrimestral1V1D_componente'],
                    'Trimestre1V2' => $request->componente['metatrimestral1V2D_componente'],
                    'Trimestre2V1' => $request->componente['metatrimestral2V1D_componente'],
                    'Trimestre2V2' => $request->componente['metatrimestral2V2D_componente'],
                    'Trimestre3V1' => $request->componente['metatrimestral3V1D_componente'],
                    'Trimestre3V2' => $request->componente['metatrimestral3V2D_componente'],
                    'Trimestre4V1' => $request->componente['metatrimestral4V1D_componente'],
                    'Trimestre4V2' => $request->componente['metatrimestral4V2D_componente']
                )
            );
            
            array_push($info, array("componente" => true));
            
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar el componente. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }

        // A C T I V I D A D
        try {
            $update_verify_actividad = MirActividad::
                where('ClasProgramatica', '=', $request->actividad['claseprogramatica_actividad'])
                ->where('idComponente', '=', $request->actividad['idcomponente_actividad'])
                ->where('idActividad', '=', $request->actividad['id_actividad'])->first();

            if (is_null($update_verify_actividad)) {
                return response()->json(array('error' => true, 'result' => "No se ha encontrado la información de la actividad.", 'code' => 404));
            }

            // Validaciones de actividad
            $consecutivo_carga = $request->actividad['claseprogramatica_actividad'];
            $idelemento_carga = $request->actividad['id_actividad'];
            $seccion_carga = "PROPOSITO " . $request->actividad['id_actividad'];

            if (!isset($request->actividad['nombre_actividadactividad']) || empty($request->actividad['nombre_actividadactividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "COMPONENTE", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['nombreindicar_actividad']) || empty($request->actividad['nombreindicar_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->actividad['nombreindicar_actividad']) > 30) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "INDICADOR", "NUMERO DE PALABRAS MAYOR A 30. CONTEO = " . strlen($request->actividad['nombreindicar_actividad']));
            }

            if (!isset($request->actividad['descripcionformula_actividad']) || empty($request->actividad['descripcionformula_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE FORMULA", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['variable1_actividad']) || empty($request->actividad['variable1_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V1", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['variable2_actividad']) || empty($request->actividad['variable2_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "VARIABLE V2", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['variable3_actividad']) || empty($request->actividad['variable3_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FORMULA", "REVISAR FÓRMULA");
            }

            if ($request->actividad['select_unidadmedida_actividad'] == "A"){
                if (!isset($request->actividad['descripcionunidadmedida_actividad']) || empty($request->actividad['descripcionunidadmedida_actividad'])){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCION DE UNIDAD DE MEDIDA", "REVISAR DESCRIPCIÓN");
                }
            }

            if ($request->actividad['selectfrecuencia_actividad'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FRECUENCIA", "REVISAR DESCRIPCIÓN");
            }

            if ($request->actividad['metaanual_actividad'] == "-" || !isset($request->actividad['metaanual_actividad']) || empty($request->actividad['metaanual_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META ANUAL", "REVISAR VALOR");
            }

            if ($request->actividad['lineabaseV1_actividad'] == "-" || !isset($request->actividad['lineabaseV1_actividad']) || empty($request->actividad['lineabaseV1_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR");
            }

            if ($request->actividad['lineabaseV2_actividad'] == "-" || !isset($request->actividad['lineabaseV2_actividad']) || empty($request->actividad['lineabaseV2_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR");
            }

            // Validación semestral
            if ($request->actividad['selectfrecuencia_actividad'] == "SEMESTRAL"){
                if ($request->actividad['metasemestral1_actividad'] == 0 || $request->actividad['metasemestral1_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 1", "REVISAR VALOR");
                }

                if ($request->actividad['metasemestral2_actividad'] == 0 || $request->actividad['metasemestral2_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 2", "REVISAR VALOR");
                }

                if ($request->actividad['metasemestral1V1D_actividad'] == 0 || $request->actividad['metasemestral1V1D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 1 V1", "REVISAR VALOR");
                }

                if ($request->actividad['metasemestral1V2D_actividad'] == 0 || $request->actividad['metasemestral1V2D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 1 V2", "REVISAR VALOR");
                }

                if ($request->actividad['metasemestral2V1D_actividad'] == 0 || $request->actividad['metasemestral2V1D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 2 V1", "REVISAR VALOR");
                }

                if ($request->actividad['metasemestral2V2D_actividad'] == 0 || $request->actividad['metasemestral2V2D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META SEMESTRE 2 V2", "REVISAR VALOR");
                }
            }

            // Validacion trimestral
            if ($request->actividad['selectfrecuencia_actividad'] == "TRIMESTRAL"){
                if ($request->actividad['metatrimestral1_actividad'] == 0 || $request->actividad['metatrimestral1_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 1", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral2_actividad'] == 0 || $request->actividad['metatrimestral2_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 2", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral3_actividad'] == 0 || $request->actividad['metatrimestral3_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 3", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral4_actividad'] == 0 || $request->actividad['metatrimestral4_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 4", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral1V1D_actividad'] == 0 || $request->actividad['metatrimestral1V1D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 1 V1", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral1V2D_actividad'] == 0 || $request->actividad['metatrimestral1V2D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 1 V2", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral2V1D_actividad'] == 0 || $request->actividad['metatrimestral2V1D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 2 V1", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral2V2D_actividad'] == 0 || $request->actividad['metatrimestral2V2D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 2 V2", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral3V1D_actividad'] == 0 || $request->actividad['metatrimestral3V1D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 3 V1", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral3V2D_actividad'] == 0 || $request->actividad['metatrimestral3V2D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 3 V2", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral4V1D_actividad'] == 0 || $request->actividad['metatrimestral4V1D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 4 V1", "REVISAR VALOR");
                }

                if ($request->actividad['metatrimestral4V2D_actividad'] == 0 || $request->actividad['metatrimestral4V2D_actividad'] == "-"){
                    $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "META TRIMESTRE 4 V2", "REVISAR VALOR");
                }
            }

            if (!isset($request->actividad['mediosverificacion_actividad']) || empty($request->actividad['mediosverificacion_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MEDIOS DE VERIFICACIÓN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['fuentesinformacion_actividad']) || empty($request->actividad['fuentesinformacion_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "FUENTES DE INFORMACIÓN", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['supuestos_actividad']) || empty($request->actividad['supuestos_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SUPUESTOS", "REVISAR DESCRIPCIÓN");
            }

            if ($request->actividad['select_sentidoindicador_actividad'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "SENTIDO DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->actividad['select_tipoindicador_actividad'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "TIPO DE INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if ($request->actividad['select_dimensionindicador_actividad'] == "-"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DIMENSION DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['descripcionindicador_actividad']) || empty($request->actividad['descripcionindicador_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['descripcionnumerador_actividad']) || empty($request->actividad['descripcionnumerador_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN NUMERADOR", "REVISAR DESCRIPCIÓN");
            }

            if (!isset($request->actividad['descripciondenominador_actividad']) || empty($request->actividad['descripciondenominador_actividad'])){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DENOMINADOR", "REVISAR DESCRIPCIÓN");
            }

            if (strlen($request->actividad['descripcionindicador_actividad']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL INDICADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->actividad['descripcionindicador_actividad']));
            }

            if (strlen($request->actividad['descripcionnumerador_actividad']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL NUMERADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->actividad['descripcionnumerador_actividad']));
            }

            if (strlen($request->actividad['descripciondenominador_actividad']) > 300) {
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "DESCRIPCIÓN DEL DENOMINADOR", "NÚMERO DE CARACTERES MAYOR A 300. CONTEO = " . strlen($request->actividad['descripciondenominador_actividad']));
            }

            if ($request->actividad['claridad_actividad'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "CLARIDAD", "REVISAR REGISTRO");
            }

            if ($request->actividad['relevancia_actividad'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "RELEVANCIA", "REVISAR REGISTRO");
            }

            if ($request->actividad['economia_actividad'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ECONOMÍA", "REVISAR REGISTRO");
            }

            if ($request->actividad['monitoreable_actividad'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "MONITOREABLE", "REVISAR REGISTRO");
            }

            if ($request->actividad['adecuado_actividad'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "ADECUADO", "REVISAR REGISTRO");
            }

            if ($request->actividad['aportemarginal_actividad'] == "N"){
                $this->addCarga($consecutivo_carga, $idelemento_carga, $seccion_carga, "APORTE MARGINAL", "REVISAR REGISTRO");
            }

            $update_actividad = DB::table('ACTIVIDAD')
                ->where('ClasProgramatica', '=', $request->actividad['claseprogramatica_actividad'])
                ->where('idComponente', '=', $request->actividad['idcomponente_actividad'])
                ->where('idActividad', '=', $request->actividad['id_actividad'])
                ->limit(1)
                ->update(
                array(
                    'ClasProgramatica' => $request->actividad['claseprogramatica_actividad'],
                    'idComponente' => $request->actividad['idcomponente_actividad'],
                    'idActividad' => $request->actividad['id_actividad'],
                    'Actividad' => $request->actividad['nombre_actividad'],
                    'Indicador' => $request->actividad['nombreindicar_actividad'],
                    'Formula' => $request->actividad['descripcionformula_actividad'],
                    'V1' => $request->actividad['variable1_actividad'],
                    'V2' => $request->actividad['variable2_actividad'],
                    'FormulaV1V2' => $request->actividad['variable3_actividad'],
                    'Frecuencia' => $request->actividad['selectfrecuencia_actividad'],
                    'MetaAnual' => $request->actividad['metaanual_actividad'],
                    'LineaBase' => $request->actividad['lineabase_actividad1'],
                    'FuenteInformacion' => $request->actividad['fuentesinformacion_actividad'],
                    'Supuestos' => $request->actividad['supuestos_actividad'],
                    'ValorNumerador' => $request->actividad['variableV1_actividad'],
                    'ValorDenominador' => $request->actividad['variableV2_actividad'],
                    'UnidadMedida' => $request->actividad['select_unidadmedida_actividad'],
                    'DescripAbsoluto' => $request->actividad['descripcionunidadmedida_actividad'],
                    'SentidoIndicador' => $request->actividad['select_sentidoindicador_actividad'],
                    'TipoIndicador' => $request->actividad['select_tipoindicador_actividad'],
                    'DimensionIndicador' => $request->actividad['select_dimensionindicador_actividad'],
                    'Claridad' => $request->actividad['claridad_actividad'],
                    'Relevancia' => $request->actividad['relevancia_actividad'],
                    'Economia' => $request->actividad['economia_actividad'],
                    'Monitoreable' => $request->actividad['monitoreable_actividad'],
                    'Adecuado' => $request->actividad['adecuado_actividad'],
                    'AporteMarginal' => $request->actividad['aportemarginal_actividad'],
                    'UnidadResponsable' => $request->actividad['select_unidadresponsablereportar_actividad'],
                    'DescripcionIndicador' => $request->actividad['descripcionindicador_actividad'],
                    'DescripcionNumerador' => $request->actividad['descripcionnumerador_actividad'],
                    'DescripcionDenominador' => $request->actividad['descripciondenominador_actividad'],
                    'MetaSemestre1' => $request->actividad['metasemestral1_actividad'],
                    'MetaSemestre2' => $request->actividad['metasemestral2_actividad'],
                    'MetaTrimestre1' => $request->actividad['metatrimestral1_actividad'],
                    'MetaTrimestre2' => $request->actividad['metatrimestral2_actividad'],
                    'MetaTrimestre3' => $request->actividad['metatrimestral3_actividad'],
                    'MetaTrimestre4' => $request->actividad['metatrimestral4_actividad'],
                    'MediosVerificacion' => $request->actividad['mediosverificacion_actividad'],
                    'ClaveIndicador' => $request->actividad['claveindicador_actividad'],
                    'Trimestre1V1' => $request->actividad['metatrimestral1V1D_actividad'],
                    'Trimestre2V1' => $request->actividad['metatrimestral2V1D_actividad'],
                    'Trimestre3V1' => $request->actividad['metatrimestral3V1D_actividad'],
                    'Trimestre4V1' => $request->actividad['metatrimestral4V1D_actividad'],
                    'Trimestre1V2' => $request->actividad['metatrimestral1V2D_actividad'],
                    'Trimestre2V2' => $request->actividad['metatrimestral2V2D_actividad'],
                    'Trimestre3V2' => $request->actividad['metatrimestral3V2D_actividad'],
                    'Trimestre4V2' => $request->actividad['metatrimestral4V2D_actividad']
                )
            );
            
            array_push($info, array("actividad" => true));

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar la actividad. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }

        // Obtenemos la información para refrescar
        $info_caratula = MirCaratula::
            where('EjercicioFiscal', '=', $request->caratula['ejercicio_fiscal'])
            ->where('Consecutivo', '=', $request->caratula['consecutivo_caratula'])->first();
        
        $info_fin = MirFin::
            where('ClasProgramatica', '=', $request->fin['claseprogramatica_fin'])->first();

        $info_proposito = MirProposito::
            where('ClasProgramatica', '=', $request->proposito['claseprogramatica_proposito'])->first();

        $query_componente = "SELECT * FROM COMPONENTE1 WHERE ClasProgramatica = '".$request->componente['claseprogramatica_componente']."';";
        $info_componente = DB::select($query_componente);
        
        $query_actividad = "SELECT * FROM ACTIVIDAD WHERE ClasProgramatica = '".$request->actividad['claseprogramatica_actividad']."';";
        $info_actividad = DB::select($query_actividad);
        
        $informacion = array(
            "caratula" => $info_caratula, 
            "fin" => $info_fin, 
            "proposito" => $info_proposito, 
            "componente" => $info_componente, 
            "actividad" => $info_actividad
        );

        return response()->json(array('error' => false, 'result' => $info, 'actual' => $informacion, 'code' => 200));
    }

    public function validarFormulas(Request $request){
        $consecutivo = $request->consecutivo;
        $fin = $this->fin_validar($request);
        $proposito = $this->proposito_validar($request);
        $componentes = $this->componentes_validar($request);
        $actividades = $this->actividades_validar($request);
    
        // F O R M U L A S   D E   F I N
        $array = array();
        $this->deleteFormula($consecutivo);

        $valida_fin = $this->validaFin($consecutivo, $fin);
        
        $ResultadoMeta_Fin = 0;
        $ResultadoLineaBase_Fin = 0;
        $MetaAnual_Fin = 0;
        $LineaBase_Fin = 0;
        
        if ($valida_fin == 1){
            $idelemento_carga = "F";
            $seccion_carga = "Fin";
            $numero = substr($fin->TipoFormula, 0, 1);
            $signo = substr($fin->TipoFormula, 1, 1);
    
            $Denominador = $fin->ValorDenominador;
            $Numerador = $fin->ValorNumerador;
            $Numerador = str_replace(",", "", $Numerador);
            $Denominador = str_replace(",", "", $Denominador);
            $LineaBaseV1 = $fin->LineaBaseV1;
            $LineaBaseV2 = $fin->LineaBaseV2;
            $LineaBaseV1 = str_replace(",", "", $LineaBaseV1);
            $LineaBaseV2 = str_replace(",", "", $LineaBaseV2);
            $MetaAnual = $fin->MetaAnualOriginal;
            $LineaBase = $fin->LineaBaseOriginal;
            // echo "FIN";
            switch ($numero) {
                case 1:
                    if ($signo == "-"){
                        //((V1 - V2)/V2)*100
                        if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 2 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Denominador, "");
                            $ResultadoMeta_Fin = 0;
                            // echo "FIN- $Denominador";
                        }else{
                            $ResultadoMeta_Fin = round(((floatval($Numerador) - floatval($Denominador)) / floatval($Denominador)) * 100, 2);
                            // echo "FIN".$ResultadoMeta_Fin;
                        }
    
                        if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                        }else{
                            $ResultadoLineaBase_Fin = round(((floatval($LineaBaseV1) - floatval($LineaBaseV2)) / floatval($LineaBaseV2)) * 100, 2);
                        }
                    }else{
                        //((V1 + V2)/V2)*100
                        if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 2 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Denominador, "");
                            $ResultadoMeta_Fin = 0;
                        }else{
                            $ResultadoMeta_Fin = round(((floatval($Numerador) + floatval($Denominador)) / floatval($Denominador)) * 100, 2);
                        }
    
                        if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                        }else{
                            $ResultadoLineaBase_Fin = round(((floatval($LineaBaseV1) + floatval($LineaBaseV2)) / floatval($LineaBaseV2)) * 100, 2);
                        }
                    }
                    break;
                case 2:
                    if ($signo == "-"){
                        //((V1 - V2)/V1)*100
                        if ($Numerador == "" || $Numerador == "-" || $Numerador == "0" || $Numerador == "0.00" || $Numerador == 0 || $Numerador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (NUMERADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                            $ResultadoMeta_Fin = 0;
                        }else{
                            $ResultadoMeta_Fin = round((floatval($Numerador) - floatval($Denominador) / floatval($Numerador)) * 100, 2);
                        }
    
                        if ($LineaBaseV1 == "" || $LineaBaseV1 == "-" || $LineaBaseV1 == "0" || $LineaBaseV1 == "0.00" || $LineaBaseV1 == 0 || $LineaBaseV1 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV1, "");
                        }else{
                            $ResultadoLineaBase_Fin = round(((floatval($LineaBaseV1) - floatval($LineaBaseV2)) / floatval($LineaBaseV1)) * 100, 2);
                        }
                    }else{
                        //((V1 + V2)/V1)*100
                        if ($Numerador == "" || $Numerador == "-" || $Numerador == "0" || $Numerador == "0.00" || $Numerador == 0 || $Numerador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (NUMERADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                            $ResultadoMeta_Fin = 0;
                        }else{
                            $ResultadoMeta_Fin = round(((floatval($Numerador) + floatval($Denominador)) / floatval($Numerador)) * 100, 2);
                        }
    
                        if ($LineaBaseV1 == "" || $LineaBaseV1 == "-" || $LineaBaseV1 == "0" || $LineaBaseV1 == "0.00" || $LineaBaseV1 == 0 || $LineaBaseV1 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV1, "");
                        }else{
                            $ResultadoLineaBase_Fin = round(((floatval($LineaBaseV1) + floatval($LineaBaseV2)) / floatval($LineaBaseV1)) * 100, 2);
                        }
                    }
                    break;
                case 3:
                    //V1/V2
                    if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                        $ResultadoMeta_Fin = 0;
                    }else{
                        $ResultadoMeta_Fin = round(floatval($Numerador) / floatval($Denominador), 2);
                    }
    
                    if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                    }else{
                        $ResultadoLineaBase_Fin = round(floatval($LineaBaseV1) / floatval($LineaBaseV2), 2);
                    }
                    break;
                case 4:
                    //(V1/V2)*100
                    if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                        $ResultadoMeta_Fin = 0;
                    }else{
                        $ResultadoMeta_Fin = round((floatval($Numerador) / floatval($Denominador))*100, 2);
                    }
    
                    if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                    }else{
                        $ResultadoLineaBase_Fin = round((floatval($LineaBaseV1) / floatval($LineaBaseV2))*100, 2);
                    }
                    break;
            }
    
            if (abs(abs(floatval($MetaAnual)) - abs($ResultadoMeta_Fin)) <= 0.01){
            }else{
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "FÓRMULA META ANUAL", "REVISAR VALOR - EXISTEN DIFERENCIAS", $MetaAnual, $ResultadoMeta_Fin);
                // echo "FIN- Meta Anual Original = $MetaAnual";
                // echo "FIN- Resultado Meta Anual = $ResultadoMeta_Fin";
                $MetaAnual_Fin = $ResultadoMeta_Fin;
            }
    
            if (abs(abs(floatval($LineaBase)) - abs($ResultadoLineaBase_Fin)) <= 0.01){
            }else{
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE", "REVISAR VALOR - EXISTEN DIFERENCIAS", $LineaBase, $ResultadoLineaBase_Fin);
                $LineaBase_Fin = $ResultadoLineaBase_Fin;
            }
        }

        $array_fin =  [
            "ResultadoMeta_Fin" => $ResultadoMeta_Fin,
            "ResultadoLineaBase_Fin" => $ResultadoLineaBase_Fin,
            "MetaAnual_Fin" => $MetaAnual_Fin,
            "LineaBase_Fin" => $LineaBase_Fin,
        ];
        array_push($array,$array_fin);
    
        // F O R M U L A S   D E   P R O P O S I T O
        $valida_proposito = $this->validaProposito($consecutivo, $proposito);
        $ResultadoMeta_Proposito = 0;
        $ResultadoLineaBase_Proposito = 0;
        $MetaAnual_Proposito = 0;
        $LineaBase_Proposito = 0;
        if ($valida_proposito == 1){
            $idelemento_carga = "P";
            $seccion_carga = "PROPÓSITO";
            $numero = substr($proposito->TipoFormula, 0, 1);
            $signo = substr($proposito->TipoFormula, 1, 1);
    
            $Denominador = $proposito->ValorDenominador;
            $Numerador = $proposito->ValorNumerador;
            $Numerador = str_replace(",", "", $Numerador);
            $Denominador = str_replace(",", "", $Denominador);
            $LineaBaseV1 = $proposito->LineaBaseV1;
            $LineaBaseV2 = $proposito->LineaBaseV2;
            $LineaBaseV1 = str_replace(",", "", $LineaBaseV1);
            $LineaBaseV2 = str_replace(",", "", $LineaBaseV2);
            $MetaAnual = $proposito->MetaAnualOriginal;
            $LineaBase = $proposito->LineaBaseOriginal;
            //echo "PROPóSITO";
            switch ($numero) {
                case 1:
                    if ($signo == "-"){
                        //((V1 - V2)/V2)*100
                        if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 2 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Denominador, "");
                        }else{
                            $ResultadoMeta_Proposito = round(((floatval($Numerador) - floatval($Denominador)) / floatval($Denominador)) * 100, 2);
                        }
    
                        if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                        }else{
                            $ResultadoLineaBase_Proposito = round(((floatval($LineaBaseV1) - floatval($LineaBaseV2)) / floatval($LineaBaseV2)) * 100, 2);
                            // echo "PROPOSITO LINEA BASE V1: $LineaBaseV1";
                            // echo "PROPOSITO LINEA BASE V2: $LineaBaseV2";
                            // $Tempo = floatval($LineaBaseV1) - floatval($LineaBaseV2);
                            // echo "PROPOSITO V1 - V2: $Tempo";
                            // $Tempo = $Tempo / floatval($LineaBaseV2);
                            // echo "PROPOSITO TEMPO / V2: $Tempo";
                            // echo "PROPOSITO RESULTADO LINEA BASE: $ResultadoLineaBase_Proposito";
                        }
                    }else{
                        //((V1 + V2)/V2)*100
                        if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 2 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Denominador, "");
                        }else{
                            $ResultadoMeta_Proposito = round(((floatval($Numerador) + floatval($Denominador)) / floatval($Denominador)) * 100, 2);
                        }
    
                        if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                        }else{
                            $ResultadoLineaBase_Proposito = round(((floatval($LineaBaseV1) + floatval($LineaBaseV2)) / floatval($LineaBaseV2)) * 100, 2);
                        }
                    }
                    break;
                case 2:
                    if ($signo == "-"){
                        //((V1 - V2)/V1)*100
                        if ($Numerador == "" || $Numerador == "-" || $Numerador == "0" || $Numerador == "0.00" || $Numerador == 0 || $Numerador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (NUMERADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                        }else{
                            $ResultadoMeta_Proposito = round(((floatval($Numerador) - floatval($Denominador)) / floatval($Numerador)) * 100, 2);
                        }
    
                        if ($LineaBaseV1 == "" || $LineaBaseV1 == "-" || $LineaBaseV1 == "0" || $LineaBaseV1 == "0.00" || $LineaBaseV1 == 0 || $LineaBaseV1 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV1, "");
                        }else{
                            $ResultadoLineaBase_Proposito = round(((floatval($LineaBaseV1) - floatval($LineaBaseV2)) / floatval($LineaBaseV1)) * 100, 2);
                        }
                    }else{
                        //((V1 + V2)/V1)*100
                        if ($Numerador == "" || $Numerador == "-" || $Numerador == "0" || $Numerador == "0.00" || $Numerador == 0 || $Numerador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (NUMERADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                        }else{
                            $ResultadoMeta_Proposito = round(((floatval($Numerador) + floatval($Denominador) / floatval($Numerador))) * 100, 2);
                        }
    
                        if ($LineaBaseV1 == "" || $LineaBaseV1 == "-" || $LineaBaseV1 == "0" || $LineaBaseV1 == "0.00" || $LineaBaseV1 == 0 || $LineaBaseV1 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV1, "");
                        }else{
                            $ResultadoLineaBase_Proposito = round(((floatval($LineaBaseV1) + floatval($LineaBaseV2) / floatval($LineaBaseV1))) * 100, 2);
                        }
                    }
                    break;
                case 3:
                    //V1/V2
                    if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                    }else{
                        $ResultadoMeta_Proposito = round(floatval($Numerador) / floatval($Denominador), 2);
                    }
    
                    if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                    }else{
                        $ResultadoLineaBase_Proposito = round(floatval($LineaBaseV1) / floatval($LineaBaseV2), 2);
                    }
                    break;
                case 4:
                    //(V1/V2)*100
                    if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                    }else{
                        $ResultadoMeta_Proposito = round((floatval($Numerador) / floatval($Denominador))*100, 2);
                    }
    
                    if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                    }else{
                        $ResultadoLineaBase_Proposito = round((floatval($LineaBaseV1) / floatval($LineaBaseV2))*100, 2);
                    }
                    break;
            }
    
            if (abs(abs(floatval($MetaAnual)) - abs($ResultadoMeta_Proposito)) <= 0.01){
            }else{
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "FÓRMULA META ANUAL", "REVISAR VALOR - EXISTEN DIFERENCIAS", $MetaAnual, $ResultadoMeta_Proposito);
                $MetaAnual_Proposito = $ResultadoMeta_Proposito;
            }
    
            if (abs(abs(floatval($LineaBase)) - abs($ResultadoLineaBase_Proposito)) <= 0.01){
            }else{
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE", "REVISAR VALOR - EXISTEN DIFERENCIAS", $LineaBase, $ResultadoLineaBase_Proposito);
                $LineaBase_Proposito = $ResultadoLineaBase_Proposito;
            }
        }
        $array_propsito = array (
            "ResultadoMeta_Fin" => $ResultadoMeta_Proposito,
            "ResultadoLineaBase_Fin" => $ResultadoLineaBase_Proposito,
            "MetaAnual_Fin" => $MetaAnual_Proposito,
            "LineaBase_Fin" => $LineaBase_Proposito,
        );
        array_push($array,$array_propsito);
    
        // F O R M U L A S   D E   C O M P O N E N T E S
        $ResultadoLineaBase_Componente = 0;
        for ($i=0; $i < count($componentes); $i++) { 
            $componente = $componentes[$i];
            $id_componente = $componente->idComponente;
            $valida_componente = $this->validaComponente($consecutivo, $id_componente, $componente);
    
            // Validaciones de formulas
            if ($valida_componente == 1){
                $idelemento_carga = $id_componente;
                $seccion_carga = "COMPONENTE ".$id_componente;
                $numero = substr($componente->TipoFormula, 0, 1);
                $signo = substr($componente->TipoFormula, 1, 1);
    
                $Denominador = $componente->ValorDenominador;
                $Numerador = $componente->ValorNumerador;
                $Numerador = str_replace(",", "", $Numerador);
                $Denominador = str_replace(",", "", $Denominador);
                $LineaBaseV1 = $componente->LineaBaseV1;
                $LineaBaseV2 = $componente->LineaBaseV2;
                $LineaBaseV1 = str_replace(",", "", $LineaBaseV1);
                $LineaBaseV2 = str_replace(",", "", $LineaBaseV2);
                $MetaAnual = $componente->MetaAnual;
                $LineaBase = $componente->LineaBase;
                $Frecuencia = $componente->Frecuencia;
                $Semestre1V1 = $componente->Semestre1V1;
                $Semestre1V2 = $componente->Semestre1V2;
                $Semestre2V1 = $componente->Semestre2V1;
                $Semestre2V2 = $componente->Semestre2V2;
                $Semestre1V1 = str_replace(",", "", $Semestre1V1);
                $Semestre1V2 = str_replace(",", "", $Semestre1V2);
                $Semestre2V1 = str_replace(",", "", $Semestre2V1);
                $Semestre2V2 = str_replace(",", "", $Semestre2V2);
                //
                $MetaTrimestre4 = $componente->MetaTrimestre4; //Deciía MEtaTrimestre4
                $Trimestre1V1 = $componente->Trimestre1V1;
                $Trimestre2V1 = $componente->Trimestre2V1;
                $Trimestre3V1 = $componente->Trimestre3V1;
                $Trimestre4V1 = $componente->Trimestre4V1;
                $Trimestre1V2 = $componente->Trimestre1V2;
                $Trimestre2V2 = $componente->Trimestre2V2;
                $Trimestre3V2 = $componente->Trimestre3V2;
                $Trimestre4V2 = $componente->Trimestre4V2;
                $Trimestre1V1 = str_replace(",", "", $Trimestre1V1);
                $Trimestre2V1 = str_replace(",", "", $Trimestre2V1);
                $Trimestre3V1 = str_replace(",", "", $Trimestre3V1);
                $Trimestre4V1 = str_replace(",", "", $Trimestre4V1);
                $Trimestre1V2 = str_replace(",", "", $Trimestre1V2);
                $Trimestre2V2 = str_replace(",", "", $Trimestre2V2);
                $Trimestre3V2 = str_replace(",", "", $Trimestre3V2);
                $Trimestre4V2 = str_replace(",", "", $Trimestre4V2);
                //
                $MetaAnualOriginal_Comp = $componente->MetaAnualOriginal;
                $LineaBaseOriginal_Comp = $componente->LineaBaseOriginal;      
                $ValorNumeradorOriginal_Comp = $componente->ValorNumeradorOriginal; 
                $ValorDenominadorOriginal_Comp = $componente->ValorDenominadorOriginal;    
                //     
                $MetaAnualOriginal_Comp = str_replace(",", "", $MetaAnualOriginal_Comp);
                $LineaBaseOriginal_Comp = str_replace(",", "", $LineaBaseOriginal_Comp);
                $ValorNumeradorOriginal_Comp = str_replace(",", "", $ValorNumeradorOriginal_Comp);
                $ValorDenominadorOriginal_Comp = str_replace(",", "", $ValorDenominadorOriginal_Comp);

                $ResultadoMeta_Componente = 0;
                $ResultadoLineaBase_Componente = 0;
                $Resultado_MetaSemestral1 = 0;
                $Resultado_MetaSemestral2 = 0;
                $Resultado_MetaTrimestral1 = 0;
                $Resultado_MetaTrimestral2 = 0;
                $Resultado_MetaTrimestral3 = 0;
                $Resultado_MetaTrimestral4 = 0;
               
                //echo "COMPONENTES: COMPONENTE [" . $componente . "]";
                switch ($numero) {
                    case 1:
                        if ($signo == "-"){
                            //((V1 - V2)/V2)*100
                            if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 2 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Denominador, "");
                            }else{
                                $ResultadoMeta_Componente = round(((floatval($Numerador) - floatval($Denominador)) / floatval($Denominador)) * 100, 2);
                            }
    
                            if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                            }else{
                                $ResultadoLineaBase_Componente = round(((floatval($LineaBaseV1) - floatval($LineaBaseV2)) / floatval($LineaBaseV2)) * 100, 2);
                            }
    
                            if ($Frecuencia == "SEMESTRAL"){
                                if ($Semestre1V1 == "" || $Semestre1V1 == "-" || $Semestre1V1 == "0" || $Semestre1V1 == "0.00" || $Semestre1V1 == 0 || $Semestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V1, "");
                                } else if ($Semestre1V2 == "" || $Semestre1V2 == "-" || $Semestre1V2 == "0" || $Semestre1V2 == "0.00" || $Semestre1V2 == 0 || $Semestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V2, "");
                                } else{
                                    $Resultado_MetaSemestral1 = round(((floatval($Semestre1V1) - floatval($Semestre1V2)) / floatval($Semestre1V2)) * 100, 2);
                                }
    
                                if ($Semestre2V1 == "" || $Semestre2V1 == "-" || $Semestre2V1 == "0" || $Semestre2V1 == "0.00" || $Semestre2V1 == 0 || $Semestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V1, "");
                                } else if ($Semestre2V2 == "" || $Semestre2V2 == "-" || $Semestre2V2 == "0" || $Semestre2V2 == "0.00" || $Semestre2V2 == 0 || $Semestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V2, "");
                                } else{
                                    $Resultado_MetaSemestral2 = round(((floatval($Semestre2V1) - floatval($Semestre2V2)) / floatval($Semestre2V2)) * 100, 2);
                                }
                            }
                            else {
                                //Trimestre 1
                                if ($Trimestre1V1 == "" || $Trimestre1V1 == "-" || $Trimestre1V1 == "0" || $Trimestre1V1 == "0.00" || $Trimestre1V1 == 0 || $Trimestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V1, "");
                                } else if ($Trimestre1V2 == "" || $Trimestre1V2 == "-" || $Trimestre1V2 == "0" || $Trimestre1V2 == "0.00" || $Trimestre1V2 == 0 || $Trimestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V2, "");
                                } else{
                                    $Resultado_MetaTrimestral1 = round(((floatval($Trimestre1V1) - floatval($Trimestre1V2)) / floatval($Trimestre1V2)) * 100, 2);
                                }
                                //Trimestre 2
                                if ($Trimestre2V1 == "" || $Trimestre2V1 == "-" || $Trimestre2V1 == "0" || $Trimestre2V1 == "0.00" || $Trimestre2V1 == 0 || $Trimestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V1, "");
                                } else if ($Trimestre2V2 == "" || $Trimestre2V2 == "-" || $Trimestre2V2 == "0" || $Trimestre2V2 == "0.00" || $Trimestre2V2 == 0 || $Trimestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V2, "");
                                } else{
                                    $Resultado_MetaTrimestral2 = round(((floatval($Trimestre2V1) - floatval($Trimestre2V2)) / floatval($Trimestre2V2)) * 100, 2);
                                }
                                //Trimestre 3
                                if ($Trimestre3V1 == "" || $Trimestre3V1 == "-" || $Trimestre3V1 == "0" || $Trimestre3V1 == "0.00" || $Trimestre3V1 == 0 || $Trimestre3V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V1, "");
                                } else if ($Trimestre3V2 == "" || $Trimestre3V2 == "-" || $Trimestre3V2 == "0" || $Trimestre3V2 == "0.00" || $Trimestre3V2 == 0 || $Trimestre3V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V2, "");
                                } else{
                                    $Resultado_MetaTrimestral3 = round(((floatval($Trimestre3V1) - floatval($Trimestre3V2)) / floatval($Trimestre3V2)) * 100, 2);
                                }
                                //Trimestre 4
                                if ($Trimestre4V1 == "" || $Trimestre4V1 == "-" || $Trimestre4V1 == "0" || $Trimestre4V1 == "0.00" || $Trimestre4V1 == 0 || $Trimestre4V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 4 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V1, "");
                                } else if ($Trimestre4V2 == "" || $Trimestre4V2 == "-" || $Trimestre4V2 == "0" || $Trimestre4V2 == "0.00" || $Trimestre4V2 == 0 || $Trimestre4V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 4 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V2, "");
                                } else{
                                    $Resultado_MetaTrimestral4 = round(((floatval($Trimestre4V1) - floatval($Trimestre4V2)) / floatval($Trimestre4V2)) * 100, 2);
                                }
    
                            }
                        }else{
                            //((V1 + V2)/V2)*100
                            if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 2 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Denominador, "");
                            }else{
                                $ResultadoMeta_Componente = round(((floatval($Numerador) + floatval($Denominador)) / floatval($Denominador)) * 100, 2);
                            }
    
                            if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                            }else{
                                $ResultadoLineaBase_Componente = round(((floatval($LineaBaseV1) + floatval($LineaBaseV2)) / floatval($LineaBaseV2)) * 100, 2);
                            }
                            if ($Frecuencia == "SEMESTRAL"){
                                if ($Semestre1V1 == "" || $Semestre1V1 == "-" || $Semestre1V1 == "0" || $Semestre1V1 == "0.00" || $Semestre1V1 == 0 || $Semestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V1, "");
                                } else if ($Semestre1V2 == "" || $Semestre1V2 == "-" || $Semestre1V2 == "0" || $Semestre1V2 == "0.00" || $Semestre1V2 == 0 || $Semestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V2, "");
                                } else{
                                    $Resultado_MetaSemestral1 = round(((floatval($Semestre1V1) + floatval($Semestre1V2)) / floatval($Semestre1V2)) * 100, 2);
                                }
    
                                if ($Semestre2V1 == "" || $Semestre2V1 == "-" || $Semestre2V1 == "0" || $Semestre2V1 == "0.00" || $Semestre2V1 == 0 || $Semestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V1, "");
                                } else if ($Semestre2V2 == "" || $Semestre2V2 == "-" || $Semestre2V2 == "0" || $Semestre2V2 == "0.00" || $Semestre2V2 == 0 || $Semestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V2, "");
                                } else{
                                    $Resultado_MetaSemestral2 = round(((floatval($Semestre2V1) + floatval($Semestre2V2)) / floatval($Semestre2V2)) * 100, 2);
                                }
                            }
                            else {
                                //Trimestre 1
                                if ($Trimestre1V1 == "" || $Trimestre1V1 == "-" || $Trimestre1V1 == "0" || $Trimestre1V1 == "0.00" || $Trimestre1V1 == 0 || $Trimestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V1, "");
                                } else if ($Trimestre1V2 == "" || $Trimestre1V2 == "-" || $Trimestre1V2 == "0" || $Trimestre1V2 == "0.00" || $Trimestre1V2 == 0 || $Trimestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V2, "");
                                } else{
                                    $Resultado_MetaTrimestral1 = round(((floatval($Trimestre1V1) + floatval($Trimestre1V2)) / floatval($Trimestre1V2)) * 100, 2);
                                }
                                //Trimestre 2
                                if ($Trimestre2V1 == "" || $Trimestre2V1 == "-" || $Trimestre2V1 == "0" || $Trimestre2V1 == "0.00" || $Trimestre2V1 == 0 || $Trimestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V1, "");
                                } else if ($Trimestre2V2 == "" || $Trimestre2V2 == "-" || $Trimestre2V2 == "0" || $Trimestre2V2 == "0.00" || $Trimestre2V2 == 0 || $Trimestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V2, "");
                                } else{
                                    $Resultado_MetaTrimestral2 = round(((floatval($Trimestre2V1) + floatval($Trimestre2V2)) / floatval($Trimestre2V2)) * 100, 2);
                                }
                                //Trimestre 3
                                if ($Trimestre3V1 == "" || $Trimestre3V1 == "-" || $Trimestre3V1 == "0" || $Trimestre3V1 == "0.00" || $Trimestre3V1 == 0 || $Trimestre3V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V1, "");
                                } else if ($Trimestre3V2 == "" || $Trimestre3V2 == "-" || $Trimestre3V2 == "0" || $Trimestre3V2 == "0.00" || $Trimestre3V2 == 0 || $Trimestre3V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V2, "");
                                } else{
                                    $Resultado_MetaTrimestral3 = round(((floatval($Trimestre3V1) + floatval($Trimestre3V2)) / floatval($Trimestre3V2)) * 100, 2);
                                }
                                //Trimestre 4
                                if ($Trimestre4V1 == "" || $Trimestre4V1 == "-" || $Trimestre4V1 == "0" || $Trimestre4V1 == "0.00" || $Trimestre4V1 == 0 || $Trimestre4V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 4 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V1, "");
                                } else if ($Trimestre4V2 == "" || $Trimestre4V2 == "-" || $Trimestre4V2 == "0" || $Trimestre4V2 == "0.00" || $Trimestre4V2 == 0 || $Trimestre4V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 4 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V2, "");
                                } else{
                                    $Resultado_MetaTrimestral4 = round(((floatval($Trimestre4V1) + floatval($Trimestre4V2)) / floatval($Trimestre4V2)) * 100, 2);
                                }
                            }
                        }
                        break;
                    case 2:
                        if ($signo == "-"){
                            //((V1 - V2)/V1)*100
                            if ($Numerador == "" || $Numerador == "-" || $Numerador == "0" || $Numerador == "0.00" || $Numerador == 0 || $Numerador == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (NUMERADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                            }else{
                                $ResultadoMeta_Componente = round(((floatval($Numerador) - floatval($Denominador)) / floatval($Numerador)) * 100, 2);
                            }
    
                            if ($LineaBaseV1 == "" || $LineaBaseV1 == "-" || $LineaBaseV1 == "0" || $LineaBaseV1 == "0.00" || $LineaBaseV1 == 0 || $LineaBaseV1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV1, "");
                            }else{
                                $ResultadoLineaBase_Componente = round(((floatval($LineaBaseV1) - floatval($LineaBaseV2)) / floatval($LineaBaseV1)) * 100, 2);
                            }
                            if ($Frecuencia == "SEMESTRAL"){
                                if ($Semestre1V1 == "" ||$Semestre1V1 == "-" ||$Semestre1V1 == "0" || $Semestre1V1 == "0.00" || $Semestre1V1 == 0 || $Semestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V1, "");
                                } else if ($Semestre1V2 == "" || $Semestre1V2 == "-" || $Semestre1V2 == "0" || $Semestre1V2 == "0.00" || $Semestre1V2 == 0 || $Semestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V2, "");
                                } else{
                                    $Resultado_MetaSemestral1 = round(((floatval($Semestre1V1) - floatval($Semestre1V2)) / floatval($Semestre1V1)) * 100, 2);
                                }
    
                                if ($Semestre2V1 == "" || $Semestre2V1 == "-" || $Semestre2V1 == "0" || $Semestre2V1 == "0.00" || $Semestre2V1 == 0 || $Semestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V1, "");
                                } else if ($Semestre2V2 == "" || $Semestre2V2 == "-" || $Semestre2V2 == "0" || $Semestre2V2 == "0.00" || $Semestre2V2 == 0 || $Semestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V2, "");
                                } else{
                                    $Resultado_MetaSemestral2 = round(((floatval($Semestre2V1) - floatval($Semestre2V2)) / floatval($Semestre2V1)) * 100, 2);
                                }
                            }
                            else {
                                //Trimestre 1
                                if ($Trimestre1V1 == "" || $Trimestre1V1 == "-" || $Trimestre1V1 == "0" || $Trimestre1V1 == "0.00" || $Trimestre1V1 == 0 || $Trimestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V1, "");
                                } else if ($Trimestre1V2 == "" || $Trimestre1V2 == "-" || $Trimestre1V2 == "0" || $Trimestre1V2 == "0.00" || $Trimestre1V2 == 0 || $Trimestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V2, "");
                                } else{
                                    $Resultado_MetaTrimestral1 = round(((floatval($Trimestre1V1) - floatval($Trimestre1V2)) / floatval($Trimestre1V1)) * 100, 2);
                                }
                                //Trimestre 2
                                if ($Trimestre2V1 == "" || $Trimestre2V1 == "-" || $Trimestre2V1 == "0" || $Trimestre2V1 == "0.00" || $Trimestre2V1 == 0 || $Trimestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V1, "");
                                } else if ($Trimestre2V2 == "" || $Trimestre2V2 == "-" || $Trimestre2V2 == "0" || $Trimestre2V2 == "0.00" || $Trimestre2V2 == 0 || $Trimestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V2, "");
                                } else{
                                    $Resultado_MetaTrimestral2 = round(((floatval($Trimestre2V1) - floatval($Trimestre2V2)) / floatval($Trimestre2V1)) * 100, 2);
                                }
                                //Trimestre 3
                                if ($Trimestre3V1 == "" || $Trimestre3V1 == "-" || $Trimestre3V1 == "0" || $Trimestre3V1 == "0.00" || $Trimestre3V1 == 0 || $Trimestre3V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V1, "");
                                } else if ($Trimestre3V2 == "" || $Trimestre3V2 == "-" || $Trimestre3V2 == "0" || $Trimestre3V2 == "0.00" || $Trimestre3V2 == 0 || $Trimestre3V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V2, "");
                                } else{
                                    $Resultado_MetaTrimestral3 = round(((floatval($Trimestre3V1) - floatval($Trimestre3V2)) / floatval($Trimestre3V1)) * 100, 2);
                                }
                                //Trimestre 4
                                if ($Trimestre4V1 == "" || $Trimestre4V1 == "-" || $Trimestre4V1 == "0" || $Trimestre4V1 == "0.00" || $Trimestre4V1 == 0 || $Trimestre4V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V1, "");
                                } else if ($Trimestre4V2 == "" || $Trimestre4V2 == "-" || $Trimestre4V2 == "0" || $Trimestre4V2 == "0.00" || $Trimestre4V2 == 0 || $Trimestre4V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V2, "");
                                } else{
                                    $Resultado_MetaTrimestral4 = round(((floatval($Trimestre4V1) - floatval($Trimestre4V2)) / floatval($Trimestre4V1)) * 100, 2);
                                }
    
                            }
                        }else{
                            //((V1 + V2)/V1)*100       
                            if ($Numerador == "" || $Numerador == "-" || $Numerador == "0" || $Numerador == "0.00" || $Numerador == 0 || $Numerador == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (NUMERADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                            }else{
                                $ResultadoMeta_Componente = round(((floatval($Numerador) + floatval($Denominador)) / floatval($Numerador)) * 100, 2);
                            }
    
                            if ($LineaBaseV1 == "" || $LineaBaseV1 == "-" || $LineaBaseV1 == "0" || $LineaBaseV1 == "0.00" || $LineaBaseV1 == 0 || $LineaBaseV1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV1, "");
                            }else{
                                $ResultadoLineaBase_Componente = round(((floatval($LineaBaseV1) + floatval($LineaBaseV2)) / floatval($LineaBaseV1)) * 100, 2);
                            }
                            if ($Frecuencia == "SEMESTRAL"){
                                if ($Semestre1V1 == "" || $Semestre1V1 == "-" || $Semestre1V1 == "0" || $Semestre1V1 == "0.00" || $Semestre1V1 == 0 || $Semestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V1, "");
                                } else if ($Semestre1V2 == "" || $Semestre1V2 == "-" || $Semestre1V2 == "0" || $Semestre1V2 == "0.00" || $Semestre1V2 == 0 || $Semestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V2, "");
                                } else{
                                    $Resultado_MetaSemestral1 = round(((floatval($Semestre1V1) + floatval($Semestre1V2)) / floatval($Semestre1V1)) * 100, 2);
                                }
    
                                if ($Semestre2V1 == "" || $Semestre2V1 == "-" || $Semestre2V1 == "0" || $Semestre2V1 == "0.00" || $Semestre2V1 == 0 || $Semestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V1, "");
                                } else if ($Semestre2V2 == "" || $Semestre2V2 == "-" || $Semestre2V2 == "0" || $Semestre2V2 == "0.00" || $Semestre2V2 == 0 || $Semestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V2, "");
                                } else{
                                    $Resultado_MetaSemestral2 = round(((floatval($Semestre2V1) + floatval($Semestre2V2)) / floatval($Semestre2V1)) * 100, 2);
                                }
                            }
                            else {
                                //Trimestre 1
                                if ($Trimestre1V1 == "" || $Trimestre1V1 == "-" || $Trimestre1V1 == "0" || $Trimestre1V1 == "0.00" || $Trimestre1V1 == 0 || $Trimestre1V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V1, "");
                                } else if ($Trimestre1V2 == "0" || $Trimestre1V2 == "0.00" || $Trimestre1V2 == 0 || $Trimestre1V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V2, "");
                                } else{
                                    $Resultado_MetaTrimestral1 = round(((floatval($Trimestre1V1) + floatval($Trimestre1V2)) / floatval($Trimestre1V1)) * 100, 2);
                                }
                                //Trimestre 2
                                if ($Trimestre2V1 == "" || $Trimestre2V1 == "-" || $Trimestre2V1 == "0" || $Trimestre2V1 == "0.00" || $Trimestre2V1 == 0 || $Trimestre2V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V1, "");
                                } else if ($Trimestre2V2 == "" || $Trimestre2V2 == "-" || $Trimestre2V2 == "0" || $Trimestre2V2 == "0.00" || $Trimestre2V2 == 0 || $Trimestre2V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V2, "");
                                } else{
                                    $Resultado_MetaTrimestral2 = round(((floatval($Trimestre2V1) + floatval($Trimestre2V2)) / floatval($Trimestre2V1)) * 100, 2);
                                }
                                //Trimestre 3
                                if ($Trimestre3V1 == "" || $Trimestre3V1 == "-" || $Trimestre3V1 == "0" || $Trimestre3V1 == "0.00" || $Trimestre3V1 == 0 || $Trimestre3V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V1, "");
                                } else if ($Trimestre3V2 == "" || $Trimestre3V2 == "-" || $Trimestre3V2 == "0" || $Trimestre3V2 == "0.00" || $Trimestre3V2 == 0 || $Trimestre3V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V2, "");
                                } else{
                                    $Resultado_MetaTrimestral3 = round(((floatval($Trimestre3V1) + floatval($Trimestre3V2)) / floatval($Trimestre3V1)) * 100, 2);
                                }
                                //Trimestre 4
                                if ($Trimestre4V1 == "" || $Trimestre4V1 == "-" || $Trimestre4V1 == "0" || $Trimestre4V1 == "0.00" || $Trimestre4V1 == 0 || $Trimestre4V1 == 0.00){
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V1, "");
                                } else if ($Trimestre4V2 == "" || $Trimestre4V2 == "-" || $Trimestre4V2 == "0" || $Trimestre4V2 == "0.00" || $Trimestre4V2 == 0 || $Trimestre4V2 == 0.00) {
                                    $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V2, "");
                                } else{
                                    $Resultado_MetaTrimestral4 = round(((floatval($Trimestre4V1) + floatval($Trimestre4V2)) / floatval($Trimestre4V1)) * 100, 2);
                                }
                            }
                        }
                        break;
                    case 3:
                        //V1/V2
                        if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                        }else{
                            $ResultadoMeta_Componente = round(floatval($Numerador) / floatval($Denominador), 2);
                        }
    
                        if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                        }else{
                            $ResultadoLineaBase_Componente = round(floatval($LineaBaseV1) / floatval($LineaBaseV2), 2);
                        }
                        break;
                        if ($Frecuencia == "SEMESTRAL"){
                            if ($Semestre1V1 == "" || $Semestre1V1 == "-" || $Semestre1V1 == "0" || $Semestre1V1 == "0.00" || $Semestre1V1 == 0 || $Semestre1V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V1, "");
                            } else if ($Semestre1V2 == "" || $Semestre1V2 == "-" || $Semestre1V2 == "0" || $Semestre1V2 == "0.00" || $Semestre1V2 == 0 || $Semestre1V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V2, "");
                            } else{
                                $Resultado_MetaSemestral1 = round(floatval($Semestre1V1) / floatval($Semestre1V2), 2);
                            }
    
                            if ($Semestre2V1 == "" || $Semestre2V1 == "-" || $Semestre2V1 == "0" || $Semestre2V1 == "0.00" || $Semestre2V1 == 0 || $Semestre2V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V1, "");
                            } else if ($Semestre2V2 == "" || $Semestre2V2 == "-" || $Semestre2V2 == "0" || $Semestre2V2 == "0.00" || $Semestre2V2 == 0 || $Semestre2V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V2, "");
                            } else{
                                $Resultado_MetaSemestral2 = round(floatval($Semestre2V1) / floatval($Semestre2V2), 2);
                            }
                        }
                        else {
                            //Trimestre 1
                            if ($Trimestre1V1 == "" || $Trimestre1V1 == "-" || $Trimestre1V1 == "0" || $Trimestre1V1 == "0.00" || $Trimestre1V1 == 0 || $Trimestre1V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V1, "");
                            } else if ($Trimestre1V2 == "" || $Trimestre1V2 == "-" || $Trimestre1V2 == "0" || $Trimestre1V2 == "0.00" || $Trimestre1V2 == 0 || $Trimestre1V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V2, "");
                            } else{
                                $Resultado_MetaTrimestral1 = round(floatval($Trimestre1V1) / floatval($Trimestre1V2), 2);
                            }
                            //Trimestre 2
                            if ($Trimestre2V1 == "" || $Trimestre2V1 == "-" || $Trimestre2V1 == "0" || $Trimestre2V1 == "0.00" || $Trimestre2V1 == 0 || $Trimestre2V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V1, "");
                            } else if ($Trimestre2V2 == "0" || $Trimestre2V2 == "0.00" || $Trimestre2V2 == 0 || $Trimestre2V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V2, "");
                            } else{
                                $Resultado_MetaTrimestral2 = round(floatval($Trimestre2V1) / floatval($Trimestre2V2), 2);
                            }
                            //Trimestre 3
                            if ($Trimestre3V1 == "" || $Trimestre3V1 == "-" || $Trimestre3V1 == "0" || $Trimestre3V1 == "0.00" || $Trimestre3V1 == 0 || $Trimestre3V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V1, "");
                            } else if ($Trimestre3V2 == "" || $Trimestre3V2 == "-" || $Trimestre3V2 == "0" || $Trimestre3V2 == "0.00" || $Trimestre3V2 == 0 || $Trimestre3V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V2, "");
                            } else{
                                $Resultado_MetaTrimestral3 = round(floatval($Trimestre3V1) / floatval($Trimestre3V2), 2);
                            }
                            //Trimestre 4
                            if ($Trimestre4V1 == "" || $Trimestre4V1 == "-" || $Trimestre4V1 == "0" || $Trimestre4V1 == "0.00" || $Trimestre4V1 == 0 || $Trimestre4V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V1, "");
                            } else if ($Trimestre4V2 == "" || $Trimestre4V2 == "-" || $Trimestre4V2 == "0" || $Trimestre4V2 == "0.00" || $Trimestre4V2 == 0 || $Trimestre4V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V2, "");
                            } else{
                                $Resultado_MetaTrimestral4 = round(floatval($Trimestre4V1) / floatval($Trimestre4V2), 2);
                            }    
                        }
                    case 4:
                        //(V1/V2)*100
                        if ($Denominador == "" || $Denominador == "-" || $Denominador == "0" || $Denominador == "0.00" || $Denominador == 0 || $Denominador == 0.00){
                            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "VARIABLE 1 (DENOMINADOR)", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Numerador, "");
                        }else{
                            $ResultadoMeta_Componente = round((floatval($Numerador) / floatval($Denominador))*100, 2);
                        }
    
                        if ($LineaBaseV2 == "" || $LineaBaseV2 == "-" || $LineaBaseV2 == "0" || $LineaBaseV2 == "0.00" || $LineaBaseV2 == 0 || $LineaBaseV2 == 0.00){
                            // echo "Linea Base V1: $LineaBaseV1";
                            // echo "Linea BAse V2: $LineaBaseV2";
                           $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $LineaBaseV2, "");
                        }else{
                            // echo "Linea Base V1: $LineaBaseV1";
                            // echo "Linea BAse V2: $LineaBaseV2";
                            $ResultadoLineaBase_Componente = round((floatval($LineaBaseV1) / floatval($LineaBaseV2))*100, 2);
                        }
                        break;
                        if ($Frecuencia == "SEMESTRAL"){
                            if ($Semestre1V1 == "" || $Semestre1V1 == "-" || $Semestre1V1 == "0" || $Semestre1V1 == "0.00" || $Semestre1V1 == 0 || $Semestre1V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V1, "");
                            } else if ($Semestre1V2 == "" || $Semestre1V2 == "-" || $Semestre1V2 == "0" || $Semestre1V2 == "0.00" || $Semestre1V2 == 0 || $Semestre1V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre1V2, "");
                            } else{
                                $Resultado_MetaSemestral1 = round((floatval($Semestre1V1) / floatval($Semestre1V2))*100, 2);
                            }
    
                            if ($Semestre2V1 == "" || $Semestre2V1 == "-" || $Semestre2V1 == "0" || $Semestre2V1 == "0.00" || $Semestre2V1 == 0 || $Semestre2V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V1, "");
                            } else if ($Semestre2V2 == "" || $Semestre2V2 == "-" || $Semestre2V2 == "0" || $Semestre2V2 == "0.00" || $Semestre2V2 == 0 || $Semestre2V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Semestre2V2, "");
                            } else{
                                $Resultado_MetaSemestral2 = round((floatval($Semestre2V1) / floatval($Semestre2V2))*100, 2);
                            }
                        }
                        else {
                            //Trimestre 1
                            if ($Trimestre1V1 == "" || $Trimestre1V1 == "-" || $Trimestre1V1 == "0" || $Trimestre1V1 == "0.00" || $Trimestre1V1 == 0 || $Trimestre1V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V1, "");
                            } else if ($Trimestre1V2 == "" || $Trimestre1V2 == "-" || $Trimestre1V2 == "0" || $Trimestre1V2 == "0.00" || $Trimestre1V2 == 0 || $Trimestre1V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre1V2, "");
                            } else{
                                $Resultado_MetaTrimestral1 = round((floatval($Trimestre1V1) / floatval($Trimestre1V2))*100, 2);
                            }
                            //Trimestre 2
                            if ($Trimestre2V1 == "" || $Trimestre2V1 == "-" || $Trimestre2V1 == "0" || $Trimestre2V1 == "0.00" || $Trimestre2V1 == 0 || $Trimestre2V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V1, "");
                            } else if ($Trimestre2V2 == "" || $Trimestre2V2 == "-" || $Trimestre2V2 == "0" || $Trimestre2V2 == "0.00" || $Trimestre2V2 == 0 || $Trimestre2V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre2V2, "");
                            } else{
                                $Resultado_MetaTrimestral2 = round((floatval($Trimestre2V1) / floatval($Trimestre2V2))*100, 2);
                            }
                            //Trimestre 3
                            if ($Trimestre3V1 == "" || $Trimestre3V1 == "-" || $Trimestre3V1 == "0" || $Trimestre3V1 == "0.00" || $Trimestre3V1 == 0 || $Trimestre3V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V1, "");
                            } else if ($Trimestre3V2 == "" || $Trimestre3V2 == "-" || $Trimestre3V2 == "0" || $Trimestre3V2 == "0.00" || $Trimestre3V2 == 0 || $Trimestre3V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre3V2, "");
                            } else{
                                $Resultado_MetaTrimestral3 = round((floatval($Trimestre3V1) / floatval($Trimestre3V2))*100, 2);
                            }
                            //Trimestre 4
                            if ($Trimestre4V1 == "" || $Trimestre4V1 == "-" || $Trimestre4V1 == "0" || $Trimestre4V1 == "0.00" || $Trimestre4V1 == 0 || $Trimestre4V1 == 0.00){
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 1", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V1, "");
                            } else if ($Trimestre4V2 == "0" || $Trimestre4V2 == "0.00" || $Trimestre4V2 == 0 || $Trimestre4V2 == 0.00) {
                                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1 VARIABLE 2", "NO PUEDE REALIZARSE LA OPERACIÓN CON CERO (0)", $Trimestre4V2, "");
                            } else{
                                $Resultado_MetaTrimestral4 = round((floatval($Trimestre4V1) / floatval($Trimestre4V2))*100, 2);
                            }
                        }
                }
                // APLICAR LA FORMULA Y VALIDAR
                $MetaAnualOriginal_Comp = floatval($MetaAnualOriginal_Comp);
                $LineaBaseOriginal_Comp = floatval($LineaBaseOriginal_Comp);
                $ValorNumeradorOriginal_Comp = floatval($ValorNumeradorOriginal_Comp);
                $ValorDenominadorOriginal_Comp = floatval($ValorDenominadorOriginal_Comp);
                if ($Frecuencia == "SEMESTRAL"){
                    //META ANUAL
                    // echo "Meta Anual Original Comp = $MetaAnualOriginal_Comp";
                    // echo "Resultado Meta Comp = $ResultadoMeta_Componente";
                    // $Total = $MetaAnualOriginal_Comp - $ResultadoMeta_Componente;
                    // echo "Total = $Total";
                    if ($MetaAnualOriginal_Comp - $ResultadoMeta_Componente <= 0.01) {
    
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "META ANUAL", "REVISAR VALOR - EXISTEN DIFERENCIAS", $MetaAnualOriginal_Comp, $ResultadoMeta_Componente);
                    }
                    //LÏNEA BASE
                    if ($LineaBaseOriginal_Comp - $ResultadoLineaBase_Componente <= 0.01) {
    
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE", "REVISAR VALOR - EXISTEN DIFERENCIAS", $LineaBaseOriginal_Comp, $ResultadoLineaBase_Componente);
                    }
                    //META v1
                    if ($ValorNumeradorOriginal_Comp - $Resultado_MetaSemestral1 <= 0.01) {
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "META ANUAL V1", "REVISAR VALOR - EXISTEN DIFERENCIAS", $ValorNumeradorOriginal_Comp, $Resultado_MetaSemestral1);
                    }
                    //META V2
                    if ($ValorDenominadorOriginal_Comp - $Resultado_MetaSemestral2 <= 0.01) {
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "META ANUAL V2", "REVISAR VALOR - EXISTEN DIFERENCIAS", $ValorDenominadorOriginal_Comp, $Resultado_MetaSemestral2);
                    }
                }
                else {
                    //FRECUENCIA TRIMESTRAL
                    //META ANUAL
                    // echo "Meta Anual Original = $MetaAnualOriginal_Comp";
                    // echo "Meta Trimestre 4 = $MetaTrimestre4";
                    // echo "ResultadoLineaBase_Componente = $ResultadoLineaBase_Componente";
                    if ($MetaAnualOriginal_Comp - $MetaTrimestre4 <= 0.01) {
    
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "META ANUAL", "REVISAR VALOR - EXISTEN DIFERENCIAS", $MetaAnualOriginal_Comp, $MetaTrimestre4);
                    }
                    //LÏNEA BASE
                    if ($LineaBaseOriginal_Comp - $ResultadoLineaBase_Componente <= 0.01) {
    
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE", "REVISAR VALOR - EXISTEN DIFERENCIAS", $LineaBaseOriginal_Comp, $ResultadoLineaBase_Componente);
                    }
                    //META v1
                    if ($ValorNumeradorOriginal_Comp - (floatval($Trimestre1V1)+floatval($Trimestre2V1)+floatval($Trimestre3V1)+floatval($Trimestre4V1)) <= 0.01) {
                        // $tempo = floatval($Trimestre1V1)+floatval($Trimestre2V1)+floatval($Trimestre3V1)+floatval($Trimestre4V1);
                        // echo "Suma de Trimestres V1 = $tempo";
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "META ANUAL V1", "REVISAR VALOR - EXISTEN DIFERENCIAS", $ValorNumeradorOriginal_Comp, floatval($Trimestre1V1)+floatval($Trimestre2V1)+floatval($Trimestre3V1)+floatval($Trimestre4V1));
                    }
                    //META V2
                    if ($ValorDenominadorOriginal_Comp - (floatval($Trimestre1V2)+floatval($Trimestre2V2)+floatval($Trimestre3V2)+floatval($Trimestre4V2)) <= 0.01) {
                        // $tempo2 = floatval($Trimestre1V1)+floatval($Trimestre2V1)+floatval($Trimestre3V1)+floatval($Trimestre4V1);
                        // echo "Suma de Trimestres V2 = $tempo2";
                    }
                    else {
                        $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "META ANUAL V2", "REVISAR VALOR - EXISTEN DIFERENCIAS", $ValorDenominadorOriginal_Comp, floatval($Trimestre1V2)+floatval($Trimestre2V2)+floatval($Trimestre3V2)+floatval($Trimestre4V2));
                    }
                }
    
            }
    
            $actividades_componente = $this->actividadescomponente_validar($consecutivo, $id_componente);
            for ($j = 0; $j < count($actividades_componente); $j++){
                $actividad = $actividades_componente[$j];
                $id_elemento = $actividad->idActividad;
                $valida_actividad = $this->validaActividad($consecutivo, $id_elemento, $actividad);
    
                //echo "ACTIVIDADES: ACTIVIDAD [" . $id_elemento . "]";
                if ($valida_actividad == 1){
                    $idelemento_carga = $id_elemento;
                    $seccion_carga = "ACTIVIDAD ".$id_elemento;
                    $numero = substr($actividad->TipoFormula, 0, 1);
                    $signo = substr($actividad->TipoFormula, 1, 1);
                }
            }
        }
    
        /*
        for ($i=0; $i < count($actividades["data"]); $i++) { 
            $actividad = $actividades["data"][$i];
            $id_elemento = $componente["idComponente"];
            $valida_componente = $this->validaActividad($consecutivo, $id_elemento, $actividades);
        }
        */
        return response()->json(array('error' => false, 'result' => 'Información validada correctamente.', 'code' => 200));
    }

    public function addCarga($consecutivo, $id_elemento, $seccion, $elemento, $descripcion){
        try {
            $insert                 = new LogCarga;
            $insert->Consecutivo    = $consecutivo;
            $insert->idElemento     = $id_elemento;
            $insert->Seccion        = $seccion;
            $insert->Elemento       = $elemento;
            $insert->Descripcion    = $descripcion;
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("Ha ocurrido una anomalía al agregar la información de la carga de MIR. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }
    }
    
    public function addFormula($consecutivo, $id_elemento, $seccion, $elemento, $descripcion, $valor_original, $valor_modificado){
        try {
            $insert                 = new LogFormula();
            $insert->Consecutivo    = $consecutivo;
            $insert->idElemento     = $id_elemento;
            $insert->Seccion        = $seccion;
            $insert->Elemento       = $elemento;
            $insert->Descripcion    = $descripcion;

            // echo "addFormula (valor original): $valor_original";
            // echo "addFormula (valor modificado): $valor_modificado";
            $insert->ValorOriginal  = $valor_original;
            $insert->ValorModificado  = $valor_modificado;

            // if ($valor_original = "" || $valor_original == "-"){
            //     $insert->ValorOriginal  = $valor_original;
            // }else{
            //     $insert->ValorOriginal  = floatval($valor_original);
            // }
            
            // if ($valor_modificado = "" || $valor_modificado == "-"){
            //     $insert->ValorModificado  = $valor_modificado;
            // }else{
            //     $insert->ValorModificado  = floatval($valor_modificado);
            // }

            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("Ha ocurrido una anomalía al agregar la información de las formulas. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }
    }

    function validaFin($consecutivo, $request){
        
        $valida = 1;
        $idelemento_carga = "F";
        $seccion_carga = "Fin";

        if (empty($request->ValorNumerador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "NUMERADOR", "REVISAR VALOR", $request->ValorNumerador, "");
        }

        if (empty($request->ValorDenominador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "DENOMINADOR", "REVISAR VALOR", $request->ValorDenominador, "");
        }

        if (empty($request->LineaBaseV1)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR", $request->LineaBaseV1, "");
        }

        if (empty($request->LineaBaseV2)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR", $request->LineaBaseV2, "");
        }

        return $valida;
        
    }

    function validaProposito($consecutivo, $request){
        $valida = 1;
        $idelemento_carga = "P";
        $seccion_carga = "PROPÓSITO";

        if (empty($request->ValorNumerador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "NUMERADOR", "REVISAR VALOR", $request->ValorNumerador, "");
        }

        if (empty($request->ValorDenominador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "DENOMINADOR", "REVISAR VALOR", $request->ValorDenominador, "");
        }

        if (empty($request->LineaBaseV1)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR", $request->LineaBaseV1, "");
        }

        if (empty($request->LineaBaseV2)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR", $request->LineaBaseV2, "");
        }

        return $valida;
    }

    public function validaComponente($consecutivo, $id_elemento, $request){
        $valida = 1;
        $idelemento_carga = $id_elemento;
        $seccion_carga = "COMPONENTE ".$idelemento_carga;

        if (empty($request->ValorNumerador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "NUMERADOR", "REVISAR VALOR", $request->ValorNumerador, "");
        }

        if (empty($request->ValorDenominador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "DENOMINADOR", "REVISAR VALOR", $request->ValorDenominador, "");
        }

        if (empty($request->LineaBaseV1)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR", $request->LineaBaseV1, "");
        }

        if (empty($request->LineaBaseV2)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR", $request->LineaBaseV2, "");
        }

        if ($request->Frecuencia == "SEMESTRAL") {
            if (empty($request->Semestre1V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1, VALOR V1", "REVISAR VALOR", $request->Semestre1V1, "");
            }
    
            if (empty($request->Semestre2V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2, VALOR V1", "REVISAR VALOR", $request->Semestre2V1, "");
            }
    
            if (empty($request->Semestre1V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 1, VALOR V2", "REVISAR VALOR", $request->Semestre1V2, "");
            }
    
            if (empty($request->Semestre2V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "SEMESTRE 2, VALOR V2", "REVISAR VALOR", $request->Semestre2V2, "");
            }
        }

        if ($request->Frecuencia == "TRIMESTRAL") {
            if (empty($request->Trimestre1V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1, VALOR V1", "REVISAR VALOR", $request->Trimestre1V1, "");
            }
    
            if (empty($request->Trimestre2V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2, VALOR V1", "REVISAR VALOR", $request->Trimestre2V1, "");
            }
    
            if (empty($request->Trimestre3V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2, VALOR V1", "REVISAR VALOR", $request->Trimestre3V1, "");
            }
    
            if (empty($request->Trimestre4V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 4, VALOR V1", "REVISAR VALOR", $request->Trimestre4V1, "");
            }        
    
            if (empty($request->Trimestre1V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1, VALOR V2", "REVISAR VALOR", $request->Trimestre1V2, "");
            }
    
            if (empty($request->Trimestre2V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2, VALOR V2", "REVISAR VALOR", $request->Trimestre2V2, "");
            }
    
            if (empty($request->Trimestre3V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3, VALOR V2", "REVISAR VALOR", $request->Trimestre3V2, "");
            }
    
            if (empty($request->Trimestre4V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3, VALOR V2", "REVISAR VALOR", $request->Trimestre4V2, "");
            }
        }

        return $valida;
    }

    public function validaActividad($consecutivo, $id_elemento, $request){
        $valida = 1;
        $idelemento_carga = $id_elemento;
        $seccion_carga = "ACTIVIDAD ".$idelemento_carga;

        if (empty($request->ValorNumerador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "NUMERADOR", "REVISAR VALOR", $request->ValorNumerador, "");
        }

        if (empty($request->ValorDenominador)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "DENOMINADOR", "REVISAR VALOR", $request->ValorDenominador, "");
        }

        if (empty($request->LineaBaseV1)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V1", "REVISAR VALOR", $request->LineaBaseV1, "");
        }

        if (empty($request->LineaBaseV2)) {
            $valida = 0;
            $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "LÍNEA BASE V2", "REVISAR VALOR", $request->LineaBaseV2, "");
        }

        if ($request->Frecuencia == "TRIMESTRAL") {
            if (empty($request->Trimestre1V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1, VALOR V1", "REVISAR VALOR", $request->Trimestre1V1, "");
            }
        
            if (empty($request->Trimestre2V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2, VALOR V1", "REVISAR VALOR", $request->Trimestre2V1, "");
            }
        
            if (empty($request->Trimestre3V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2, VALOR V1", "REVISAR VALOR", $request->Trimestre3V1, "");
            }
        
            if (empty($request->Trimestre4V1)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 4, VALOR V1", "REVISAR VALOR", $request->Trimestre4V1, "");
            }        
        
            if (empty($request->Trimestre1V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 1, VALOR V2", "REVISAR VALOR", $request->Trimestre1V2, "");
            }
        
            if (empty($request->Trimestre2V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 2, VALOR V2", "REVISAR VALOR", $request->Trimestre2V2, "");
            }
        
            if (empty($request->Trimestre3V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3, VALOR V2", "REVISAR VALOR", $request->Trimestre3V2, "");
            }
        
            if (empty($request->Trimestre4V2)) {
                $valida = 0;
                $this->addFormula($consecutivo, $idelemento_carga, $seccion_carga, "TRIMESTRE 3, VALOR V2", "REVISAR VALOR", $request->Trimestre4V2, "");
            }
        }

        return $valida;
    }

    public function deleteCarga($consecutivo){
        try {
            $delete = LogCarga::find($consecutivo);

            if (is_null($delete)) {
                return response()->json(array('error' => true, 'result' => "No ha sido posible eliminar la información de la auditoría de carga.", 'code' => 404));
            }

            $delete->delete();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("No ha sido posible eliminar la información de la auditoría de carga. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }
    }

    public function deleteFormula($consecutivo){
        try {
            $delete = LogFormula::find($consecutivo);

            if (is_null($delete)) {
                return response()->json(array('error' => true, 'result' => "No ha sido posible eliminar la información de la auditoría de formulas.", 'code' => 404));
            }

            $delete->delete();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("No ha sido posible eliminar la información de la auditoría de formulas. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }
    }

    public function deletelog(Request $request){
        try {
            $id_formula = $request->all();
            for ($i=0; $i < count($id_formula); $i++) {

                $delete = LogFormula::
                    where('id', '=', $id_formula[$i])
                    ->first();

                if (is_null($delete)) {
                    return response()->json(array('error' => true, 'result' => "La auditoría de formulas que intenta eliminar no existe.", 'code' => 404));
                }

                $delete->delete();
            }

            return response()->json(array('error' => false, 'data' => $delete, 'code' => 200));
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => ("No ha sido posible eliminar la información de la auditoría de formulas. " . $e->getMessage() . " Línea de error: " . $e->getLine()), 'code' => 500));
        }
        
    }

    public function Func_LimpiarMoneda($numero) {
        if ($numero == 0 || $numero == "0") {
            return $numero;
        } else {
            if (strpos($numero, '$') !== false) {
                while (strpos($numero, '$') !== false) {
                    $numero = str_replace("$", "", $numero);
                }
            }
            if (strpos($numero, ',') !== false) {
                while (strpos($numero, ',') !== false) {
                    $numero = str_replace(",", "", $numero);
                }
            }
        }
    
        return trim(preg_replace('/\s+/', '', $numero));
    }

    public function ContarIndicadores(Request $request) {
        $idSecretaria = $request->idSecretaria == '' ? '0' : $request->idSecretaria;
        $ejercicio = $request->ejercicio_fiscal;
        $query = "SELECT 
        (-- contando los indicadores de los componentes
        SELECT COUNT(*) 
            FROM MIR_CARATULA_View mv
            INNER JOIN COMPONENTE1 c1 ON mv.Consecutivo = c1.ClasProgramatica
            INNER JOIN PROGRAMATICO_COMP pc ON pc.Id = c1.ComponenteId
        WHERE 
            pc.ejercicioFiscal = $ejercicio 
            AND (CASE WHEN '$idSecretaria' <> '0' THEN mv.idSecretaria = '$idSecretaria' ELSE 1=1 END )
        ) +
        -- contando los indicadores de las actividades
        (
        SELECT COUNT(*) FROM 
            ACTIVIDAD A
            INNER JOIN COMPONENTE1 C1 ON A.ComponenteMirId = C1.ComponenteId
            INNER JOIN MIR_CARATULA_View mv ON mv.Consecutivo = c1.ClasProgramatica
            INNER JOIN PROGRAMATICO_COMP pc ON pc.Id = c1.ComponenteId
        WHERE pc.ejercicioFiscal = $ejercicio 
        AND (CASE WHEN '$idSecretaria' <> '0' THEN mv.idSecretaria = '$idSecretaria' ELSE 1=1 END )
        ) AS indicadores";

        $informacion = DB::select($query);
        return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));
    }
}

?>
