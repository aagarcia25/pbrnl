const repository = new Repository();
var info_ods = null;

var selectOds = null;

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    GetOds();
}

function GetOds() {
    Func_Cargando();
    repository.Ods.GetOds()
        .then(ResponseGetOds);
}

function ResponseGetOds(response) {
    if (!response.error) {
        $('#select_ods').children('option:not(:first)').remove();
        info_ods = response.data;
        for (var i = 0; i < response.data.length; i++) {
            if (i == 0){
                selectOds = response.data[i].IdODS;
            }

            $('#select_ods').append($('<option>', {
                value: response.data[i].IdODS,
                text: ("[" + response.data[i].IdODS + "] " + response.data[i].DescripcionCorta)
            }));
        }
        $('#select_ods').selectpicker("refresh");
        $('#select_ods').selectpicker("val", `${selectOds}`);
        GetMetaOds();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetMetaOds(){
    var request = {
        "id_ods": selectOds
    }
    repository.MetaOds.GetMetaOds(request)
        .then(ResponseGetMetaOds);
}

function ResponseGetMetaOds(response){
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].IdODS}</td>
                        <td>${response.data[i].IdMETAODS}</td>
                        <td>${response.data[i].Descripcion}</td>
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
    OnChange_Ods();
    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
    BtnGuardarMetaOds();
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

function OnChange_Ods(){
    $("#select_ods").on("change", function(){
        var Id_Ods = Func_GetOds($(this).val());
        Func_Cargando();
        GetMetaOds();
    });
}

function BtnAgregarCatalogo(){
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_ods").val(selectOds);
        $("#id_metaods").val("");
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
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        Func_LimpiarModal();
        $("#id_ods").val(selectOds);
        $("#id_metaods").val(data[1]);
        $("#descripcion").val(data[2]);
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

        Func_DespliegaConfirmacion("Eliminar meta" + data[1], "¿Deseas eliminar el registro seleccionado?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var id_ods = data[0];
                var id_metaods = data[1];
                var request = {
                    id_ods: parseInt(id_ods),
                    id_metaods: parseInt(id_metaods)
                };
                Func_Cargando();
                repository.MetaOds.DeleteMetaOds(request)
                    .then(ResponseDeleteMetaOds);

            }
        });
    });
}

function BtnGuardarMetaOds(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_ods: parseInt($("#id_ods").val()),
                id_metaods: parseInt($("#id_metaods").val()),
                descripcion: $("#descripcion").val()
            };

            Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de la meta ODS?", "question", "Aceptar", "Cancelar", function(response) {
                if (response) {
                    Func_Cargando();
                    if ($("#modal_accion").text() == "Editar") {
                        repository.MetaOds.EditMetaOds(request)
                            .then(ResponseEditMetaOds);
                    } else {
                        repository.MetaOds.AddMetaOds(request)
                            .then(ResponseAddMetaOds);
                    }
                }
            });
        }
    });
}

function ResponseAddMetaOds(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Meta ODS agregada.", "La meta ODS fue agregada exitosamente.");
        GetMetaOds();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditMetaOds(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Meta ODS editada.", "La meta ODS fue editada exitosamente.");
        GetMetaOds();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteMetaOds(response) {
    if (!response.error) {
        Func_Toast("success", "Meta ODS eliminada.", "La meta ODS fue eliminada exitosamente.");
        GetMetaOds();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}



// ======================================================
// Funciones
// ======================================================

function Func_Valida() {
    var id_ods = $("#id_ods");
    var id_metaods = $("#id_metaods");
    var descripcion = $("#descripcion");
    var resultado = true;

    if (id_ods.val() == "" || id_ods.val() == null || id_ods.val() == undefined) {
        resultado = false;
        id_ods.addClass("is-invalid");
        id_ods.removeClass("is-valid");
    } else {
        id_ods.removeClass("is-invalid");
        id_ods.addClass("is-valid");
    }

    if (id_metaods.val() == "" || id_metaods.val() == null || id_metaods.val() == undefined) {
        resultado = false;
        id_metaods.addClass("is-invalid");
        id_metaods.removeClass("is-valid");
    } else {
        id_metaods.removeClass("is-invalid");
        id_metaods.addClass("is-valid");
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

function Func_GetOds(Id_Ods){
    for (var i = 0; i < info_ods.length; i++){
        if (Id_Ods == info_ods[i].IdODS){
            selectOds = info_ods[i].IdODS;
            break;
        }
    }

    return selectOds;
}

function Func_LimpiarModal() {
    $(".form-control").val("");
    $(".form-control").removeClass("is-invalid");
    $(".form-control").removeClass("is-valid");
}


