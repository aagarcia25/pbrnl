const repository = new Repository();
var info_ejes = null;
var info_temas = null;

var selectEje = null;
var selectTema = null;

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    GetEjes();
}

function GetEjes() {
    Func_Cargando();
    repository.Eje.GetEjes()
        .then(ResponseGetEjes);
}

function ResponseGetEjes(response) {
    if (!response.error) {
        info_ejes = response.data;
        $('#select_eje').children().remove();
        $('#select_eje').selectpicker("destroy");
        for (var i = 0; i < response.data.length; i++) {
            if (i == 0){
                selectEje = response.data[i].IdEje;
            }

            $('#select_eje').append($('<option>', {
                value: response.data[i].IdEje,
                text: ("[" + response.data[i].IdEje + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_eje').selectpicker();
        $('#select_eje').selectpicker("val", selectEje);
        GetTemas()
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetTemas() {
    var request = {
        "id_eje": selectEje
    }
    repository.Tema.GetTemas(request)
        .then(ResponseGetTemas);
}

function ResponseGetTemas(response) {
    if (!response.error) {
        info_temas = response.data;
        $('#select_tema').children().remove();
        $('#select_tema').selectpicker("destroy");
        for (var i = 0; i < response.data.length; i++) {
            if (i == 0){
                selectTema = response.data[i].IdTema;
            }

            $('#select_tema').append($('<option>', {
                value: response.data[i].IdTema,
                text: ("[" + response.data[i].IdTema + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_tema').selectpicker();
        $('#select_tema').selectpicker("val", selectTema);
        GetObjetivos();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetObjetivos(){
    var request = {
        "id_eje": selectEje,
        "id_tema": selectTema
    }
    repository.Objetivos.GetObjetivos(request)
        .then(ResponseGetObjetivos);
}

function ResponseGetObjetivos(response){
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].IdEje}</td>
                        <td>${response.data[i].IdTema}</td>
                        <td>${response.data[i].IdObjetivo}</td>
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
    OnChange_Tema();
    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
    BtnGuardarObjetivo();
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
        selectEje = $(this).val();
        Func_Cargando();
        GetTemas();
    });
}

function OnChange_Tema(){
    $("#select_tema").on("change", function(){
        selectTema = $(this).val();
        Func_Cargando();
        GetObjetivos();
    });
}

function BtnAgregarCatalogo(){
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_eje").val(selectEje);
        $("#id_tema").val(selectTema);
        $("#id_objetivo").val("");
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
            Func_Aviso("Atención", "Para continuar favor de seleccionar un Objetivo.", "info");
            return false;
        }

        Func_LimpiarModal();
        $("#id_eje").val(data[0]);
        $("#id_tema").val(data[1]);
        $("#id_objetivo").val(data[2]);
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
            Func_Aviso("Atención", "Para continuar favor de seleccionar un Objetivo.", "info");
            return false;
        }

        var id_eje = data[0];
        var id_tema = data[1];
        var id_objetivo = data[2];

        Func_DespliegaConfirmacion("Eliminar", "¿Deseas eliminar el Objetivo seleccionado?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var request = {
                    id_eje: id_eje,
                    id_tema: id_tema,
                    id_objetivo: id_objetivo
                };
                Func_Cargando();
                repository.Objetivos.DeleteObjetivo(request)
                    .then(ResponseDeleteObjetivo);

            }
        });
    });
}

function BtnGuardarObjetivo(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        var request = {
            id_eje: $("#id_eje").val(),
            id_tema: $("#id_tema").val(),
            id_objetivo: $("#id_objetivo").val(),
            descripcion: $("#descripcion").val()
        };

        if ($("#modal_accion").text() == "Editar") {
            repository.Objetivos.EditObjetivo(request)
                .then(ResponseEditObjetivo);
        } else {
            repository.Objetivos.AddObjetivo(request)
                .then(ResponseAddObjetivo);
        }

        // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del Objetivo?", "question", "Aceptar", "Cancelar", function(response) {
        //     if (response) {
        //         Func_Cargando();
        //         if ($("#modal_accion").text() == "Editar") {
        //             repository.Objetivos.EditObjetivo(request)
        //                 .then(ResponseEditObjetivo);
        //         } else {
        //             repository.Objetivos.AddObjetivo(request)
        //                 .then(ResponseAddObjetivo);
        //         }
        //     }
        // });
    });
}

function ResponseAddObjetivo(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Objetivo agregado.", "El Objetivo fue agregado con éxito.");
        Func_Cargando();
        GetObjetivos();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditObjetivo(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Objetivo editado.", "El objetivo ha sido modificado.");
        Func_Cargando();
        GetObjetivos();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteObjetivo(response) {
    if (!response.error) {
        Func_Toast("success", "Objetivo eliminado.", "El Objetivo ha sido eliminado de Interfaz PbR.");
        Func_Cargando();
        GetObjetivos();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

// ======================================================
// Funciones
// ======================================================

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


