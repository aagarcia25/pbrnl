const repository = new Repository();

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    GetConacAdministrativo();
}

function GetConacAdministrativo() {
    Func_Cargando();
    repository.ConacAdministrativo.GetConacAdministrativo()
        .then(ResponseGetSecretarias);
}

function ResponseGetSecretarias(response) {
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].IdConac}</td>
                        <td>${response.data[i].Descripcion}</td>
                    </tr>
                `);
            }
        }
        Func_DataTable("table");
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
    swal.close();
}

function Eventos() {
    //SeleccionarTabla();
    //BtnAgregarSecretaria();
    //BtnEditarSecretaria();
    //BtnEliminarSecretaria();
    //BtnGuardarSecretaria();
}
/*
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

function BtnAgregarSecretaria() {
    $("#BtnAgregarSecretaria").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_secretaria").val("");
        $("#id_conac").val("");
        $("#descripcion").val("");
        $("#ModalSecretaria").modal("show");
    });
}

function BtnEditarSecretaria() {
    $("#BtnEditarSecretaria").on("click", function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        Func_LimpiarModal();
        $("#id").val(data[0]);
        $("#id_secretaria").val(data[1]);
        $("#id_conac").val(data[2]);
        $("#descripcion").val(data[3]);
        $("#modal_accion").text("Editar");
        $("#ModalSecretaria").modal("show");
    });
}

function BtnEliminarSecretaria() {
    $('#BtnEliminarSecretaria').click(function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        Func_DespliegaConfirmacion("Eliminar " + data[3], "¿Deseas eliminar el registro seleccionado?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var Id = data[0];
                var request = {
                    id: Id
                }
                Func_Cargando();
                repository.Secretarias.DeleteSecretaria(request)
                    .then(ResponseDeleteSecretaria);

            }
        });
    });
}

function BtnGuardarSecretaria() {
    $("#form_secretaria").on("submit", function(event) {
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id: ($("#modal_accion").text() == "Editar" ? $("#id").val() : null),
                id_secretaria: $("#id_secretaria").val(),
                id_conac: $("#id_conac").val(),
                descripcion: $("#descripcion").val()
            };

            Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de la secretaría?", "question", "Aceptar", "Cancelar", function(response) {
                if (response) {
                    Func_Cargando();
                    if ($("#modal_accion").text() == "Editar") {
                        repository.Secretarias.EditSecretaria(request)
                            .then(ResponseEditSecretaria);
                    } else {
                        repository.Secretarias.AddSecretaria(request)
                            .then(ResponseAddSecretaria);
                    }

                }
            });
        }
    });
}

function ResponseAddSecretaria(response) {
    if (!response.error) {
        $("#ModalSecretaria").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Secretaría agregada.", "La secretaría fue agregada exitosamente.");
        GetSecretarias();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditSecretaria(response) {
    if (!response.error) {
        $("#ModalSecretaria").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Secretaría editada.", "La secretaría fue editada exitosamente.");
        GetSecretarias();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteSecretaria(response) {
    if (!response.error) {
        Func_Toast("success", "Secretaría eliminada.", "La secretaría fue eliminada exitosamente.");
        GetSecretarias();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function Func_Valida() {
    var id_secretaria = $("#id_secretaria");
    var id_conac = $("#id_conac");
    var descripcion = $("#descripcion");
    var resultado = true;

    if (id_secretaria.val() == "" || id_secretaria.val() == null || id_secretaria.val() == undefined) {
        resultado = false;
        id_secretaria.addClass("is-invalid");
        id_secretaria.removeClass("is-valid");
    } else {
        id_secretaria.removeClass("is-invalid");
        id_secretaria.addClass("is-valid");
    }

    if (id_conac.val() == "" || id_conac.val() == null || id_conac.val() == undefined) {
        resultado = false;
        id_conac.addClass("is-invalid");
        id_conac.removeClass("is-valid");
    } else {
        id_conac.removeClass("is-invalid");
        id_conac.addClass("is-valid");
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
*/
