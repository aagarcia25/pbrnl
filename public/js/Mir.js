const repository = new Repository();
var info_secretarias = null;
var info_unidadadministrativa = null;
var info_ejes = null;
var info_temas = null;
var info_objetivos = null;
var info_estrategias = null;
var info_lineasaccion = null;
var info_tiposbeneficiarios = null;
var info_beneficiarios = null;
var info_componentes = null;
var info_actividades = null;

var index_componente = null;
var index_actividad = null;

var selectSecretaria = null;
var selectUnidadAdministrativa = null;
var consecutivo_seleccionado = null;

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    Func_Cargando();
    GetSecretarias();
}

function GetSecretarias() {
    repository.Secretarias.GetSecretarias()
        .then(ResponseGetSecretarias);
}

function ResponseGetSecretarias(response) {
    if (!response.error) {
        $('#select_Secretaria').children('option:not(:first)').remove();
        $('#select_entepublido').children('option:not(:first)').remove();
        info_secretarias = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_Secretaria').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
            $('#select_entepublido').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_Secretaria').selectpicker("refresh");
        $('#select_entepublido').selectpicker("refresh");
        GetUnidadesAdministrativas();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetUnidadesAdministrativas(){
    repository.UnidadesAdministrativas.GetAllUnidadesAdministrativas()
        .then(ResponseGetUnidadesAdministrativas);
}

function ResponseGetUnidadesAdministrativas(response){
    if (!response.error) {
        $('#select_UnidadAdministrativa').children().remove();
        info_unidadadministrativa = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_UnidadAdministrativa').append($('<option>', {
                value: response.data[i].idUnidad,
                text: ("[" + response.data[i].idUnidad + "] " + response.data[i].Descripcion)
            }));
        }

        $('#select_UnidadAdministrativa').selectpicker("refresh");
        
        GetEjes();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetEjes() {
    Func_Cargando();
    repository.Eje.GetEjes()
        .then(ResponseGetEjes);
}

function ResponseGetEjes(response) {
    if (!response.error) {
        info_ejes = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_ejeped').append($('<option>', {
                value: response.data[i].IdEje,
                text: ("[" + response.data[i].IdEje + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_ejeped').selectpicker("refresh");
        GetAllTemas()
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllTemas() {
    repository.Tema.GetAllTemas()
        .then(ResponseGetTemas);
}

function ResponseGetTemas(response) {
    if (!response.error) {
        info_temas = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_temaped').append($('<option>', {
                value: response.data[i].IdTema,
                text: ("[" + response.data[i].IdTema + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_temaped').selectpicker("refresh");
        GetObjetivos();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetObjetivos(){
    repository.Objetivos.GetAllObjetivos()
        .then(ResponseGetObjetivos);
}

function ResponseGetObjetivos(response){
    if (!response.error) {
        info_objetivos = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_objetivo').append($('<option>', {
                value: response.data[i].IdObjetivo,
                text: ("[" + response.data[i].IdObjetivo + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_objetivo').selectpicker("refresh");
        GetAllEstretegias();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllEstretegias(){
    repository.Estrategias.GetAllEstretegias()
        .then(ResponseGetAllEstretegias);
}

function ResponseGetAllEstretegias(response){
    if (!response.error) {
        info_estrategias = response.data;
        GetAllLineasAccion();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllLineasAccion(){
    repository.LineasAccion.GetAllLineasAccion()
        .then(ResponseGetAllLineasAccion);
}

function ResponseGetAllLineasAccion(response){
    if (!response.error) {
        info_lineasaccion = response.data;
        GetTiposBeneficiarios();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetTiposBeneficiarios(){
    repository.Beneficiarios.GetTiposBeneficiarios()
        .then(ResponseGetTiposBeneficiarios);
}

function ResponseGetTiposBeneficiarios(response){
    if (!response.error) {
        info_tiposbeneficiarios = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_tipobeneficiario').append($('<option>', {
                value: response.data[i].idBeneficiario,
                text: ("[" + response.data[i].idBeneficiario + "] " + response.data[i].TipoBeneficiario)
            }));
        }
        $('#select_tipobeneficiario').selectpicker("refresh");
        GetAllBeneficiarios();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllBeneficiarios(){
    repository.Beneficiarios.GetAllBeneficiarios()
        .then(ResponseGetAllBeneficiarios);
}

function ResponseGetAllBeneficiarios(response){
    if (!response.error) {
        info_beneficiarios = response.data;
        GetMir();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMir(){
    request = {
        id_secretaria: ($('#select_Secretaria').val() == "" ? 0 : $('#select_Secretaria').val()),
        id_ua: ($('#select_UnidadAdministrativa').val() == "" ? 0 : $('#select_UnidadAdministrativa').val())
    }
    repository.Mir.GetMir(request)
        .then(ResponseGetMir);
}

function ResponseGetMir(response){
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].CONAC}</td>
                        <td>${response.data[i].Consecutivo}</td>
                        <td>${response.data[i].DescripcionPrograma}</td>
                        <td>${response.data[i].idClasificacion}</td>
                        <td>${response.data[i].TipoBeneficiario}</td>
                        <td>${response.data[i].EjercicioFiscal}</td>
                    </tr>
                `);
            }
        }
        Func_DataTable("table", true, true, true, 1);
        swal.close();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function Eventos() {
    SeleccionarTabla();
    OnChange_Secretaria();
    OnChange_UnidadAdministrativa();
    OnChange_UnidadMedida();
    OnChange_SelectFrecuencia();

    OnClic_TabsInternas();
    OnClic_TabsComponentes();
    OnClic_TabsActividades();

    BtnEditarMir();
    BtnGuardarMir();
}

function SeleccionarTabla() {
    $('#table tbody').on('click', 'tr', function() {
        var table = $('#table').DataTable();
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
}

function OnChange_Secretaria(){
    $("#select_Secretaria").on("change", function(){
        Func_Cargando();
        GetMir();
    });
}

function OnChange_UnidadAdministrativa(){
    $("#select_UnidadAdministrativa").on("change", function(){
        Func_Cargando();
        GetMir();
    });
}

function OnChange_UnidadMedida() {
    $(".unidad-medida").on("change", function(){
        var tipo = $(this).data("tipo");
        var select = $(this).val();

        if (select == "PORCENTAJE"){
            $("#d-descripcionunidadmedida_" + tipo).addClass("d-none");
        }else{
            $("#d-descripcionunidadmedida_" + tipo).removeClass("d-none");
        }
    })
}

function OnChange_SelectFrecuencia() {
    $(".select-frecuencia").on("change", function(){
        var tipo = $(this).data("tipo");
        var select = $(this).val();

        if (select == "TRIMESTRAL"){
            $(".d-metasemestral-" + tipo).addClass("d-none");
            $(".d-trimestral-" + tipo).removeClass("d-none");
        }else{
            $(".d-metasemestral-" + tipo).removeClass("d-none");
            $(".d-trimestral-" + tipo).addClass("d-none");
        }
    })
}

function OnClic_TabsInternas(){
    $(".tabs-internas").on("click", function(){
        var seccion = $(this).data("seccion");
        var actual = $(this).data("actual");
        var texto = $(this).data("texto");
        var superior = $(this).data("superior");
        
        $("#" + seccion).addClass("d-none");
        $("#" + actual).removeClass("d-none");
        $(".number-tabs-" + superior).text(texto);
    });
}

function OnClic_TabsComponentes(){
    $(".tabs-select-componente").on("click", function(){
        var tipo = $(this).data("tipo");
        let index_actual_superior = index_componente;
        let index_actual = index_componente;
        let index_nuevo = null;
        
        if (tipo == "-1"){
            index_nuevo = index_actual - 1;
            
            if (index_nuevo <= (info_componentes.length-1) && index_nuevo >= 0 ){
                index_componente = index_nuevo;
            }else{
                index_nuevo = index_nuevo + 1;
            }
        }else{
            index_nuevo = index_actual + 1;

            if (index_nuevo <= (info_componentes.length-1)){
                index_componente = index_nuevo;
            }else{
                index_nuevo = index_nuevo - 1;
            }
        }
        
        if (index_actual_superior == index_nuevo){
        }else{
            Func_Cargando();
            index_actividad = 0;
            let componente = info_componentes[index_nuevo];
            let id_componente = componente['idComponente'];

            $("#claseprogramatica_componente").val(componente['ClasProgramatica']);
            $("#id_componente").val(componente['idComponente']);
            $("#nombre_componente").val(componente['Componente']);
            $("#id_componenteactividad").val(componente['idComponente']);
            $("#nombre_componenteactividad").val(componente['Componente']);
            $("#claveindicador_componente").val(componente['ClaveIndicador']);
            $("#nombreindicar_componente").val(componente['Indicador']);
            $("#descripcionformula_componente").val(componente['Formula']);
            $("#variable1_componente").val(componente['V1']);
            $("#variable2_componente").val(componente['V2']);
            $("#variable3_componente").val(componente['FormulaV1V2']);
            
            $("#select_unidadmedida_componente").selectpicker("val", componente['UnidadMedida']);
            if (componente['UnidadMedida'] == "ABSOLUTO"){
                $("#d-descripcionunidadmedida_componente").removeClass("d-none");
                $("#descripcionunidadmedida_componente").val(componente['DescripAbsoluto']);
            }else{
                $("#d-descripcionunidadmedida_componente").addClass("d-none");
                $("#descripcionunidadmedida_componente").val("");
            }

            $("#selectfrecuencia_componente").selectpicker("val", componente['Frecuencia']);
            if (componente['Frecuencia'] == "SEMESTRAL"){
                $(".d-trimestral-componente").addClass("d-none");
                $(".d-metasemestral-componente").removeClass("d-none");
            }else if (response.data[index_componente]['Frecuencia'] == "TRIMESTRAL"){
                $(".d-metasemestral-componente").addClass("d-none");
                $(".d-trimestral-componente").removeClass("d-none");
            }

            $("#metaanual_componente").val(componente['MetaAnual']);
            $("#lineabase_componente1").val(componente['LineaBase']);
            $("#lineabaseV1_componente").val(componente['LineaBaseV1']);
            $("#lineabaseV2_componente").val(componente['LineaBaseV2']);
            $("#ejecerciciofisca_componente").selectpicker("val", "2021");

            $("#variableV1_componente").val(componente['ValorNumerador']);
            $("#variableV2_componente").val(componente['ValorDenominador']);
            
            // Trimestral
            $("#metatrimestral1_componente").val(componente['MetaTrimestre1']);
            $("#metatrimestral2_componente").val(componente['MetaTrimestre2']);
            $("#metatrimestral3_componente").val(componente['MetaTrimestre3']);
            $("#metatrimestral4_componente").val(componente['MetaTrimestre4']);
            $("#metatrimestral1V1D_componente").val(componente['Trimestre1V1']);
            $("#metatrimestral1V1A_componente").val(componente['']);
            $("#metatrimestral1V2D_componente").val(componente['Trimestre1V2']);
            $("#metatrimestral1V2A_componente").val(componente['']);
    
            $("#metatrimestral2V1D_componente").val(componente['Trimestre2V1']);
            $("#metatrimestral2V1A_componente").val(componente['']);
            $("#metatrimestral2V2D_componente").val(componente['Trimestre2V2']);
            $("#metatrimestral2V2A_componente").val(componente['']);
    
            $("#metatrimestral3V1D_componente").val(componente['Trimestre3V1']);
            $("#metatrimestral3V1A_componente").val(componente['']);
            $("#metatrimestral3V2D_componente").val(componente['Trimestre3V2']);
            $("#metatrimestral3V2A_componente").val(componente['']);
    
            $("#metatrimestral4V1D_componente").val(componente['Trimestre4V1']);
            $("#metatrimestral4V1A_componente").val(componente['']);
            $("#metatrimestral4V2D_componente").val(componente['Trimestre4V2']);
            $("#metatrimestral4V2A_componente").val(componente['']);
    
            // Semestral
            $("#metasemestral1_componente").val(componente['MetaSemestre1']);
            $("#metasemestral2_componente").val(componente['MetaSemestre2']);
            $("#metasemestral1V1D_componente").val(componente['Semestre1V1']);
            $("#metasemestral1V1A_componente").val(componente['']);
            $("#metasemestral2V1D_componente").val(componente['Semestre2V1']);
            $("#metasemestral2V1A_componente").val(componente['']);
            $("#metasemestral1V2D_componente").val(componente['Semestre1V2']);
            $("#metasemestral1V2A_componente").val(componente['']);
            $("#metasemestral2V2D_componente").val(componente['Semestre2V2']);
            $("#metasemestral2V2A_componente").val(componente['']);
            
            $("#mediosverificacion_componente").val(componente['MediosVerificacion']);
            $("#fuentesinformacion_componente").val(componente['FuenteInformacion']);
            $("#supuestos_componente").val(componente['Supuestos']);

            $(`input[name=claridad_componente][value="${componente['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=relevancia_componente][value="${componente['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=economia_componente][value="${componente['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=monitoreable_componente][value="${componente['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=adecuado_componente][value="${componente['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=aportemarginal_componente][value="${componente['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);

            $("#select_sentidoindicador_componente").selectpicker("val", componente['SentidoIndicador']);
            $("#select_tipoindicador_componente").selectpicker("val", componente['TipoIndicador']);
            $("#select_dimensionindicador_componente").selectpicker("val", componente['DimensionIndicador']);
            $("#select_unidadresponsablereportar_componente").selectpicker("val", componente['UnidadResponsable']);

            $("#descripcionindicador_componente").val(componente['DescripcionIndicador']);
            $("#descripcionnumerador_componente").val(componente['DescripcionNumerador']);
            $("#descripciondenominador_componente").val(componente['DescripcionDenominador']);
            
            // Obtiene la info de actividades
            $("#claseprogramatica_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ClasProgramatica']);
            $("#idcomponente_actividad").val(info_actividades[id_componente]['items'][index_actividad]['idComponente']);
            $("#id_actividad").val(info_actividades[id_componente]['items'][index_actividad]['idActividad']);
            $("#nombre_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Actividad']);
            $("#claveindicador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ClaveIndicador']);
            $("#nombreindicar_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Indicador']);
            $("#descripcionformula_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Formula']);
            $("#variable1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['V1']);
            $("#variable2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['V2']);
            $("#variable3_actividad").val(info_actividades[id_componente]['items'][index_actividad]['FormulaV1V2']);

            $("#select_unidadmedida_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['UnidadMedida']);
            if (info_actividades[id_componente]['items'][index_actividad]['UnidadMedida'] == "ABSOLUTO"){
                $("#d-descripcionunidadmedida_actividad").removeClass("d-none");
                $("#descripcionunidadmedida_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripAbsoluto']);
            }else{
                $("#d-descripcionunidadmedida_actividad").addClass("d-none");
                $("#descripcionunidadmedida_actividad").val("");
            }

            $("#selectfrecuencia_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['Frecuencia']);
            if (info_actividades[id_componente]['items'][index_actividad]['Frecuencia'] == "SEMESTRAL"){
                $(".d-trimestral-actividad").addClass("d-none");
                $(".d-metasemestral-actividad").removeClass("d-none");
            }else if (info_actividades[id_componente]['items'][index_actividad]['Frecuencia'] == "TRIMESTRAL"){
                $(".d-metasemestral-actividad").addClass("d-none");
                $(".d-trimestral-actividad").removeClass("d-none");
            }

            $("#metaanual_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaAnual']);
            $("#lineabase_actividad1").val(info_actividades[id_componente]['items'][index_actividad]['LineaBase']);
            $("#ejecerciciofisca_actividad").selectpicker("val", "2021");

            $("#variableV1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ValorNumerador']);
            $("#variableV2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ValorDenominador']);

            // Trimestral
            $("#metatrimestral1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre1']);
            $("#metatrimestral2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre2']);
            $("#metatrimestral3_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre3']);
            $("#metatrimestral4_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre4']);
            $("#metatrimestral1V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre1V1']);
            $("#metatrimestral1V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral1V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre1V2']);
            $("#metatrimestral1V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#metatrimestral2V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre2V1']);
            $("#metatrimestral2V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral2V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre2V2']);
            $("#metatrimestral2V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#metatrimestral3V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre3V1']);
            $("#metatrimestral3V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral3V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre3V2']);
            $("#metatrimestral3V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#metatrimestral4V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre4V1']);
            $("#metatrimestral4V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral4V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre4V2']);
            $("#metatrimestral4V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            // Semestral
            $("#metasemestral1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaSemestre1']);
            $("#metasemestral2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaSemestre2']);
            $("#metasemestral1V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre1V1']);
            $("#metasemestral1V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metasemestral2V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre2V1']);
            $("#metasemestral2V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metasemestral1V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre1V2']);
            $("#metasemestral1V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metasemestral2V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre2V2']);
            $("#metasemestral2V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#mediosverificacion_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MediosVerificacion']);
            $("#fuentesinformacion_actividad").val(info_actividades[id_componente]['items'][index_actividad]['FuenteInformacion']);
            $("#supuestos_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Supuestos']);

            $(`input[name=claridad_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=relevancia_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=economia_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=monitoreable_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=adecuado_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=aportemarginal_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);

            $("#select_sentidoindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['SentidoIndicador']);
            $("#select_tipoindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['TipoIndicador']);
            $("#select_dimensionindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['DimensionIndicador']);
            $("#select_unidadresponsablereportar_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['UnidadResponsable']);

            $("#descripcionindicador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionIndicador']);
            $("#descripcionnumerador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionNumerador']);
            $("#descripciondenominador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionDenominador']);

            swal.close();
        }
    });
}

function OnClic_TabsActividades(){
    $(".tabs-select-actividad").on("click", function(){
        var tipo = $(this).data("tipo");
        let index_actual_superior = index_actividad;
        let index_actual = index_actividad;
        let index_nuevo = null;
        let id_componente = $("#id_componente").val();
        
        if (tipo == "-1"){
            index_nuevo = index_actual - 1;
            
            if (index_nuevo <= (info_actividades[id_componente]['items'].length-1) && index_nuevo >= 0 ){
                index_actividad = index_nuevo;
            }else{
                index_nuevo = index_nuevo + 1;
            }
        }else{
            index_nuevo = index_actual + 1;

            if (index_nuevo <= (info_actividades[id_componente]['items'].length-1)){
                index_actividad = index_nuevo;
            }else{
                index_nuevo = index_nuevo - 1;
            }
        }

        if (index_actual_superior == index_nuevo){
        }else{
            Func_Cargando();
            
            $("#claseprogramatica_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ClasProgramatica']);
            $("#idcomponente_actividad").val(info_actividades[id_componente]['items'][index_actividad]['idComponente']);
            $("#id_actividad").val(info_actividades[id_componente]['items'][index_actividad]['idActividad']);
            $("#nombre_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Actividad']);
            $("#claveindicador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ClaveIndicador']);
            $("#nombreindicar_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Indicador']);
            $("#descripcionformula_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Formula']);
            $("#variable1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['V1']);
            $("#variable2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['V2']);
            $("#variable3_actividad").val(info_actividades[id_componente]['items'][index_actividad]['FormulaV1V2']);

            $("#select_unidadmedida_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['UnidadMedida']);
            if (info_actividades[id_componente]['items'][index_actividad]['UnidadMedida'] == "ABSOLUTO"){
                $("#d-descripcionunidadmedida_actividad").removeClass("d-none");
                $("#descripcionunidadmedida_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripAbsoluto']);
            }else{
                $("#d-descripcionunidadmedida_actividad").addClass("d-none");
                $("#descripcionunidadmedida_actividad").val("");
            }

            $("#selectfrecuencia_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['Frecuencia']);
            if (info_actividades[id_componente]['items'][index_actividad]['Frecuencia'] == "SEMESTRAL"){
                $(".d-trimestral-actividad").addClass("d-none");
                $(".d-metasemestral-actividad").removeClass("d-none");
            }else if (info_actividades[id_componente]['items'][index_actividad]['Frecuencia'] == "TRIMESTRAL"){
                $(".d-metasemestral-actividad").addClass("d-none");
                $(".d-trimestral-actividad").removeClass("d-none");
            }

            $("#metaanual_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaAnual']);
            $("#lineabase_actividad1").val(info_actividades[id_componente]['items'][index_actividad]['LineaBase']);
            $("#ejecerciciofisca_actividad").selectpicker("val", "2021");

            $("#variableV1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ValorNumerador']);
            $("#variableV2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ValorDenominador']);

            // Trimestral
            $("#metatrimestral1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre1']);
            $("#metatrimestral2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre2']);
            $("#metatrimestral3_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre3']);
            $("#metatrimestral4_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre4']);
            $("#metatrimestral1V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre1V1']);
            $("#metatrimestral1V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral1V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre1V2']);
            $("#metatrimestral1V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#metatrimestral2V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre2V1']);
            $("#metatrimestral2V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral2V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre2V2']);
            $("#metatrimestral2V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#metatrimestral3V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre3V1']);
            $("#metatrimestral3V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral3V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre3V2']);
            $("#metatrimestral3V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#metatrimestral4V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre4V1']);
            $("#metatrimestral4V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metatrimestral4V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre4V2']);
            $("#metatrimestral4V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            // Semestral
            $("#metasemestral1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaSemestre1']);
            $("#metasemestral2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaSemestre2']);
            $("#metasemestral1V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre1V1']);
            $("#metasemestral1V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metasemestral2V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre2V1']);
            $("#metasemestral2V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metasemestral1V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre1V2']);
            $("#metasemestral1V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
            $("#metasemestral2V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre2V2']);
            $("#metasemestral2V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

            $("#mediosverificacion_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MediosVerificacion']);
            $("#fuentesinformacion_actividad").val(info_actividades[id_componente]['items'][index_actividad]['FuenteInformacion']);
            $("#supuestos_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Supuestos']);

            $(`input[name=claridad_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=relevancia_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=economia_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=monitoreable_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=adecuado_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=aportemarginal_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);

            $("#select_sentidoindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['SentidoIndicador']);
            $("#select_tipoindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['TipoIndicador']);
            $("#select_dimensionindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['DimensionIndicador']);
            $("#select_unidadresponsablereportar_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['UnidadResponsable']);

            $("#descripcionindicador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionIndicador']);
            $("#descripcionnumerador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionNumerador']);
            $("#descripciondenominador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionDenominador']);
            
            swal.close();
        }
    });
}

function BtnEditarMir(){
    $("#BtnEditarMir").on("click", function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();
        
        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }
        
        let conac = data[0];
        let consecutivo = data[1];
        let ejercicio = data[5];

        consecutivo_seleccionado = consecutivo;
        var request = {
            consecutivo: consecutivo,
            ejercicio: ejercicio
        }
        Func_LimpiarModal();
        $("#modal_accion").text(`[${conac}${consecutivo}]`);
        Func_Cargando();
        GetMirCaratula(request);
    });
}

function GetMirCaratula(request) {
    index_componente = 0;
    index_actividad = 0;
    repository.Mir.GetMirCaratula(request)
        .then(ResponseGetMirCaratula);
}

function ResponseGetMirCaratula(response) {
    if (!response.error) {
        $(".tab-modal-caratula").removeClass("active");
        $(".tab-pane").removeClass("active");
        $(".tab-pane").removeClass("show");
        $("#tab-caratula").addClass("active");
        $("#nav-caratula").addClass("active");
        $("#nav-caratula").addClass("show");
        $("#finuno").removeClass("d-none");
        $("#findos").addClass("d-none");
        $("#propositouno").removeClass("d-none");
        $("#propositodos").addClass("d-none");
        $("#componentesuno").removeClass("d-none");
        $("#componentesdos").addClass("d-none");
        $("#actividadesuno").removeClass("d-none");
        $("#actividadesdos").addClass("d-none");

        $("#consecutivo_caratula").val(response.data['Consecutivo']);
        $("#conac_caratula").val(response.data['CONAC']);
        $("#select_entepublido").selectpicker("val", response.data['idSecretaria']);
        $("#nombre_pp").val(`[${response.data['Consecutivo']}] ${response.data['DescripcionPrograma']}`);
        $("#clave_programatica").val(`${response.data['CONAC']}${response.data['Consecutivo']}`);
        $("#ejercicio_fiscal").val(response.data['EjercicioFiscal']);
        $("#select_ejeped").selectpicker("val", response.data['idEje']);
        $("#select_temaped").selectpicker("val", response.data['idTema']);
        $("#select_objetivo").selectpicker("val", response.data['idObjetivo']);
        $("#programa_sectorial").val(response.data['ProgramaSectorial']);
        $("#select_tipobeneficiario").selectpicker("val", response.data['idBeneficiario']);

        $('#select_estrategia').selectpicker("destroy");
        $('#select_estrategia').children().remove();
        for (let i = 0; i < info_estrategias.length; i++) {
            const estrategias = info_estrategias[i];
            
            if (estrategias['IdEje'] == response.data['idEje'] && estrategias['IdTema'] == response.data['idTema'] && estrategias['IdObjetivo'] == response.data['idObjetivo']){
                $('#select_estrategia').append($('<option>', {
                    value: estrategias.IdEstrategias,
                    text: ("[" + estrategias.IdEstrategias + "] " + estrategias.Descripcion)
                }));
            }
        }
        $('#select_estrategia').selectpicker();
        
        $('#select_lineaaccion1').selectpicker("destroy");
        $('#select_lineaaccion2').selectpicker("destroy");
        $('#select_lineaaccion1').children().remove();
        $('#select_lineaaccion2').children().remove();
        for (let j = 0; j < info_lineasaccion.length; j++) {
            const lineaccion = info_lineasaccion[j];
            
            if (lineaccion['IdEje'] == response.data['idEje'] && lineaccion['IdTema'] == response.data['idTema'] && lineaccion['IdObjetivo'] == response.data['idObjetivo'] && lineaccion['IdEstrategia'] == response.data['idEstrategia']){
                $('#select_lineaaccion1').append($('<option>', {
                    value: lineaccion.IdLineaAccion,
                    text: ("[" + lineaccion.IdLineaAccion + "] " + lineaccion.Descripcion)
                }));
                $('#select_lineaaccion2').append($('<option>', {
                    value: lineaccion.IdLineaAccion,
                    text: ("[" + lineaccion.IdLineaAccion + "] " + lineaccion.Descripcion)
                }));
            }
        }
        $('#select_lineaaccion1').selectpicker();
        $('#select_lineaaccion2').selectpicker();

        $('#select_descripcionampliabeneficiario1').selectpicker("destroy");
        $('#select_descripcionampliabeneficiario2').selectpicker("destroy");
        $('#select_descripcionampliabeneficiario1').children().remove();
        $('#select_descripcionampliabeneficiario2').children().remove();
        for (let k = 0; k < info_beneficiarios.length; k++) {
            const beneficiario = info_beneficiarios[k];
            
            if (beneficiario['idBeneficiario'] == response.data['idBeneficiario'] ){
                $('#select_descripcionampliabeneficiario1').append($('<option>', {
                    value: beneficiario.idCatBeneficiario,
                    text: ("[" + beneficiario.idCatBeneficiario + "] " + beneficiario.Poblacion)
                }));
                $('#select_descripcionampliabeneficiario2').append($('<option>', {
                    value: beneficiario.idCatBeneficiario,
                    text: ("[" + beneficiario.idCatBeneficiario + "] " + beneficiario.Poblacion)
                }));
            }
        }
        $('#select_descripcionampliabeneficiario1').selectpicker();
        $('#select_descripcionampliabeneficiario2').selectpicker();

        $("#select_uaresponsable").selectpicker("destroy");
        $("#select_unidadresponsablereportar").selectpicker("destroy");
        $("#select_unidadresponsablereportar_fin").selectpicker("destroy");
        $("#select_unidadresponsablereportar_proposito").selectpicker("destroy");
        $("#select_unidadresponsablereportar_componente").selectpicker("destroy");
        $("#select_uaresponsable").children().remove();
        $("#select_unidadresponsablereportar").children().remove();
        $("#select_unidadresponsablereportar_fin").children().remove();
        $("#select_unidadresponsablereportar_proposito").children().remove();
        $("#select_unidadresponsablereportar_componente").children().remove();
        for (let i = 0; i < info_unidadadministrativa.length; i++) {
            const unidadadministrativa = info_unidadadministrativa[i];
            
            if (unidadadministrativa['idSecretaria'] == response.data['idSecretaria']){
                $('#select_uaresponsable').append($('<option>', {
                    value: unidadadministrativa.idUnidad,
                    text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
                }));
                $('#select_unidadresponsablereportar').append($('<option>', {
                    value: unidadadministrativa.idUnidad,
                    text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
                }));
                $('#select_unidadresponsablereportar_fin').append($('<option>', {
                    value: unidadadministrativa.idUnidad,
                    text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
                }));
                $('#select_unidadresponsablereportar_proposito').append($('<option>', {
                    value: unidadadministrativa.idUnidad,
                    text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
                }));
                $('#select_unidadresponsablereportar_componente').append($('<option>', {
                    value: unidadadministrativa.idUnidad,
                    text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
                }));
            }
        }
        $("#select_uaresponsable").selectpicker();
        $("#select_unidadresponsablereportar").selectpicker();
        $("#select_unidadresponsablereportar_fin").selectpicker();
        $("#select_unidadresponsablereportar_proposito").selectpicker();
        $("#select_unidadresponsablereportar_componente").selectpicker();

        $("#select_uaresponsable").selectpicker("val", response.data['idUA']);
        $("#select_unidadresponsablereportar").selectpicker("val", response.data['idUA']);
        $("#select_estrategia").selectpicker("val", response.data['idEstrategia']);
        $("#select_lineaaccion1").selectpicker("val", response.data['idLineaAccion']);
        $("#select_lineaaccion2").selectpicker("val", response.data['idLineaAccion2']);
        $("#select_descripcionampliabeneficiario1").selectpicker("val", response.data['idCatBeneficiario']);
        $("#select_descripcionampliabeneficiario2").selectpicker("val", response.data['idCatBeneficiario2']);

        
        GetMirFin();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMirFin() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirFin(request)
        .then(ResponseGetMirFin);
}

function ResponseGetMirFin(response) {
    if (!response.error) {
        $("#fin_fin").val(response.data['Fin']);
        $("#claseprogramatica_fin").val(response.data['ClasProgramatica']);
        $("#claveindicador_fin").val(response.data['ClaveIndicador']);
        $("#nombreindicar_fin").val(response.data['Indicador']);
        $("#descripcionformula_fin").val(response.data['Formula']);
        $("#variable1_fin").val(response.data['V1']);
        $("#variable2_fin").val(response.data['V2']);
        $("#variable3_fin").val(response.data['FormulaV1V2']);
        
        $("#select_unidadmedida_fin").selectpicker("val", response.data['UnidadMedida']);
        if (response.data['UnidadMedida'] == "ABSOLUTO"){
            $("#d-descripcionunidadmedida_fin").removeClass("d-none");
            $("#descripcionunidadmedida_fin").val(response.data['DescripAbsoluto']);
        }else{
            $("#d-descripcionunidadmedida_fin").addClass("d-none");
            $("#descripcionunidadmedida_fin").val("");
        }        

        $("#selectfrecuencia_fin").selectpicker("val", response.data['Frecuencia']);
        $("#metaanual_fin").val(response.data['MetaAnual']);
        $("#lineabase_fin1").val(response.data['LineaBase']);
        $("#ejecerciciofisca_fin").selectpicker("val", "2021");
        $("#variable1numerador_fin").val(Func_FormatoMoneda(response.data['ValorNumerador'],2));
        $("#variable2numerador_fin").val(Func_FormatoMoneda(response.data['ValorDenominador'],2));
        $("#lineabaseV1_fin").val(response.data['LineaBaseV1']);
        $("#lineabaseV2_fin").val(response.data['LineaBaseV2']);
        $("#mediosverificacion_fin").val(response.data['MediosVerificacion']);
        $("#fuentesinformacion_fin").val(response.data['FuenteInformacion']);
        $("#supuestos_fin").val(response.data['Supuestos']);

        $(`input[name=claridad_fin][value="${response.data['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=relevancia_fin][value="${response.data['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=economia_fin][value="${response.data['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=monitoreable_fin][value="${response.data['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=adecuado_fin][value="${response.data['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=aportemarginal_fin][value="${response.data['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);


        $("#select_sentidoindicador_fin").selectpicker("val", response.data['SentidoIndicador']);
        $("#select_tipoindicador_fin").selectpicker("val", response.data['TipoIndicador']);
        $("#select_dimensionindicador_fin").selectpicker("val", response.data['DimensionIndicador']);
        $("#select_unidadresponsablereportar_fin").selectpicker("val", response.data['UnidadResponsable']);
        
        $("#descripcionindicador_fin").val(response.data['DescripcionIndicador']);
        $("#descripcionnumerador_fin").val(response.data['DescripcionNumerador']);
        $("#descripciondenominador_fin").val(response.data['DescripcionDenominador']);
        GetMirProposito();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMirProposito() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirProposito(request)
        .then(ResponseGetMirProposito);
}

function ResponseGetMirProposito(response) {
    if (!response.error) {
        $("#claseprogramatica_proposito").val(response.data['ClasProgramatica']);
        $("#proposito_proposito").val(response.data['Proposito']);
        $("#claveindicador_proposito").val(response.data['ClaveIndicador']);
        $("#nombreindicar_proposito").val(response.data['Indicador']);
        $("#descripcionformula_proposito").val(response.data['Formula']);
        $("#variable1_proposito").val(response.data['V1']);
        $("#variable2_proposito").val(response.data['V2']);
        $("#variable3_proposito").val(response.data['FormulaV1V2']);

        $("#select_unidadmedida_proposito").selectpicker("val", response.data['UnidadMedida']);
        if (response.data['UnidadMedida'] == "ABSOLUTO"){
            $("#d-descripcionunidadmedida_proposito").removeClass("d-none");
            $("#descripcionunidadmedida_proposito").val(response.data['DescripAbsoluto']);
        }else{
            $("#d-descripcionunidadmedida_proposito").addClass("d-none");
            $("#descripcionunidadmedida_proposito").val("");
        }

        $("#selectfrecuencia_proposito").selectpicker("val", response.data['Frecuencia']);
        $("#metaanual_proposito").val(response.data['MetaAnual']);
        $("#lineabase_proposito1").val(response.data['LineaBase']);
        $("#ejecerciciofisca_proposito").selectpicker("val", "2021");
        $("#variable1numerador_proposito").val(Func_FormatoMoneda(response.data['ValorNumerador'],2));
        $("#variable2numerador_proposito").val(Func_FormatoMoneda(response.data['ValorDenominador'],2));
        $("#lineabaseV1_proposito").val(response.data['LineaBaseV1']);
        $("#lineabaseV2_proposito").val(response.data['LineaBaseV2']);
        $("#mediosverificacion_proposito").val(response.data['MediosVerificacion']);
        $("#fuentesinformacion_proposito").val(response.data['FuenteInformacion']);
        $("#supuestos_proposito").val(response.data['Supuestos']);

        $(`input[name=claridad_proposito][value="${response.data['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=relevancia_proposito][value="${response.data['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=economia_proposito][value="${response.data['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=monitoreable_proposito][value="${response.data['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=adecuado_proposito][value="${response.data['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=aportemarginal_proposito][value="${response.data['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);


        $("#select_sentidoindicador_proposito").selectpicker("val", response.data['SentidoIndicador']);
        $("#select_tipoindicador_proposito").selectpicker("val", response.data['TipoIndicador']);
        $("#select_dimensionindicador_proposito").selectpicker("val", response.data['DimensionIndicador']);
        $("#select_unidadresponsablereportar_proposito").selectpicker("val", response.data['UnidadResponsable']);
        
        $("#descripcionindicador_proposito").val(response.data['DescripcionIndicador']);
        $("#descripcionnumerador_proposito").val(response.data['DescripcionNumerador']);
        $("#descripciondenominador_proposito").val(response.data['DescripcionDenominador']);

        GetMirComponentes();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMirComponentes() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirComponentes(request)
        .then(ResponseGetMirComponentes);
}

function ResponseGetMirComponentes(response) {
    if (!response.error) {
        info_componentes = response.data;
        $("#claseprogramatica_componente").val(response.data[index_componente]['ClasProgramatica']);
        $("#id_componente").val(response.data[index_componente]['idComponente']);
        $("#nombre_componente").val(response.data[index_componente]['Componente']);
        $("#id_componenteactividad").val(response.data[index_componente]['idComponente']);
        $("#nombre_componenteactividad").val(response.data[index_componente]['Componente']);
        $("#claveindicador_componente").val(response.data[index_componente]['ClaveIndicador']);
        $("#nombreindicar_componente").val(response.data[index_componente]['Indicador']);
        $("#descripcionformula_componente").val(response.data[index_componente]['Formula']);
        $("#variable1_componente").val(response.data[index_componente]['V1']);
        $("#variable2_componente").val(response.data[index_componente]['V2']);
        $("#variable3_componente").val(response.data[index_componente]['FormulaV1V2']);

        $("#select_unidadmedida_componente").selectpicker("val", response.data[index_componente]['UnidadMedida']);
        if (response.data[index_componente]['UnidadMedida'] == "ABSOLUTO"){
            $("#d-descripcionunidadmedida_componente").removeClass("d-none");
            $("#descripcionunidadmedida_componente").val(response.data['DescripAbsoluto']);
        }else{
            $("#d-descripcionunidadmedida_componente").addClass("d-none");
            $("#descripcionunidadmedida_componente").val("");
        }

        $("#selectfrecuencia_componente").selectpicker("val", response.data[index_componente]['Frecuencia']);
        if (response.data[index_componente]['Frecuencia'] == "SEMESTRAL"){
            $(".d-trimestral-componente").addClass("d-none");
            $(".d-metasemestral-componente").removeClass("d-none");
        }else if (response.data[index_componente]['Frecuencia'] == "TRIMESTRAL"){
            $(".d-metasemestral-componente").addClass("d-none");
            $(".d-trimestral-componente").removeClass("d-none");
        }

        $("#metaanual_componente").val(response.data[index_componente]['MetaAnual']);
        $("#lineabase_componente1").val(response.data[index_componente]['LineaBase']);
        $("#lineabaseV1_componente").val(response.data[index_componente]['LineaBaseV1']);
        $("#lineabaseV2_componente").val(response.data[index_componente]['LineaBaseV2']);
        $("#ejecerciciofisca_componente").selectpicker("val", "2021");

        $("#variableV1_componente").val(response.data[index_componente]['ValorNumerador']);
        $("#variableV2_componente").val(response.data[index_componente]['ValorDenominador']);
        
        // Trimestral
        $("#metatrimestral1_componente").val(response.data[index_componente]['MetaTrimestre1']);
        $("#metatrimestral2_componente").val(response.data[index_componente]['MetaTrimestre2']);
        $("#metatrimestral3_componente").val(response.data[index_componente]['MetaTrimestre3']);
        $("#metatrimestral4_componente").val(response.data[index_componente]['MetaTrimestre4']);
        $("#metatrimestral1V1D_componente").val(response.data[index_componente]['Trimestre1V1']);
        $("#metatrimestral1V1A_componente").val(response.data[index_componente]['']);
        $("#metatrimestral1V2D_componente").val(response.data[index_componente]['Trimestre1V2']);
        $("#metatrimestral1V2A_componente").val(response.data[index_componente]['']);

        $("#metatrimestral2V1D_componente").val(response.data[index_componente]['Trimestre2V1']);
        $("#metatrimestral2V1A_componente").val(response.data[index_componente]['']);
        $("#metatrimestral2V2D_componente").val(response.data[index_componente]['Trimestre2V2']);
        $("#metatrimestral2V2A_componente").val(response.data[index_componente]['']);

        $("#metatrimestral3V1D_componente").val(response.data[index_componente]['Trimestre3V1']);
        $("#metatrimestral3V1A_componente").val(response.data[index_componente]['']);
        $("#metatrimestral3V2D_componente").val(response.data[index_componente]['Trimestre3V2']);
        $("#metatrimestral3V2A_componente").val(response.data[index_componente]['']);

        $("#metatrimestral4V1D_componente").val(response.data[index_componente]['Trimestre4V1']);
        $("#metatrimestral4V1A_componente").val(response.data[index_componente]['']);
        $("#metatrimestral4V2D_componente").val(response.data[index_componente]['Trimestre4V2']);
        $("#metatrimestral4V2A_componente").val(response.data[index_componente]['']);

        // Semestral
        $("#metasemestral1_componente").val(response.data[index_componente]['MetaSemestre1']);
        $("#metasemestral2_componente").val(response.data[index_componente]['MetaSemestre2']);
        $("#metasemestral1V1D_componente").val(response.data[index_componente]['Semestre1V1']);
        $("#metasemestral1V1A_componente").val(response.data[index_componente]['']);
        $("#metasemestral2V1D_componente").val(response.data[index_componente]['Semestre2V1']);
        $("#metasemestral2V1A_componente").val(response.data[index_componente]['']);
        $("#metasemestral1V2D_componente").val(response.data[index_componente]['Semestre1V2']);
        $("#metasemestral1V2A_componente").val(response.data[index_componente]['']);
        $("#metasemestral2V2D_componente").val(response.data[index_componente]['Semestre2V2']);
        $("#metasemestral2V2A_componente").val(response.data[index_componente]['']);

        $("#mediosverificacion_componente").val(response.data[index_componente]['MediosVerificacion']);
        $("#fuentesinformacion_componente").val(response.data[index_componente]['FuenteInformacion']);
        $("#supuestos_componente").val(response.data[index_componente]['Supuestos']);

        $(`input[name=claridad_componente][value="${response.data[index_componente]['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=relevancia_componente][value="${response.data[index_componente]['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=economia_componente][value="${response.data[index_componente]['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=monitoreable_componente][value="${response.data[index_componente]['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=adecuado_componente][value="${response.data[index_componente]['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=aportemarginal_componente][value="${response.data[index_componente]['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);

        $("#select_sentidoindicador_componente").selectpicker("val", response.data[index_componente]['SentidoIndicador']);
        $("#select_tipoindicador_componente").selectpicker("val", response.data[index_componente]['TipoIndicador']);
        $("#select_dimensionindicador_componente").selectpicker("val", response.data[index_componente]['DimensionIndicador']);
        $("#select_unidadresponsablereportar_componente").selectpicker("val", response.data[index_componente]['UnidadResponsable']);

        $("#descripcionindicador_componente").val(response.data[index_componente]['DescripcionIndicador']);
        $("#descripcionnumerador_componente").val(response.data[index_componente]['DescripcionNumerador']);
        $("#descripciondenominador_componente").val(response.data[index_componente]['DescripcionDenominador']);

        GetMirActividades();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMirActividades() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirActividades(request)
        .then(ResponseGetMirActividades);
}

function ResponseGetMirActividades(response) {
    if (!response.error) {

        info_actividades = response.data.reduce((acumulador, item) => {
            const idComponente = item.idComponente;
            if (!acumulador[idComponente]) {
                acumulador[idComponente] = {
                    componente: idComponente,
                    items: []
                };
            }
            acumulador[idComponente].items.push(item);
            return acumulador;
        }, {});
        
        let id_componente = $("#id_componente").val();
        $("#claseprogramatica_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ClasProgramatica']);
        $("#idcomponente_actividad").val(info_actividades[id_componente]['items'][index_actividad]['idComponente']);
        $("#id_actividad").val(info_actividades[id_componente]['items'][index_actividad]['idActividad']);
        $("#nombre_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Actividad']);
        $("#claveindicador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ClaveIndicador']);
        $("#nombreindicar_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Indicador']);
        $("#descripcionformula_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Formula']);
        $("#variable1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['V1']);
        $("#variable2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['V2']);
        $("#variable3_actividad").val(info_actividades[id_componente]['items'][index_actividad]['FormulaV1V2']);

        $("#select_unidadmedida_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['UnidadMedida']);
        if (info_actividades[id_componente]['items'][index_actividad]['UnidadMedida'] == "ABSOLUTO"){
            $("#d-descripcionunidadmedida_actividad").removeClass("d-none");
            $("#descripcionunidadmedida_actividad").val(response.data['DescripAbsoluto']);
        }else{
            $("#d-descripcionunidadmedida_actividad").addClass("d-none");
            $("#descripcionunidadmedida_actividad").val("");
        }

        $("#selectfrecuencia_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['Frecuencia']);
        if (info_actividades[id_componente]['items'][index_actividad]['Frecuencia'] == "SEMESTRAL"){
            $(".d-trimestral-actividad").addClass("d-none");
            $(".d-metasemestral-actividad").removeClass("d-none");
        }else if (info_actividades[id_componente]['items'][index_actividad]['Frecuencia'] == "TRIMESTRAL"){
            $(".d-metasemestral-actividad").addClass("d-none");
            $(".d-trimestral-actividad").removeClass("d-none");
        }
        
        $("#metaanual_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaAnual']);
        $("#lineabase_actividad1").val(info_actividades[id_componente]['items'][index_actividad]['LineaBase']);
        $("#ejecerciciofisca_actividad").selectpicker("val", "2021");

        $("#variableV1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ValorNumerador']);
        $("#variableV2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['ValorDenominador']);

        // Trimestral
        $("#metatrimestral1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre1']);
        $("#metatrimestral2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre2']);
        $("#metatrimestral3_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre3']);
        $("#metatrimestral4_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaTrimestre4']);
        $("#metatrimestral1V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre1V1']);
        $("#metatrimestral1V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
        $("#metatrimestral1V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre1V2']);
        $("#metatrimestral1V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

        $("#metatrimestral2V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre2V1']);
        $("#metatrimestral2V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
        $("#metatrimestral2V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre2V2']);
        $("#metatrimestral2V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

        $("#metatrimestral3V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre3V1']);
        $("#metatrimestral3V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
        $("#metatrimestral3V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre3V2']);
        $("#metatrimestral3V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

        $("#metatrimestral4V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre4V1']);
        $("#metatrimestral4V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
        $("#metatrimestral4V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Trimestre4V2']);
        $("#metatrimestral4V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

        // Semestral
        $("#metasemestral1_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaSemestre1']);
        $("#metasemestral2_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MetaSemestre2']);
        $("#metasemestral1V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre1V1']);
        $("#metasemestral1V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
        $("#metasemestral2V1D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre2V1']);
        $("#metasemestral2V1A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
        $("#metasemestral1V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre1V2']);
        $("#metasemestral1V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);
        $("#metasemestral2V2D_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Semestre2V2']);
        $("#metasemestral2V2A_actividad").val(info_actividades[id_componente]['items'][index_actividad]['']);

        $("#mediosverificacion_actividad").val(info_actividades[id_componente]['items'][index_actividad]['MediosVerificacion']);
        $("#fuentesinformacion_actividad").val(info_actividades[id_componente]['items'][index_actividad]['FuenteInformacion']);
        $("#supuestos_actividad").val(info_actividades[id_componente]['items'][index_actividad]['Supuestos']);

        $(`input[name=claridad_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=relevancia_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=economia_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=monitoreable_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=adecuado_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
        $(`input[name=aportemarginal_actividad][value="${info_actividades[id_componente]['items'][index_actividad]['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);

        $("#select_sentidoindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['SentidoIndicador']);
        $("#select_tipoindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['TipoIndicador']);
        $("#select_dimensionindicador_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['DimensionIndicador']);
        $("#select_unidadresponsablereportar_actividad").selectpicker("val", info_actividades[id_componente]['items'][index_actividad]['UnidadResponsable']);

        $("#descripcionindicador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionIndicador']);
        $("#descripcionnumerador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionNumerador']);
        $("#descripciondenominador_actividad").val(info_actividades[id_componente]['items'][index_actividad]['DescripcionDenominador']);
        
        
        GetMirAutoriaCarga();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMirAutoriaCarga() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirAutoriaCarga(request)
        .then(ResponseGetMirAutoriaCarga);
}

function ResponseGetMirAutoriaCarga(response){
    if (!response.error) {
        DestroyDataTable("table-auditoriacarga");
        $("#table-auditoriacarga > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table-auditoriacarga > tbody").append(`
                    <tr>
                        <td>${response.data[i].Seccion}</td>
                        <td>${response.data[i].Elemento}</td>
                        <td>${response.data[i].Descripcion}</td>
                    </tr>
                `);
            }
        }
        Func_DataTable("table-auditoriacarga");
        GetMirAutoriaFormulas();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMirAutoriaFormulas() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirAutoriaFormulas(request)
        .then(ResponseGetMirAutoriaFormulas);
}

function ResponseGetMirAutoriaFormulas(response){
    if (!response.error) {
        DestroyDataTable("table-auditoriaformulas");
        $("#table-auditoriaformulas > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table-auditoriaformulas > tbody").append(`
                    <tr>
                        <td></td>
                        <td>${response.data[i].Seccion}</td>
                        <td>${response.data[i].Elemento}</td>
                        <td>${response.data[i].Descripcion}</td>
                        <td>${response.data[i].ValorOriginal}</td>
                        <td>${response.data[i].ValorModificado}</td>
                    </tr>
                `);
            }
        }
        Func_DataTable("table-auditoriaformulas");
        $("#Modal").modal("show");
        swal.close();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function BtnGuardarMir(){
    $("#BtnGuardar").on("click", function(event) {
        event.preventDefault();

        var request = {
            caratula: Func_GetRequestCaratual(),
            fin: Func_GetRequestFin(),
            proposito: Func_GetRequestProposito(),
            componente: Func_GetRequestComponente(),
            actividad: Func_GetRequestActividad()
        };
        
        Func_Cargando();
        repository.Mir.SaveMir(request)
        .then(ResponseSaveMir);

        // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de la MIR?", "question", "Aceptar", "Cancelar", function(response) {
        //     if (response) {
        //         Func_Cargando();
        //         repository.Mir.SaveMir(request)
        //             .then(ResponseSaveMir);
        //     }
        // });
    });
}

function Func_GetRequestCaratual() {
    var request_caratula = {
        consecutivo_caratula: $("#consecutivo_caratula").val(),
        conac_caratula: $("#conac_caratula").val(),
        select_entepublido: $("#select_entepublido").val(),
        select_uaresponsable: $("#select_uaresponsable").val(),
        nombre_pp: $("#nombre_pp").val(),
        clave_programatica: $("#clave_programatica").val(),
        ejercicio_fiscal: $("#ejercicio_fiscal").val(),
        select_ejeped: $("#select_ejeped").val(),
        select_temaped: $("#select_temaped").val(),
        select_objetivo: $("#select_objetivo").val(),
        select_estrategia: $("#select_estrategia").val(),
        select_lineaaccion1: $("#select_lineaaccion1").val(),
        select_lineaaccion2: $("#select_lineaaccion2").val(),
        programa_sectorial: $("#programa_sectorial").val(),
        select_tipobeneficiario: $("#select_tipobeneficiario").val(),
        select_descripcionampliabeneficiario1: $("#select_descripcionampliabeneficiario1").val(),
        select_descripcionampliabeneficiario2: $("#select_descripcionampliabeneficiario2").val()
    }

    return request_caratula;
}

function Func_GetRequestFin() {
    var request_fin = {
        fin_fin: $("#fin_fin").val(),
        claseprogramatica_fin: $("#claseprogramatica_fin").val(),
        claveindicador_fin: $("#claveindicador_fin").val(),
        nombreindicar_fin: $("#nombreindicar_fin").val(),
        descripcionformula_fin: $("#descripcionformula_fin").val(),
        variable1_fin: $("#variable1_fin").val(),
        variable2_fin: $("#variable2_fin").val(),
        variable3_fin: $("#variable3_fin").val(),
        select_unidadmedida_fin: $("#select_unidadmedida_fin").val(),
        descripcionunidadmedida_fin: $("#descripcionunidadmedida_fin").val(),
        selectfrecuencia_fin: $("#selectfrecuencia_fin").val(),
        metaanual_fin: $("#metaanual_fin").val(),
        ejecerciciofisca_fin: $("#ejecerciciofisca_fin").val(),
        lineabase_fin1: $("#lineabase_fin1").val(),
        variable1numerador_fin: $("#variable1numerador_fin").val(),
        variable2numerador_fin: $("#variable2numerador_fin").val(),
        lineabaseV1_fin: $("#lineabaseV1_fin").val(),
        lineabaseV2_fin: $("#lineabaseV2_fin").val(),
        mediosverificacion_fin: $("#mediosverificacion_fin").val(),
        fuentesinformacion_fin: $("#fuentesinformacion_fin").val(),
        supuestos_fin: $("#supuestos_fin").val(),
        select_sentidoindicador_fin: $("#select_sentidoindicador_fin").val(),
        select_tipoindicador_fin: $("#select_tipoindicador_fin").val(),
        select_dimensionindicador_fin: $("#select_dimensionindicador_fin").val(),
        claridad_fin: $('input[name=claridad_fin]:checked').val(),
        relevancia_fin: $('input[name=relevancia_fin]:checked').val(),
        economia_fin: $('input[name=economia_fin]:checked').val(),
        monitoreable_fin: $('input[name=monitoreable_fin]:checked').val(),
        adecuado_fin: $('input[name=adecuado_fin]:checked').val(),
        aportemarginal_fin: $('input[name=aportemarginal_fin]:checked').val(),
        select_unidadresponsablereportar_fin: $("#select_unidadresponsablereportar_fin").val(),
        descripcionindicador_fin: $("#descripcionindicador_fin").val(),
        descripcionnumerador_fin: $("#descripcionnumerador_fin").val(),
        descripciondenominador_fin: $("#descripciondenominador_fin").val()
    }

    return request_fin;
}

function Func_GetRequestProposito() {
    var request_proposito = {
        claseprogramatica_proposito: $("#claseprogramatica_proposito").val(),
        proposito_proposito:$("#proposito_proposito").val(),
        claveindicador_proposito: $("#claveindicador_proposito").val(),
        nombreindicar_proposito: $("#nombreindicar_proposito").val(),
        descripcionformula_proposito: $("#descripcionformula_proposito").val(),
        variable1_proposito: $("#variable1_proposito").val(),
        variable2_proposito: $("#variable2_proposito").val(),
        variable3_proposito: $("#variable3_proposito").val(),
        select_unidadmedida_proposito: $("#select_unidadmedida_proposito").val(),
        descripcionunidadmedida_proposito: $("#descripcionunidadmedida_proposito").val(),
        selectfrecuencia_proposito: $("#selectfrecuencia_proposito").val(),
        metaanual_proposito: $("#metaanual_proposito").val(),
        ejecerciciofisca_proposito: $("#ejecerciciofisca_proposito").val(),
        lineabase_proposito1: $("#lineabase_proposito1").val(),
        variable1numerador_proposito: $("#variable1numerador_proposito").val(),
        variable2numerador_proposito: $("#variable2numerador_proposito").val(),
        lineabaseV1_proposito: $("#lineabaseV1_proposito").val(),
        lineabaseV2_proposito: $("#lineabaseV2_proposito").val(),
        mediosverificacion_proposito: $("#mediosverificacion_proposito").val(),
        fuentesinformacion_proposito: $("#fuentesinformacion_proposito").val(),
        supuestos_proposito: $("#supuestos_proposito").val(),
        select_sentidoindicador_proposito: $("#select_sentidoindicador_proposito").val(),
        select_tipoindicador_proposito: $("#select_tipoindicador_proposito").val(),
        select_dimensionindicador_proposito: $("#select_dimensionindicador_proposito").val(),
        claridad_proposito: $('input[name=claridad_proposito]:checked').val(),
        relevancia_proposito: $('input[name=relevancia_proposito]:checked').val(),
        economia_proposito: $('input[name=economia_proposito]:checked').val(),
        monitoreable_proposito: $('input[name=monitoreable_proposito]:checked').val(),
        adecuado_proposito: $('input[name=adecuado_proposito]:checked').val(),
        aportemarginal_proposito: $('input[name=aportemarginal_proposito]:checked').val(),
        select_unidadresponsablereportar_proposito: $("#select_unidadresponsablereportar_proposito").val(),
        descripcionindicador_proposito: $("#descripcionindicador_proposito").val(),
        descripcionnumerador_proposito: $("#descripcionnumerador_proposito").val(),
        descripciondenominador_proposito: $("#descripciondenominador_proposito").val()
    }

    return request_proposito;
}

function Func_GetRequestComponente() {
    var request_componente = {
        claseprogramatica_componente: $("#claseprogramatica_componente").val(),
        id_componente: $("#id_componente").val(),
        nombre_componente: $("#nombre_componente").val(),
        nombre_componenteactividad: $("#nombre_componenteactividad").val(),
        claveindicador_componente: $("#claveindicador_componente").val(),
        nombreindicar_componente: $("#nombreindicar_componente").val(),
        descripcionformula_componente: $("#descripcionformula_componente").val(),
        variable1_componente: $("#variable1_componente").val(),
        variable2_componente: $("#variable2_componente").val(),
        variable3_componente: $("#variable3_componente").val(),
        select_unidadmedida_componente: $("#select_unidadmedida_componente").val(),
        descripcionunidadmedida_componente: $("#descripcionunidadmedida_componente").val(),
        ejecerciciofisca_componente: $("#ejecerciciofisca_componente").val(),
        lineabase_componente1: $("#lineabase_componente1").val(),
        lineabaseV1_componente: $("#lineabaseV1_componente").val(),
        lineabaseV2_componente: $("#lineabaseV2_componente").val(),
        metaanual_componente: $("#metaanual_componente").val(),
        selectfrecuencia_componente: $("#selectfrecuencia_componente").val(),
        metasemestral1_componente: $("#metasemestral1_componente").val(),
        metasemestral2_componente: $("#metasemestral2_componente").val(),
        metatrimestral1_componente: $("#metatrimestral1_componente").val(),
        metatrimestral2_componente: $("#metatrimestral2_componente").val(),
        metatrimestral3_componente: $("#metatrimestral3_componente").val(),
        metatrimestral4_componente: $("#metatrimestral4_componente").val(),
        variableV1_componente: $("#variableV1_componente").val(),
        metasemestral1V1D_componente: $("#metasemestral1V1D_componente").val(),
        metasemestral1V1A_componente: $("#metasemestral1V1A_componente").val(),
        metasemestral2V1D_componente: $("#metasemestral2V1D_componente").val(),
        metasemestral2V1A_componente: $("#metasemestral2V1A_componente").val(),
        metatrimestral1V1D_componente: $("#metatrimestral1V1D_componente").val(),
        metatrimestral1V1A_componente: $("#metatrimestral1V1A_componente").val(),
        metatrimestral2V1D_componente: $("#metatrimestral2V1D_componente").val(),
        metatrimestral2V1A_componente: $("#metatrimestral2V1A_componente").val(),
        metatrimestral3V1D_componente: $("#metatrimestral3V1D_componente").val(),
        metatrimestral3V1A_componente: $("#metatrimestral3V1A_componente").val(),
        metatrimestral4V1D_componente: $("#metatrimestral4V1D_componente").val(),
        metatrimestral4V1A_componente: $("#metatrimestral4V1A_componente").val(),
        variableV2_componente: $("#variableV2_componente").val(),
        metasemestral1V2D_componente: $("#metasemestral1V2D_componente").val(),
        metasemestral1V2A_componente: $("#metasemestral1V2A_componente").val(),
        metasemestral2V2D_componente: $("#metasemestral2V2D_componente").val(),
        metasemestral2V2A_componente: $("#metasemestral2V2A_componente").val(),
        metatrimestral1V2D_componente: $("#metatrimestral1V2D_componente").val(),
        metatrimestral1V2A_componente: $("#metatrimestral1V2A_componente").val(),
        metatrimestral2V2D_componente: $("#metatrimestral2V2D_componente").val(),
        metatrimestral2V2A_componente: $("#metatrimestral2V2A_componente").val(),
        metatrimestral3V2D_componente: $("#metatrimestral3V2D_componente").val(),
        metatrimestral3V2A_componente: $("#metatrimestral3V2A_componente").val(),
        metatrimestral4V2D_componente: $("#metatrimestral4V2D_componente").val(),
        metatrimestral4V2A_componente: $("#metatrimestral4V2A_componente").val(),
        mediosverificacion_componente: $("#mediosverificacion_componente").val(),
        fuentesinformacion_componente: $("#fuentesinformacion_componente").val(),
        supuestos_componente: $("#supuestos_componente").val(),
        select_sentidoindicador_componente: $("#select_sentidoindicador_componente").val(),
        select_tipoindicador_componente: $("#select_tipoindicador_componente").val(),
        select_dimensionindicador_componente: $("#select_dimensionindicador_componente").val(),
        claridad_componente: $('input[name=claridad_componente]:checked').val(),
        relevancia_componente: $('input[name=relevancia_componente]:checked').val(),
        economia_componente: $('input[name=economia_componente]:checked').val(),
        monitoreable_componente: $('input[name=monitoreable_componente]:checked').val(),
        adecuado_componente: $('input[name=adecuado_componente]:checked').val(),
        aportemarginal_componente: $('input[name=aportemarginal_componente]:checked').val(),
        select_unidadresponsablereportar_componente: $("#select_unidadresponsablereportar_componente").val(),
        descripcionindicador_componente: $("#descripcionindicador_componente").val(),
        descripcionnumerador_componente: $("#descripcionnumerador_componente").val(),
        descripciondenominador_componente: $("#descripciondenominador_componente").val()
    }

    return request_componente;
}

function Func_GetRequestActividad() {
    var request_actividad = {
        claseprogramatica_actividad : $("#claseprogramatica_actividad").val(),
        idcomponente_actividad : $("#idcomponente_actividad").val(),
        id_actividad: $("#id_actividad").val(),
        nombre_actividad: $("#nombre_actividad").val(),
        claveindicador_actividad: $("#claveindicador_actividad").val(),
        nombreindicar_actividad: $("#nombreindicar_actividad").val(),
        descripcionformula_actividad: $("#descripcionformula_actividad").val(),
        variable1_actividad: $("#variable1_actividad").val(),
        variable2_actividad: $("#variable2_actividad").val(),
        variable3_actividad: $("#variable3_actividad").val(),
        select_unidadmedida_actividad: $("#select_unidadmedida_actividad").val(),
        descripcionunidadmedida_actividad: $("#descripcionunidadmedida_actividad").val(),
        ejecerciciofisca_actividad: $("#ejecerciciofisca_actividad").val(),
        lineabase_actividad1: $("#lineabase_actividad1").val(),
        lineabaseV1_actividad: $("#lineabaseV1_actividad").val(),
        lineabaseV2_actividad: $("#lineabaseV2_actividad").val(),
        metaanual_actividad: $("#metaanual_actividad").val(),
        selectfrecuencia_actividad: $("#selectfrecuencia_actividad").val(),
        metasemestral1_actividad: $("#metasemestral1_actividad").val(),
        metasemestral2_actividad: $("#metasemestral2_actividad").val(),
        metatrimestral1_actividad: $("#metatrimestral1_actividad").val(),
        metatrimestral2_actividad: $("#metatrimestral2_actividad").val(),
        metatrimestral3_actividad: $("#metatrimestral3_actividad").val(),
        metatrimestral4_actividad: $("#metatrimestral4_actividad").val(),
        variableV1_actividad: $("#variableV1_actividad").val(),
        metasemestral1V1D_actividad: $("#metasemestral1V1D_actividad").val(),
        metasemestral1V1A_actividad: $("#metasemestral1V1A_actividad").val(),
        metasemestral2V1D_actividad: $("#metasemestral2V1D_actividad").val(),
        metasemestral2V1A_actividad: $("#metasemestral2V1A_actividad").val(),
        metatrimestral1V1D_actividad: $("#metatrimestral1V1D_actividad").val(),
        metatrimestral1V1A_actividad: $("#metatrimestral1V1A_actividad").val(),
        metatrimestral2V1D_actividad: $("#metatrimestral2V1D_actividad").val(),
        metatrimestral2V1A_actividad: $("#metatrimestral2V1A_actividad").val(),
        metatrimestral3V1D_actividad: $("#metatrimestral3V1D_actividad").val(),
        metatrimestral3V1A_actividad: $("#metatrimestral3V1A_actividad").val(),
        metatrimestral4V1D_actividad: $("#metatrimestral4V1D_actividad").val(),
        metatrimestral4V1A_actividad: $("#metatrimestral4V1A_actividad").val(),
        variableV2_actividad: $("#variableV2_actividad").val(),
        metasemestral1V2D_actividad: $("#metasemestral1V2D_actividad").val(),
        metasemestral1V2A_actividad: $("#metasemestral1V2A_actividad").val(),
        metasemestral2V2D_actividad: $("#metasemestral2V2D_actividad").val(),
        metasemestral2V2A_actividad: $("#metasemestral2V2A_actividad").val(),
        metatrimestral1V2D_actividad: $("#metatrimestral1V2D_actividad").val(),
        metatrimestral1V2A_actividad: $("#metatrimestral1V2A_actividad").val(),
        metatrimestral2V2D_actividad: $("#metatrimestral2V2D_actividad").val(),
        metatrimestral2V2A_actividad: $("#metatrimestral2V2A_actividad").val(),
        metatrimestral3V2D_actividad: $("#metatrimestral3V2D_actividad").val(),
        metatrimestral3V2A_actividad: $("#metatrimestral3V2A_actividad").val(),
        metatrimestral4V2D_actividad: $("#metatrimestral4V2D_actividad").val(),
        metatrimestral4V2A_actividad: $("#metatrimestral4V2A_actividad").val(),
        mediosverificacion_actividad: $("#mediosverificacion_actividad").val(),
        fuentesinformacion_actividad: $("#fuentesinformacion_actividad").val(),
        supuestos_actividad: $("#supuestos_actividad").val(),
        select_sentidoindicador_actividad: $("#select_sentidoindicador_actividad").val(),
        select_tipoindicador_actividad: $("#select_tipoindicador_actividad").val(),
        select_dimensionindicador_actividad: $("#select_dimensionindicador_actividad").val(),
        claridad_actividad: $('input[name=claridad_actividad]:checked').val(),
        relevancia_actividad: $('input[name=relevancia_actividad]:checked').val(),
        economia_actividad: $('input[name=economia_actividad]:checked').val(),
        monitoreable_actividad: $('input[name=monitoreable_actividad]:checked').val(),
        adecuado_actividad: $('input[name=adecuado_actividad]:checked').val(),
        aportemarginal_actividad: $('input[name=aportemarginal_actividad]:checked').val(),
        select_unidadresponsablereportar_actividad: $("#select_unidadresponsablereportar_actividad").val(),
        descripcionindicador_actividad: $("#descripcionindicador_actividad").val(),
        descripcionnumerador_actividad: $("#descripcionnumerador_actividad").val(),
        descripciondenominador_actividad: $("#descripciondenominador_actividad").val()
    }

    return request_actividad;
}

function ResponseSaveMir(response) {
    swal.close();
    if (!response.error) {
        info_componentes = null;
        info_actividades = null;

        info_componentes = response.actual.componente;
        info_actividades = response.actual.actividad.reduce((acumulador, item) => {
            const idComponente = item.idComponente;
            if (!acumulador[idComponente]) {
                acumulador[idComponente] = {
                    componente: idComponente,
                    items: []
                };
            }
            acumulador[idComponente].items.push(item);
            return acumulador;
        }, {});
        // Func_Aviso("Información guardada", "La información ha sido guardada exitosamente.", "success");
        Func_Toast("success", "MIR Editada.", "La Información de la MIR ha sido guardada.");
    } else {
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

// ======================================================
// Funciones
// ======================================================

function Func_LimpiarModal() {
    $(".form-control").val("");
    $(".form-control").removeClass("is-invalid");
    $(".form-control").removeClass("is-valid");
}


