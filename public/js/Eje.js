const repository = new Repository();

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    GetEjes();
}

function GetEjes() {
    // Func_Cargando();
    repository.Eje.GetEjes()
        .then(ResponseGetEjes);
}

function ResponseGetEjes(response) {
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].IdEje}</td>
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
    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
    BtnGuardarEje();
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
        $("#id_eje").val("");
        $("#descripcion").val("");
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
        $("#id_eje").val(data[0]);
        $("#descripcion").val(data[1]);
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
                    id_eje: Id
                };
                Func_Cargando();
                repository.Eje.DeleteEje(request)
                    .then(ResponseDeleteEje);

            }
        });
    });
}

function BtnGuardarEje() {
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_Eje: $("#id_eje").val(),
                descripcion: $("#descripcion").val()
            };

            Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del eje?", "question", "Aceptar", "Cancelar", function(response) {
                if (response) {
                    Func_Cargando();
                    if ($("#modal_accion").text() == "Editar") {
                        repository.Eje.EditEje(request)
                            .then(ResponseEditEje);
                    } else {
                        repository.Eje.AddEje(request)
                            .then(ResponseAddEje);
                    }
                }
            });
        }
    });
}

function ResponseAddEje(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Eje agregado.", "El eje fue agregado exitosamente.");
        GetEjes();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditEje(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Eje editado.", "El eje fue editado exitosamente.");
        GetEjes();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteEje(response) {
    if (!response.error) {
        Func_Toast("success", "Eje eliminado.", "El eje fue eliminado exitosamente.");
        GetEjes();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

// ======================================================
// Funciones
// ======================================================

function Func_Valida() {
    var id_eje = $("#id_eje");
    var descripcion = $("#descripcion");
    var resultado = true;

    if (id_eje.val() == "" || id_eje.val() == null || id_eje.val() == undefined) {
        resultado = false;
        id_eje.addClass("is-invalid");
        id_eje.removeClass("is-valid");
    } else {
        id_eje.removeClass("is-invalid");
        id_eje.addClass("is-valid");
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

function Func_LimpiarModal() {
    $(".form-control").val("");
    $(".form-control").removeClass("is-invalid");
    $(".form-control").removeClass("is-valid");
}