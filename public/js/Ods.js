const repository = new Repository();

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
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].IdODS}</td>
                        <td>${response.data[i].DescripcionCorta}</td>
                        <td>${response.data[i].DescripcionLarga}</td>
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
    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
    BtnGuardarOds();
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

function BtnAgregarCatalogo() {
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_ods").val("");
        $("#descripcion_corta").val("");
        $("#descripcion_larga").val("");
        $("#Modal").modal("show");
    });
}

function BtnEditarCatalogo() {
    $("#BtnEditarCatalogo").on("click", function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }
        
        Func_LimpiarModal();
        $("#id_ods").val(data[0]);
        $("#descripcion_corta").val(data[1]);
        $("#descripcion_larga").val(data[2]);
        $("#modal_accion").text("Editar");
        $("#Modal").modal("show");
    });
}

function BtnEliminarCatalogo() {
    $('#BtnEliminarCatalogo').click(function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        Func_DespliegaConfirmacion("Eliminar " + data[1], "¿Deseas eliminar el registro seleccionado?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var Id = data[0];
                var request = {
                    id_ods: Id
                };
                Func_Cargando();
                repository.Ods.DeleteOds(request)
                    .then(ResponseDeleteOds);

            }
        });
    });
}

function BtnGuardarOds() {
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_ods: $("#id_ods").val(),
                descripcion_corta: $("#descripcion_corta").val(),
                descripcion_larga: $("#descripcion_larga").val()
            };

            Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del ODS?", "question", "Aceptar", "Cancelar", function(response) {
                if (response) {
                    Func_Cargando();
                    if ($("#modal_accion").text() == "Editar") {
                        repository.Ods.EditOds(request)
                            .then(ResponseEditOds);
                    } else {
                        repository.Ods.AddOds(request)
                            .then(ResponseAddOds);
                    }
                }
            });
        }
    });
}

function ResponseAddOds(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "ODS agregado.", "El ods fue agregado exitosamente.");
        GetOds();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditOds(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "ODS editado.", "El ods fue editado exitosamente.");
        GetOds();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteOds(response) {
    if (!response.error) {
        Func_Toast("success", "Ods eliminado.", "El ods fue eliminado exitosamente.");
        GetOds();
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
    var descripcion_corta = $("#descripcion_corta");
    var descripcion_larga = $("#descripcion_larga");
    var resultado = true;

    if (id_ods.val() == "" || id_ods.val() == null || id_ods.val() == undefined) {
        resultado = false;
        id_ods.addClass("is-invalid");
        id_ods.removeClass("is-valid");
    } else {
        id_ods.removeClass("is-invalid");
        id_ods.addClass("is-valid");
    }

    if (descripcion_corta.val() == "" || descripcion_corta.val() == null || descripcion_corta.val() == undefined) {
        resultado = false;
        descripcion_corta.addClass("is-invalid");
        descripcion_corta.removeClass("is-valid");
    } else {
        descripcion_corta.removeClass("is-invalid");
        descripcion_corta.addClass("is-valid");
    }

    if (descripcion_larga.val() == "" || descripcion_larga.val() == null || descripcion_larga.val() == undefined) {
        resultado = false;
        descripcion_larga.addClass("is-invalid");
        descripcion_larga.removeClass("is-valid");
    } else {
        descripcion_larga.removeClass("is-invalid");
        descripcion_larga.addClass("is-valid");
    }

    if (!resultado) {
        Func_Aviso("Atención", "Favor de ingresar la información señalada.", "info")
    }

    return resultado;

}

function Func_LimpiarModal() {
    $(".form-control").val("");
    $(".form-control").removeClass("is-invalid");
    $(".form-control").removeClass("is-valid");
}