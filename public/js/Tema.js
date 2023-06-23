const repository = new Repository();
var info_eje = null;

var selectEje = null;

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
        $('#select_eje').children('option:not(:first)').remove();
        info_eje = response.data;
        for (var i = 0; i < response.data.length; i++) {
            if (i == 0){
                selectEje = response.data[i].IdEje;
            }

            $('#select_eje').append($('<option>', {
                value: response.data[i].IdEje,
                text: ("[" + response.data[i].IdEje + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_eje').selectpicker("refresh");
        $('#select_eje').selectpicker("val", selectEje);
        GetTemas();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetTemas(){
    var request = {
        "id_eje": selectEje
    }
    repository.Tema.GetTemas(request)
        .then(ResponseGetTemas);
}

function ResponseGetTemas(response){
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].IdEje}</td>
                        <td>${response.data[i].IdTema}</td>
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
    OnChange_Eje();
    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
    BtnGuardarTema();
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

function OnChange_Eje(){
    $("#select_eje").on("change", function(){
        var Id_Eje = Func_GetEje($(this).val());
        Func_Cargando();
        GetTemas();
    });
}

function BtnAgregarCatalogo(){
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_eje").val(selectEje);
        $("#id_tema").val("");
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
        $("#id_eje").val(selectEje);
        $("#id_tema").val(data[1]);
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

        Func_DespliegaConfirmacion("Eliminar " + data[1], "¿Deseas eliminar el registro seleccionado?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var id_eje = data[0];
                var id_tema = data[1];
                var request = {
                    id_eje: id_eje,
                    id_tema: id_tema
                };
                Func_Cargando();
                repository.Tema.DeleteTema(request)
                    .then(ResponseDeleteTema);

            }
        });
    });
}

function BtnGuardarTema(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_eje: $("#id_eje").val(),
                id_tema: $("#id_tema").val(),
                descripcion: $("#descripcion").val()
            };

            Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información el tema?", "question", "Aceptar", "Cancelar", function(response) {
                if (response) {
                    Func_Cargando();
                    if ($("#modal_accion").text() == "Editar") {
                        repository.Tema.EditTema(request)
                            .then(ResponseEditTema);
                    } else {
                        repository.Tema.Addtema(request)
                            .then(ResponseAddTema);
                    }
                }
            });
        }
    });
}

function ResponseAddTema(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Tema agregado.", "El tema fue agregado exitosamente.");
        GetTemas();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditTema(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Tema editado.", "El tema fue editado exitosamente.");
        GetTemas();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteTema(response) {
    if (!response.error) {
        Func_Toast("success", "Tema eliminado.", "El tema fue eliminado exitosamente.");
        GetTemas();
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
    var id_tema = $("#id_tema");
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

    if (id_tema.val() == "" || id_tema.val() == null || id_tema.val() == undefined) {
        resultado = false;
        id_tema.addClass("is-invalid");
        id_tema.removeClass("is-valid");
    } else {
        id_tema.removeClass("is-invalid");
        id_tema.addClass("is-valid");
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

function Func_GetEje(Id_Eje){
    for (var i = 0; i < info_eje.length; i++){
        if (Id_Eje == info_eje[i].IdEje){
            selectEje = info_eje[i].IdEje;
            break;
        }
    }

    return selectEje;
}

function Func_LimpiarModal() {
    $(".form-control").val("");
    $(".form-control").removeClass("is-invalid");
    $(".form-control").removeClass("is-valid");
}


