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
var info_auditoriaformulas = null;

var array_logformulas = Array();
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
    maskNumber();
    Func_Cargando();
    GetSecretarias();
}

function maskNumber(){
    $('.number').maskMoney({
        allowNegative: true,
        thousands:',', 
        decimal:'.',
        affixesStay: false
    });
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
    SeleccionarTablaFormulas();
    OnChange_Secretaria();
    OnChange_UnidadAdministrativa();
    OnChange_UnidadMedida();
    OnChange_SelectFrecuencia();

    OnClic_TabsInternas();
    OnClic_TabsComponentes();
    OnClic_TabsActividades();

    BtnEditarMir();
    BtnGuardarMir();
    BtnValidarMir();
    BtnEliminarLogFormula();

    OnBlur_MetaT1V1D_Componente();
    OnBlur_MetaT2V1D_Componente();
    OnBlur_MetaT3V1D_Componente();
    OnBlur_MetaT4V1D_Componente();
    OnBlur_MetaT1V2D_Componente();
    OnBlur_MetaT2V2D_Componente();
    OnBlur_MetaT3V2D_Componente();
    OnBlur_MetaT4V2D_Componente();

    OnBlur_MetaS1V1D_Componente();
    OnBlur_MetaS2V1D_Componente();
    OnBlur_MetaS1V2D_Componente();
    OnBlur_MetaS2V2D_Componente();

    OnBlur_MetaT1V1D_Actividad();
    OnBlur_MetaT2V1D_Actividad();
    OnBlur_MetaT3V1D_Actividad();
    OnBlur_MetaT4V1D_Actividad();
    OnBlur_MetaT1V2D_Actividad();
    OnBlur_MetaT2V2D_Actividad();
    OnBlur_MetaT3V2D_Actividad();
    OnBlur_MetaT4V2D_Actividad();

    MetaT1V12_Componente();
    MetaT2V12_Componente();
    MetaT3V12_Componente();
    MetaT4V12_Componente();

    MetaT1V12_Actividad();
    MetaT2V12_Actividad();
    MetaT3V12_Actividad();
    MetaT4V12_Actividad();
    MetaS2V12_Componente();
    MetaS1V12_Componente();

    MetaS12Anual_Componente();
    MetaT12Anual_Componente();
    MetaT12Anual_Actividad();

    LineaBase_Fin();
    LineaBase_Proposito();
    LineaBase_Componente();
    LineaBase_Actividad();

    OnClic_DenominadorFijo();
    
}

function OnClic_DenominadorFijo() {
    $(".denominadorfijo").on("click", function() {
        var tipo = $(this).data("tipo");
        
        if ($(`#clicDenominador_${tipo}`).val() == 0){
            $(`#checkDenominadorFijo_${tipo}`).removeClass("DenominadorFijoInactivo");
            $(`#checkDenominadorFijo_${tipo}`).addClass("DenominadorFijoActivo");
            $(`#clicDenominador_${tipo}`).val(1);
        }else{
            $(`#checkDenominadorFijo_${tipo}`).addClass("DenominadorFijoInactivo");
            $(`#checkDenominadorFijo_${tipo}`).removeClass("DenominadorFijoActivo");
            $(`#clicDenominador_${tipo}`).val(0);
        }

        if (tipo == "componente"){
            if ($("#selectfrecuencia_componente").val() == "SEMESTRAL"){
                InicialDenominadorFijoSemestral_Componente();
            }else{
                InicialDenominadorFijoTrimestral_Componente();
            }
        }else{
            InicialDenominadorFijoTrimestral_Actividad();
        }
        
    });
}

function Func_CalcularMeta(valor1, valor2, modulo){
    let operacion = $(`#variable3_${modulo}`).val();
  
    // Reemplaza las variables v1 y v2 en la fórmula
    let formula = operacion.replace("V1", valor1).replace("V1", valor1).replace("V1", valor1).replace("V2", valor2).replace("V2", valor2).replace("V2", valor2);

    // Evalúa la fórmula y devuelve el resultado
    let resultado = eval(formula);
    
    return resultado;
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

function SeleccionarTablaFormulas() {
    $("#table-auditoriaformulas > tbody").on("click", ".checkAllFormulas", function() {
        let id = $(this)[0].dataset.idformula;
        
        if ($(this).prop("checked")){
            for (let index = 0; index < info_auditoriaformulas.length; index++) {
                const info = info_auditoriaformulas[index];
    
                if (info.id == id){
                    if (info.Descripcion == "REVISAR VALOR - EXISTEN DIFERENCIAS"){
                        array_logformulas.push(id);
                        $("#BtnEliminarLogFormula").removeClass("d-none");
                    }else{
                        $("#BtnEliminarLogFormula").addClass("d-none");
                    }
                    break;
                }
            }
        }else{
            let posicion = array_logformulas.indexOf(id);

            if (posicion !== -1) {
                array_logformulas.splice(posicion, 1);
            }

            for (let j = 0; j < array_logformulas.length; j++) {
                const element = array_logformulas[j];
                
                for (let i = 0; i < info_auditoriaformulas.length; i++) {
                    const info = info_auditoriaformulas[i];
        
                    if (info.id == element){
                        if (info.Descripcion == "REVISAR VALOR - EXISTEN DIFERENCIAS"){
                            $("#BtnEliminarLogFormula").removeClass("d-none");
                        }else{
                            $("#BtnEliminarLogFormula").addClass("d-none");
                        }
                        break;
                    }
                }
            }

            if (array_logformulas.length == 0){
                $("#BtnEliminarLogFormula").addClass("d-none");
            }
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

function GetMirFin() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirFin(request)
        .then(ResponseGetMirFin);
}



function GetMirProposito() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirProposito(request)
        .then(ResponseGetMirProposito);
}

function GetMirComponentes() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirComponentes(request)
        .then(ResponseGetMirComponentes);
}

function GetMirActividades() {
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirActividades(request)
        .then(ResponseGetMirActividades);
}

function GetMirAutoriaCarga() {
    Func_Cargando();
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
        //GetMirAutoriaFormulas();
        swal.close();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMirAutoriaFormulas() {
    Func_Cargando();
    var request = {
        consecutivo: consecutivo_seleccionado
    }
    repository.Mir.GetMirAutoriaFormulas(request)
        .then(ResponseGetMirAutoriaFormulas);
}

function ResponseGetMirAutoriaFormulas(response){
    if (!response.error) {
        array_logformulas = Array();
        DestroyDataTable("table-auditoriaformulas");
        $("#BtnEliminarLogFormula").addClass("d-none");
        $("#table-auditoriaformulas > tbody > tr").remove();
        if (response.data.length > 0) {
            info_auditoriaformulas = response.data;
            for (var i = 0; i < response.data.length; i++) {
                $("#table-auditoriaformulas > tbody").append(`
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input checkAllFormulas" type="checkbox" data-idformula="${response.data[i].id}">
                                <label class="form-check-label"></label>
                            </div>
                        </td>
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
        swal.close();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

// ======================================================
// B O T O N E S   D E   A C C I O N E S
// ======================================================

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
        
        // Func_Cargando();
        Func_Mensaje("Guardando MIR...");
        repository.Mir.SaveMir(request)
            .then(ResponseSaveMir);
    });
}

function ResponseSaveMir(response) {
    swal.close();
    if (!response.error) {
        info_componentes = null;
        info_actividades = null;
        index_componente = null;
        index_actividad = null;
        consecutivo_seleccionado = null;
        Func_Toast("success", "Información Guardada", "La MIR ha sido guardada exitosamente.");
        $("#Modal").modal("hide");
    } else {
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function BtnValidarMir(){
    $("#BtnValidar").on("click", function(event) {
        event.preventDefault();
        
        var request = {
            consecutivo: $("#consecutivo_caratula").val()
        };

        // Func_Cargando();
        Func_Mensaje("Validando Fórmulas...");
        repository.Mir.ValidarMir(request)
            .then(ResponseValidarMir);
    });
}

function ResponseValidarMir(response){
    swal.close();
    if (!response.error) {
        Func_Toast("success", "Fórmulas Validadas", "Revisar Auditoría de Fórmulas para más información.");
    } else {
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function BtnEliminarLogFormula(){
    $("#BtnEliminarLogFormula").on("click", function(event){
        event.preventDefault();
        
        Func_DespliegaConfirmacion2("Eliminar Observación", "¿Capturó correctamente los datos numéricos de los indicadores?<br>De ser así, el interfaz descartará las diferencias detectadas", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                Func_Cargando();
                repository.Mir.DeleteLogFormulas(array_logformulas)
                    .then(ResponseDeleteLogFormulas);
                    }
        });

        // Func_Cargando();
        // repository.Mir.DeleteLogFormulas(array_logformulas)
        //     .then(ResponseDeleteLogFormulas);
    });
}

function ResponseDeleteLogFormulas(response){
    swal.close();
    if (!response.error) {
        Func_Toast("success", "Observación Eliminada", "La(s) Observacion(es) han sido eliminada(s).");
        GetMirAutoriaFormulas();
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


