<?php

namespace App\Http\Controllers;

use App\MirCaratula;
use App\MirFin;
use App\MirProposito;
use App\MirComponente;
use App\MirActividad;
use App\LogCarga;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MirController extends Controller
{
    public function index(Request $request)
    {

        if ($request->id_secretaria == 0 && $request->id_ua == 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else if ($request->id_secretaria != 0 && $request->id_ua == 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View WHERE idSecretaria = '$request->id_secretaria' ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else if ($request->id_secretaria == 0 && $request->id_ua != 0){
            
            $query = "SELECT * FROM MIR_CARATULA_View WHERE idUA = '$request->id_ua' ORDER BY Consecutivo;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }else{

            $query = "SELECT * FROM MIR_CARATULA_View WHERE idSecretaria = '$request->id_secretaria' AND idUA = '$request->id_ua' ORDER BY Consecutivo;";
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

    public function fin(Request $request)
    {
        $info = DB::table('FIN1')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function proposito(Request $request)
    {
        $info = DB::table('PROPOSITO')
            ->where('ClasProgramatica', $request->consecutivo)->first();

        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function componentes(Request $request)
    {
        $query = "SELECT * FROM COMPONENTE1 WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
    }

    public function actividades(Request $request)
    {
        $query = "SELECT * FROM ACTIVIDAD WHERE ClasProgramatica = '$request->consecutivo';";
        $info = DB::select($query);
        return response()->json(array('error' => false, 'data' => $info, 'code' => 200));
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
        $delete = LogCarga::find($request->caratula['consecutivo_caratula']);
        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "No hay información en el log que eliminar.", 'code' => 404));
        }
        $delete->delete();

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
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar la caratula. " . $e->getMessage()), 'code' => 500));
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
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar el fin. " . $e->getMessage()), 'code' => 500));
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
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar el proposito. " . $e->getMessage()), 'code' => 500));
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
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar el componente. " . $e->getMessage()), 'code' => 500));
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
            return response()->json(array('error' => true , 'result' => ("Anomalía detectada al guardar la actividad. " . $e->getMessage()), 'code' => 500));
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
            return response()->json(array('error' => true , 'result' => "Ha ocurrido una anomalía al realizar las validaciones. " . $e->getMessage(), 'code' => 500));
        }
    }

    /*
    public function index(Request $request)
    {
        try {
            $query = "SELECT * FROM CAT_BENEFICIARIO WHERE idBeneficiario = $request->id_TipoBeneficiario;";
            $informacion = DB::select($query);
            return response()->json(array('error' => false, 'data' => $informacion, 'code' => 200));

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $informacion , 'code' => 200));
    }
    
    public function insert(Request $request)
    {
        try {
            $insert                     = new Beneficiarios;
            $insert->idCatBeneficiario  = $request->id_beneficiario;
            $insert->idBeneficiario     = $request->id_tipobeneficiario;
            $insert->Poblacion          = $request->descripcion;
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }

    public function delete(Request $request)
    {

        $delete = Beneficiarios::find($request->id_beneficiario);

        if (is_null($delete)) {
            return response()->json(array('error' => true, 'result' => "El beneficiario que intenta eliminar no existe.", 'code' => 404));
        }

        $delete->delete();

        return response()->json(array('error' => false, 'result' => $delete , 'code' => 200));
    }
    
    public function insert_tipo(Request $request)
    {
        try {
            $insert                     = new TipoBeneficiarios;
            $insert->idBeneficiario     = $request->id_tipobeneficiario;
            $insert->TipoBeneficiario   = $request->descripcion;
            $insert->save();

        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $insert , 'code' => 200));
    }
    
    public function update_tipo(Request $request)
    {
        $update = TipoBeneficiarios::find($request->id_tipobeneficiario);

        if (is_null($update)) {
            return response()->json(array('error' => true, 'result' => "El tipo beneficiario que intenta editar no existe.", 'code' => 404));
        }
        
        try {
            $update->idBeneficiario     = $request->id_tipobeneficiario;
            $update->TipoBeneficiario   = $request->descripcion;
            $update->save();
        }catch (Exception $e) {
            return response()->json(array('error' => true , 'result' => $e->getMessage(), 'code' => 500));
        }

        return response()->json(array('error' => false, 'result' => $update , 'code' => 200));
    }
    */
    
}

?>
                                                                                                                                                                                                                                        