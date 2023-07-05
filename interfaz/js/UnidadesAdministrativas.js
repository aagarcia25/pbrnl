const repository = new Repository();
var info_conacfuncional = null;
var info_secretarias = null;

var selectSecretaria = null;
var selectConac = null;

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    GetConacFuncional();
}

function GetConacFuncional() {
    Func_Cargando();
    repository.ConacFuncional.GetConacFuncional()
        .then(ResponseGetConacFuncional);
}

function ResponseGetConacFuncional(response) {
    if (!response.error) {
        $('#id_conacfuncional').children('option:not(:first)').remove();
        info_conacfuncional = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#id_conacfuncional').append($('<option>', {
                value: response.data[i].IdConac,
                text: ("[" + response.data[i].IdConac + "] " + response.data[i].Descripcion)
            }));
        }
        $('#id_conacfuncional').selectpicker("refresh");
        GetSecretarias()
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetSecretarias() {
    repository.Secretarias.GetSecretarias()
        .then(ResponseGetSecretarias);
}

function ResponseGetSecretarias(response) {
    if (!response.error) {
        $('#select_secretaria').children('option:not(:first)').remove();
        info_secretarias = response.data;
        for (var i = 0; i < response.data.length; i++) {
            if (i == 0){
                selectSecretaria = response.data[i].idSecretaria;
                selectConac = response.data[i].Conac;
            }

            $('#select_secretaria').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_secretaria').selectpicker("refresh");
        $('#select_secretaria').selectpicker("val", selectSecretaria);
        GetUnidadesAdministrativas();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetUnidadesAdministrativas(){
    var request = {
        "id_Secretaria": selectSecretaria
    }
    repository.UnidadesAdministrativas.GetUnidadesAdministrativas(request)
        .then(ResponseGetUnidadesAdministrativas);
}

function ResponseGetUnidadesAdministrativas(response){
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${selectConac}</td>
                        <td>${response.data[i].idSecretaria}</td>
                        <td>${response.data[i].idUnidad}</td>
                        <td>${response.data[i].Descripcion}</td>
                        <td>${response.data[i].idConacFun}</td>
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
    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
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
    $("#select_secretaria").on("change", function(){
        var Id_Secretaria = Func_GetSecretaria($(this).val());
        Func_Cargando();
        GetUnidadesAdministrativas();
    });
}

function BtnAgregarCatalogo(){
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_conacadmin").val(selectConac);
        $("#id_secretaria").val(selectSecretaria);
        $("#id_ua").val("");
        $("#id_conacfuncional").selectpicker("val", "");
        $("#descripcion").val("");
        $("#Modal").modal("show");
    });
}

function BtnEditarCatalogo(){
    $("#BtnEditarCatalogo").on("click", function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar una Unidad Administrativa.", "info");
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

function BtnEliminarCatalogo(){
    $('#BtnEliminarCatalogo').click(function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        Func_DespliegaConfirmacion("Eliminar " + data[3], "¿Deseas eliminar la Unidad Administrativa seleccionada?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var id_secretaria = data[1];
                var id_ua = data[2];
                var request = {
                    id_secretaria: id_secretaria,
                    id_unidad: id_ua
                };
                Func_Cargando();
                repository.UnidadesAdministrativas.DeleteUnidadAdministrativa(request)
                    .then(ResponseDeleteUnidadeAdministrativa);

            }
        });
    });
}

function BtnGuardarUnidadAdministrativa(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_secretaria: $("#id_secretaria").val(),
                id_unidad: $("#id_ua").val(),
                descripcion: $("#descripcion").val().toUpperCase(),
                id_conacfuncional: $("#id_conacfuncional").val()
            };

            if ($("#modal_accion").text() == "Editar") {
                repository.UnidadesAdministrativas.EditUnidadAdministrativa(request)
                    .then(ResponseEditUnidadeAdministrativa);
            } else {
                repository.UnidadesAdministrativas.AddUnidadAdministrativa(request)
                    .then(ResponseAddUnidadeAdministrativa);
            }

            // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de la unidad administrativa?", "question", "Aceptar", "Cancelar", function(response) {
            //     if (response) {
            //         Func_Cargando();
            //         if ($("#modal_accion").text() == "Editar") {
            //             repository.UnidadesAdministrativas.EditUnidadAdministrativa(request)
            //                 .then(ResponseEditUnidadeAdministrativa);
            //         } else {
            //             repository.UnidadesAdministrativas.AddUnidadAdministrativa(request)
            //                 .then(ResponseAddUnidadeAdministrativa);
            //         }
            //     }
            // });
        }
    });
}

function ResponseAddUnidadeAdministrativa(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Unidad administrativa agregada.", "La unidad administrativa ha sido agregada con éxito.");
        GetUnidadesAdministrativas();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditUnidadeAdministrativa(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Unidad administrativa editada.", "La unidad administrativa ha sido modificada.");
        GetUnidadesAdministrativas();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteUnidadeAdministrativa(response) {
    if (!response.error) {
        Func_Toast("success", "Unidad administrativa eliminada.", "La unidad administrativa ha sido eliminada de Interfaz PbR.");
        GetSecretarias();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}



// ======================================================
// Funciones
// ======================================================

function Func_Valida() {
    var id_conacadmin = $("#id_conacadmin");
    var id_secretaria = $("#id_secretaria");
    var id_ua = $("#id_ua");
    var id_conacfuncional = $("#id_conacfuncional");
    var descripcion = $("#descripcion");
    var resultado = true;

    if (id_conacadmin.val() == "" || id_conacadmin.val() == null || id_conacadmin.val() == undefined) {
        resultado = false;
        id_conacadmin.addClass("is-invalid");
        id_conacadmin.removeClass("is-valid");
    } else {
        id_conacadmin.removeClass("is-invalid");
        id_conacadmin.addClass("is-valid");
    }

    if (id_secretaria.val() == "" || id_secretaria.val() == null || id_secretaria.val() == undefined) {
        resultado = false;
        id_secretaria.addClass("is-invalid");
        id_secretaria.removeClass("is-valid");
    } else {
        id_secretaria.removeClass("is-invalid");
        id_secretaria.addClass("is-valid");
    }

    if (id_ua.val() == "" || id_ua.val() == null || id_ua.val() == undefined) {
        resultado = false;
        id_ua.addClass("is-invalid");
        id_ua.removeClass("is-valid");
    } else {
        id_ua.removeClass("is-invalid");
        id_ua.addClass("is-valid");
    }

    if (id_conacfuncional.val() == "" || id_conacfuncional.val() == null || id_conacfuncional.val() == undefined) {
        resultado = false;
        id_conacfuncional.addClass("is-invalid");
        id_conacfuncional.removeClass("is-valid");
    } else {
        id_conacfuncional.removeClass("is-invalid");
        id_conacfuncional.addClass("is-valid");
    }

    if (descripcion.val() == "" || descripcion.val() == null || descripcion.val() == undefined) {
        resultado = false;
        descripcion.addClass("is-invalid");
        descripcion.removeClass("is-valid");
    } else {
        descripcion.removeClass("is-invalid");
        descripcion.addClass("is-valid");
    }

    if (!resultado) {
        Func_Aviso("Atención", "Favor de ingresar la información señalada.", "info")
    }

    return resultado;

}

function Func_GetSecretaria(Id_Secretaria){
    for (var i = 0; i < info_secretarias.length; i++){
        if (Id_Secretaria == info_secretarias[i].idSecretaria){
            selectSecretaria = info_secretarias[i].idSecretaria;
            selectConac = info_secretarias[i].Conac;
            break;
        }
    }

    return selectSecretaria;
}

function Func_LimpiarModal() {
    $(".form-control").val("");
    $(".form-control").removeClass("is-invalid");
    $(".form-control").removeClass("is-valid");
}


