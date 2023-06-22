const repository = new Repository();
var info_secretarias = null;
var info_unidadadministrativa = null;
var info_ejes = null;
var info_temas = null;
var info_objetivos = null;

var selectSecretaria = null;
var selectUnidadAdministrativa = null;

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
        $('#select_UnidadAdministrativa').children('option:not(:first)').remove();
        $('#select_uaresponsable').children('option:not(:first)').remove();
        $('#select_unidadresponsablereportar').children('option:not(:first)').remove();
        info_unidadadministrativa = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_UnidadAdministrativa').append($('<option>', {
                value: response.data[i].idUnidad,
                text: ("[" + response.data[i].idUnidad + "] " + response.data[i].Descripcion)
            }));
            $('#select_uaresponsable').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
            $('#select_unidadresponsablereportar').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_UnidadAdministrativa').selectpicker("refresh");
        $('#select_uaresponsable').selectpicker("refresh");
        $('#select_unidadresponsablereportar').selectpicker("refresh");
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
            $('#eje_ped').append($('<option>', {
                value: response.data[i].IdEje,
                text: ("[" + response.data[i].IdEje + "] " + response.data[i].Descripcion)
            }));
        }
        $('#eje_ped').selectpicker("refresh");
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
            $('#tema_ped').append($('<option>', {
                value: response.data[i].IdTema,
                text: ("[" + response.data[i].IdTema + "] " + response.data[i].Descripcion)
            }));
        }
        $('#tema_ped').selectpicker("refresh");
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
        Func_DataTable("table");
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

    OnClic_TabsInternas();

    BtnEditarCatalogo();
    BtnGuardarUnidadAdministrativa();
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

function BtnEditarCatalogo(){
    $("#BtnEditarCatalogo").on("click", function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        Func_LimpiarModal();
        $("#id_conacadmin").val(selectConac);
        $("#id_secretaria").val(selectSecretaria);
        $("#id_ua").val(data[2]);
        $("#id_conacfuncional").selectpicker("val", data[4]);
        $("#descripcion").val(data[3]);
        $("#modal_accion").text("Editar");
        $("#Modal").modal("show");
    });
}

function BtnGuardarUnidadAdministrativa(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_secretaria: $("#id_secretaria").val(),
                id_unidad: $("#id_ua").val(),
                descripcion: $("#descripcion").val(),
                id_conacfuncional: $("#id_conacfuncional").val()
            };

            Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de la unidad administrativa?", "question", "Aceptar", "Cancelar", function(response) {
                if (response) {
                    Func_Cargando();
                    if ($("#modal_accion").text() == "Editar") {
                        repository.UnidadesAdministrativas.EditUnidadAdministrativa(request)
                            .then(ResponseEditUnidadeAdministrativa);
                    } else {
                        repository.UnidadesAdministrativas.AddUnidadAdministrativa(request)
                            .then(ResponseAddUnidadeAdministrativa);
                    }
                }
            });
        }
    });
}

function ResponseEditUnidadeAdministrativa(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Unidad administrativa editada.", "La unidad administrativa fue editada exitosamente.");
        GetUnidadesAdministrativas();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteUnidadeAdministrativa(response) {
    if (!response.error) {
        Func_Toast("success", "Unidad administrativa eliminada.", "La unidad administrativa fue eliminada exitosamente.");
        GetSecretarias();
    } else {
        console.log(response.result)
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


