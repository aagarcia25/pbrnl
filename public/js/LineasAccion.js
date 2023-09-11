const repository = new Repository();
var info_ejes = null;
var info_temas = null;
var info_objetivos = null;
var info_estrategias = null;

var selectEje = null;
var selectTema = null;
var selectObjetivo = null;
var selectEstrategia = null;

var init_selectEje = 0;
var init_selectTema = 0;
var init_selectObjetivo = 0;
var init_selectEstrategia = 0;

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
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente. ("+response.result+")", "error");
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
        info_estrategias = response.data;
        $('#select_estrategia').children().remove();
        $('#select_estrategia').selectpicker("destroy");
        for (var i = 0; i < response.data.length; i++) {
            if (init_selectEstrategia == 0){
                if (i == 0){
                    selectEstrategia = response.data[i].IdEstrategias;
                }
            }

            $('#select_estrategia').append($('<option>', {
                value: response.data[i].IdEstrategias,
                text: ("[" + response.data[i].IdEstrategias + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_estrategia').selectpicker();
        $('#select_estrategia').selectpicker("val", selectEstrategia);
        GetLineasAccion();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetLineasAccion(){
    var request = {
        "id_eje": selectEje,
        "id_tema": selectTema,
        "id_objetivo": selectObjetivo,
        "id_estrategia": selectEstrategia
    }
    repository.LineasAccion.GetLineasAccion(request)
        .then(ResponseGetLineasAccion);
}

function ResponseGetLineasAccion(response){
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
                        <td>${response.data[i].IdEstrategia}</td>
                        <td>${response.data[i].IdLineaAccion}</td>
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
    OnChange_Estrategia();
    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
    BtnGuardarLineaAccion();
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

function OnChange_Estrategia(){
    $("#select_estrategia").on("change", function(){
        selectEje = $("#select_eje").val();
        selectTema = $("#select_tema").val();
        selectObjetivo = $("#select_objetivo").val();
        selectEstrategia = $("#select_estrategia").val();
        init_selectObjetivo = 1;
        Func_Cargando();
        GetLineasAccion();
    });
}

function BtnAgregarCatalogo(){
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_eje").val(selectEje);
        $("#id_tema").val(selectTema);
        $("#id_objetivo").val(selectObjetivo);
        $("#id_estregia").val(selectEstrategia);
        $("#id_lineaacion").val("");
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
        $("#id_eje").val(data[0]);
        $("#id_tema").val(data[1]);
        $("#id_objetivo").val(data[2]);
        $("#id_estregia").val(data[3]);
        $("#id_lineaacion").val(data[4]);
        $("#descripcion").val(data[5]);
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

        var id_eje = data[0];
        var id_tema = data[1];
        var id_objetivo = data[2];
        var id_estrategia = data[3];
        var id_lineaccion = data[4];

        Func_DespliegaConfirmacion("Eliminar", "¿Deseas eliminar la Línea de Acción seleccionada?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var request = {
                    id_eje: id_eje,
                    id_tema: id_tema,
                    id_objetivo: id_objetivo,
                    id_estrategia: id_estrategia,
                    id_lineaccion: id_lineaccion
                };
                Func_Cargando();
                repository.LineasAccion.DeleteLineaAccion(request)
                    .then(ResponseDeleteLineaAccion);

            }
        });
    });
}

function BtnGuardarLineaAccion(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        var request = {
            id_eje: $("#id_eje").val(),
            id_tema: $("#id_tema").val(),
            id_objetivo: $("#id_objetivo").val(),
            id_estrategia: $("#id_estregia").val(),
            id_lineaccion: $("#id_lineaacion").val(),
            descripcion: $("#descripcion").val(),
        };

        if ($("#modal_accion").text() == "Editar") {
            repository.LineasAccion.EditLineaAccion(request)
                .then(ResponseEditLineaAccion);
        } else {
            repository.LineasAccion.AddLineaAccion(request)
                .then(ResponseAddLineaAccion);
        }

        // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de la Línea de Acción?", "question", "Aceptar", "Cancelar", function(response) {
        //     if (response) {
        //         Func_Cargando();
        //         console.log(request)
        //         if ($("#modal_accion").text() == "Editar") {
        //             repository.LineasAccion.EditLineaAccion(request)
        //                 .then(ResponseEditLineaAccion);
        //         } else {
        //             repository.LineasAccion.AddLineaAccion(request)
        //                 .then(ResponseAddLineaAccion);
        //         }
        //     }
        // });
    });
}

function ResponseAddLineaAccion(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Linea de acción agregada.", "La Línea de Acción  fue agregada con éxito.");
        Func_Cargando();
        GetLineasAccion();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditLineaAccion(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Linea de acción editada.", "La Línea de Acción ha sido modificadda.");
        Func_Cargando();
        GetLineasAccion();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteLineaAccion(response) {
    if (!response.error) {
        Func_Toast("success", "Linea de acción eliminada.", "La Línea de Acción fue eliminada de Interfaz PbR.");
        Func_Cargando();
        GetLineasAccion();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

// ======================================================
// Funciones
// ======================================================

function Func_LimpiarModal() {
    $("#Modal .form-control").val("");
    $("#Modal .form-control").removeClass("is-invalid");
    $("#Modal .form-control").removeClass("is-valid");
}


