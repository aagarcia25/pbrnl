const repository = new Repository();
var info_ejes = null;
var info_temas = null;
var info_objetivos = null;

var selectEje = null;
var selectTema = null;
var selectObjetivo = null;

var init_selectEje = 0;
var init_selectTema = 0;
var init_selectObjetivo = 0;

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
            if (init_selectEje == 0){
                if (i == 0){
                    selectEje = response.data[i].IdEje;
                }
            }

            $('#select_eje').append($('<option>', {
                value: response.data[i].IdEje,
                text: ("[" + response.data[i].IdEje + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_eje').selectpicker();
        $('#select_eje').selectpicker("val", selectEje);
        GetObjetivos()
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetObjetivos(){
    var request = {
        "id_eje": selectEje
    }
    repository.Estrategias.GetEstrategiasObjetivos(request)
        .then(ResponseGetObjetivos);
}

function ResponseGetObjetivos(response){
    if (!response.error) {
        info_objetivos = response.data;
        $('#select_objetivo').children().remove();
        $('#select_objetivo').selectpicker("destroy");
        for (var i = 0; i < response.data.length; i++) {
            if (init_selectObjetivo == 0){
                if (i == 0){
                    selectObjetivo = response.data[i].IdTema;
                }
            }

            $('#select_objetivo').append($('<option>', {
                value: response.data[i].IdObjetivo,
                text: ("[" + response.data[i].IdObjetivo + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_objetivo').selectpicker();
        $('#select_objetivo').selectpicker("val", selectObjetivo);
        GetTemas();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetTemas() {
    var request = {
        "id_eje": selectEje,
        "id_objetivo": selectObjetivo
    }
    repository.Estrategias.GetEstrategiasTemas(request)
        .then(ResponseGetTemas);
}

function ResponseGetTemas(response) {
    if (!response.error) {
        info_temas = response.data;
        $('#select_tema').children().remove();
        $('#select_tema').selectpicker("destroy");
        for (var i = 0; i < response.data.length; i++) {
            if (init_selectTema == 0){
                if (i == 0){
                    selectTema = response.data[i].IdTema;
                }
            }

            $('#select_tema').append($('<option>', {
                value: response.data[i].IdTema,
                text: ("[" + response.data[i].IdTema + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_tema').selectpicker();
        $('#select_tema').selectpicker("val", selectTema);
        GetEstrategias();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetEstrategias(){
    var request = {
        "id_eje": selectEje,
        "id_tema": selectTema,
        "id_objetivo": selectObjetivo
    }
    repository.Estrategias.GetEstrategias(request)
        .then(ResponseGetEstrategias);
}

function ResponseGetEstrategias(response){
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
                        <td>${response.data[i].IdEstrategias}</td>
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
    //OnChange_Tema();
    OnChange_Objetivo();
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
        selectEje = $("#select_eje").val();
        init_selectEje = 1;
        init_selectObjetivo = 0;
        init_selectTema = 0;
        Func_Cargando();
        GetEjes();
    });
}

function OnChange_Tema(){
    $("#select_tema").on("change", function(){
        selectTema = $(this).val();
        Func_Cargando();
        GetEjes();
    });
}

function OnChange_Objetivo(){
    $("#select_objetivo").on("change", function(){
        selectEje = $("#select_eje").val();
        selectTema = $("#select_tema").val();
        selectObjetivo = $("#select_objetivo").val();
        init_selectObjetivo = 1;
        Func_Cargando();
        GetObjetivos();
    });
}

function BtnAgregarCatalogo(){
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_eje").val(selectEje);
        $("#id_tema").val(selectTema);
        $("#id_objetivo").val(selectObjetivo);
        $("#id_estregia").val("");
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
            Func_Aviso("Atención", "Para continuar favor de seleccionar una Estrategia.", "info");
            return false;
        }

        Func_LimpiarModal();
        $("#id_eje").val(data[0]);
        $("#id_tema").val(data[1]);
        $("#id_objetivo").val(data[2]);
        $("#id_estregia").val(data[3]);
        $("#descripcion").val(data[4]);
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
            Func_Aviso("Atención", "Para continuar favor de seleccionar una Estrategia.", "info");
            return false;
        }

        var id_eje = data[0];
        var id_tema = data[1];
        var id_objetivo = data[2];
        var id_estrategia = data[3];

        Func_DespliegaConfirmacion("Eliminar", "¿Deseas eliminar la Estrategia seleccionada?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var request = {
                    id_eje: id_eje,
                    id_tema: id_tema,
                    id_objetivo: id_objetivo,
                    id_estrategia: id_estrategia
                };
                Func_Cargando();
                repository.Estrategias.DeleteEstrategia(request)
                    .then(ResponseDeleteEstrategia);

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
            id_estrategia: $("#id_estregia").val(),
            descripcion: $("#descripcion").val()
        };

        if ($("#modal_accion").text() == "Editar") {
            repository.Estrategias.EditEstrategia(request)
                .then(ResponseEditEstrategia);
        } else {
            repository.Estrategias.AddEstrategia(request)
                .then(ResponseAddEstrategia);
        }

        // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de la Estrategia?", "question", "Aceptar", "Cancelar", function(response) {
        //     if (response) {
        //         Func_Cargando();
        //         if ($("#modal_accion").text() == "Editar") {
        //             repository.Estrategias.EditEstrategia(request)
        //                 .then(ResponseEditEstrategia);
        //         } else {
        //             repository.Estrategias.AddEstrategia(request)
        //                 .then(ResponseAddEstrategia);
        //         }
        //     }
        // });
    });
}

function ResponseAddEstrategia(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Estrategia agregada.", "La Estrategia fue agregada exitosamente.");
        Func_Cargando();
        GetEstrategias();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditEstrategia(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Estrategia editada.", "La Estrategia ha sido modificada.");
        Func_Cargando();
        GetEstrategias();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteEstrategia(response) {
    if (!response.error) {
        Func_Toast("success", "Estrategia eliminada.", "La estrategia ha sido eliminada de Interfaz PbR.");
        Func_Cargando();
        GetEstrategias();
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


