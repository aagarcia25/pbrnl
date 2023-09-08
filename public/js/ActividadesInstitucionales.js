const repository = new Repository();
var info_secretarias = null;
var info_clasificacion = null;
var info_topologia = null;
var info_objetivos = null;
var unidad_componente = null;
var descripcion_componente = null;
var id_componente = null;
var actividades = [];
var componentes = [];

$(document).ready(function() {Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    Func_Cargando();
    GetSecretarias();
    GetEjercicios();
}

function GetEjercicios() {
    repository.EjerciciosFiscales.Lista()
    .then(response => {
        swal.close();
        if(response.error == true)
        {
            MostrarHttpError(response);
            return;
        }
        response.data.forEach(element => {
            $("#select_ef").append("<option value='"+element.Id+"'>" + element.Id);
        });
        $("#select_ef").val(response.data[0].Id);

        $("#select_ef").selectpicker("refresh");
    })
    .catch((e)=>{
        swal.close();
        MostrarHttpError(e);
    });
}

function GetSecretarias() {
    repository.Secretarias.GetSecretarias()
        .then(ResponseGetSecretarias);
}

function ResponseGetSecretarias(response) {
    if (!response.error) {
        $('#select_secretaria').children().remove();
        info_secretarias = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_secretaria').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_secretaria').selectpicker("refresh");
        GetConacTipologia();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetConacTipologia() {
    repository.ConacTipologia.GetConacTipologia()
        .then(ResponseGetConacTipologia);
}

function ResponseGetConacTipologia(response) {
    if (!response.error) {
        info_topologia = response.data;
        GetAllObjetivos()
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllObjetivos() {
    repository.Objetivos.GetAllObjetivos()
        .then(ResponseGetAllObjetivos);
}

function ResponseGetAllObjetivos(response) {
    if (!response.error) {
        info_objetivos = response.data;
        GetAllActividadesI();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllActividadesI() {
    repository.ActividadesInstitucionales.GetAllActividadesI({ejercicio_fiscal: $("#select_ef").val()})
        .then(ResponseGetAllActividadesI);
}

function ResponseGetAllActividadesI(response) {
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            actividades = response.data;
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td class="d-none">${response.data[i].idSecretaria}</td>
                        <td>${response.data[i].idClasificacion}</td>
                        <td>${response.data[i].idObjetivoPED}</td>
                        <td>${response.data[i].Anticorrupcion}</td>
                        <td>${response.data[i].idTipologia}</td>
                        <td>${response.data[i].Consecutivo}</td>
                        <td>${response.data[i].DescripcionPrograma}</td>
                    </tr>
                `);
            }
        }
        Func_DataTable("table", true, true, true, 5);
        GetAllCountActividadesAI();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllCountActividadesAI(){
    repository.ActividadesInstitucionales.GetAllCountActividadesAI({ejercicio_fiscal: $("#select_ef").val()})
        .then(ResponseGetAllCountActividadesAI);
}

function ResponseGetAllCountActividadesAI(response) {
    swal.close();
    if (!response.error) {
        $("#contador_programas").text(response.data[0]['Programas']);
        $("#contador_componentes").text(response.data[0]['Componentes']);
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function Eventos() {
    SeleccionarTabla();
    OnChange_Secretaria();
    BtnComponentes();
    SeleccionarTablaComponentes();
    BtnEditarComponente();
    GuardarComponente();

    BtnActualizarPP();
    OnChange_SecretariaPP();
    GuardarActualizarPP();

    OnChange_Ejercicio();
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

function SeleccionarTablaComponentes() {
    $('#table_componentes tbody').on('click', 'tr', function() {
        var table = $('#table_componentes').DataTable();
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
        var Id_Secretaria = $(this).val();
        Func_Cargando();
        GetActividadesI(Id_Secretaria);
    });
}

function OnChange_Ejercicio() {
    $("#select_ef").on("change", function(){
        var ef = $(this).val();
        Func_Cargando();

        $("#select_secretaria").selectpicker("val","");

        GetAllActividadesI();
    });
}

function GetActividadesI(id_secretaria) {
    var request = {
        "id_secretaria": id_secretaria,
        "ejercicio_fiscal": $("#select_ef").val()
    }
    repository.ActividadesInstitucionales.GetActividadesI(request)
        .then(ResponseGetActividadesI);
}

function ResponseGetActividadesI(response) {
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td class="d-none">${response.data[i].idSecretaria}</td>
                        <td>${response.data[i].idClasificacion}</td>
                        <td>${response.data[i].idObjetivoPED}</td>
                        <td>${response.data[i].Anticorrupcion}</td>
                        <td>${response.data[i].idTipologia}</td>
                        <td>${response.data[i].Consecutivo}</td>
                        <td>${response.data[i].DescripcionPrograma}</td>
                    </tr>
                `);
            }
        }
        Func_DataTable("table", true, true, true, 5);
        GetCountActividadesAI();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetCountActividadesAI(){
    var request = {
        "id_secretaria": $("#select_secretaria").val(),
        ejercicio_fiscal: $("#select_ef").val()
    }
    repository.ActividadesInstitucionales.GetCountActividadesAI(request)
        .then(ResponseGetCountActividadesAI);
}

function ResponseGetCountActividadesAI(response) {
    swal.close();
    if (!response.error) {
        $("#contador_programas").text(response.data[0]['Programas']);
        $("#contador_componentes").text(response.data[0]['Componentes']);
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function BtnComponentes(){
    $("#BtnComponentes").on("click", function(){
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        $("#informacion_componente").addClass("d-none");
        var request = {
            "id_secretaria": data[0],
            "id_objetivo": data[2],
            "id_clasificacion": data[1],
            "consecutivo": data[5],
            "ejercicio_fiscal": $("#select_ef").val()
        }
        Func_Cargando();
        GetInfoComponentesAI(request);

    });
}

function GetInfoComponentesAI(request) {
    repository.ActividadesInstitucionales.GetInfoComponentesAI(request)
        .then(ResponseGetInfoComponentesAI);
}

function ResponseGetInfoComponentesAI(response){
    if (!response.error) {
        if (response.data.length > 0){
            var data = response.data[0];
            $("#id_secretaria").val(data['idSecretaria']);
            $("#descripcion_secretaria").val(data['Descripcion_Secretaria']);
            $("#id_clasificacion").val(data['idClasificacion']);
            $("#id_objetivo").val(data['IdObjetivo']);
            $("#descripcion_objetivo").val("["+data['IdObjetivo']+"] " + data['Descripcion_Objetivo']);
            $("#id_anticorrupcion").val(data['Anticorrupcion']);
            $("#id_topologia").val("["+data['idTipologia']+"] " + data['Descripcion_Topologia']);
            $("#consecutivo").val(data['Consecutivo']);
            $("#descripcion").val(data['DescripcionPrograma']);

            var act = getSelectedAI().Id;

            var request = {
                // "id_secretaria": data['idSecretaria'],
                // "id_objetivo": data['IdObjetivo'],
                // "id_clasificacion": data['idClasificacion'],
                // "consecutivo": data['Consecutivo'],
                // "ejercicio_fiscal": $("#select_ef").val(),
                "id" : act
            }
            GetComponentesAI(request);
        }else{
            Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del registro, favor de intentarlo nuevamente.", "error");
        }
    } else {
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del registro, favor de intentarlo nuevamente.", "error");
    } 
}

function GetComponentesAI(request) {
    repository.ActividadesInstitucionales.GetComponentesAI(request)
        .then(ResponseGetComponentesAI);
}

function ResponseGetComponentesAI(response) {
    if (!response.error) {
        DestroyDataTable("table_componentes");
        $("#table_componentes > tbody > tr").remove();
        componentes = response.data;

        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table_componentes > tbody").append(`
                    <tr>
                        <td>${response.data[i].idUA}</td>
                        <td>${response.data[i].Descripcion}</td>
                        <td>${response.data[i].Componente}</td>
                        <td>${response.data[i].DescripcionComponente}</td>
                    </tr>
                `);
            }
        }
        $("#Modal").modal("show");
        Func_DataTable("table_componentes", true, true, true, 3, "asc");
        swal.close();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del registro, favor de intentarlo nuevamente.", "error");
    }
}

function BtnEditarComponente() {
    $("#BtnEditarComponente").on("click", function(){
        var table = $('#table_componentes').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        unidad_componente = data[0];
        descripcion_componente = data[3];
        id_componente = data[2];
        Func_Cargando();
        var request = {
            id_Secretaria: $("#id_secretaria").val()
        }
        repository.UnidadesAdministrativas.GetUnidadesAdministrativas(request)
            .then(ResponseGetUnidadesAdministrativas); 
    });
}

function ResponseGetUnidadesAdministrativas(response) {
    if (!response.error) {
        $('#unidad_componente').selectpicker("destroy");
        $('#unidad_componente').children().remove();
        for (let i = 0; i < response.data.length; i++) {
            $('#unidad_componente').append($('<option>', {
                value: response.data[i].idUnidad,
                text: ("[" + response.data[i].idUnidad + "] " + response.data[i].Descripcion)
            }));
        }
        $('#unidad_componente').selectpicker();
        $('#unidad_componente').selectpicker("val", unidad_componente);
        $("#descripcion_componente").val(descripcion_componente);
        $("#id_componente").val(id_componente);
        $("#informacion_componente").removeClass("d-none");   
        swal.close();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GuardarComponente(){
    $("#form_componente").on("submit", function(event) {
        event.preventDefault();
        
        var request = {
            unidad_componente: $("#unidad_componente").val(),
            descripcion_componente: $("#descripcion_componente").val(),
            ejercicio_fiscal: $("#select_ef").val(),
            id: getSelectedComponente().Id
        }

        Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del actualizada del componente?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                Func_Cargando();
                repository.ActividadesInstitucionales.EditComponenteAI(request)
                    .then(ResponseEditComponenteAI);
            }
        });
        
    });
}

function ResponseEditComponenteAI(response) {
    if (!response.error) {
        Func_Toast("success", "Componente editado.", "El componente fue editado exitosamente.");
        $("#informacion_componente").addClass("d-none");
        $("#descripcion_componente").val("" );
        $('#unidad_componente').selectpicker("destroy");
        $('#unidad_componente').children().remove();
        $('#unidad_componente').selectpicker();
        var request = {
            // "id_secretaria": $("#id_secretaria").val(),
            // "id_objetivo": $("#id_objetivo").val(),
            // "id_clasificacion": $("#id_clasificacion").val(),
            // "consecutivo": $("#consecutivo").val(),
            // "ejercicio_fiscal": $("#select_ef").val(),
            "id" : getSelectedAI().Id
        }
        GetComponentesAI(request);
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", response.result, "error");
    }
}

function BtnActualizarPP() {
    $("#BtnActualizacionPP").on("click", function(){
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        // cargar secretarías
        $('#select_secretariapp').selectpicker("destroy");
        $('#select_secretariapp').children().remove();
        for (var i = 0; i < info_secretarias.length; i++) {
            $('#select_secretariapp').append($('<option>', {
                value: info_secretarias[i].idSecretaria,
                text: info_secretarias[i].Descripcion
            }));
        }
        $('#select_secretariapp').selectpicker();

        // carga tipologia
        $('#select_topologiapp').selectpicker("destroy");
        $('#select_topologiapp').children().remove();
        for (var j = 0; j < info_topologia.length; j++) {
            $('#select_topologiapp').append($('<option>', {
                value: info_topologia[j].IdTipologia,
                text: "[" + info_topologia[j].IdTipologia + "] " + info_topologia[j].Descripcion
            }));
        }
        $('#select_topologiapp').selectpicker();

        // carga objetivo
        $('#select_objetivopp').selectpicker("destroy");
        $('#select_objetivopp').children().remove();
        for (var k = 0; k < info_objetivos.length; k++) {
            $('#select_objetivopp').append($('<option>', {
                value: info_objetivos[k].IdObjetivo,
                text: "[" + info_objetivos[k].IdObjetivo + "] " + info_objetivos[k].Descripcion
            }));
        }
        $('#select_objetivopp').selectpicker();

        
        let id_secretaria = data[0];
        let id_clasificacion = data[1];
        let id_objetivo = data[2];
        let id_anticorrupcion = data[3];
        let id_tipologia = data[4];
        let consecutivo = data[5];
        let descripcion = data[6];

        $("#id_secretariapp").val(id_secretaria);
        $("#select_secretariapp").selectpicker("val", id_secretaria);
        $("#id_clasificacionpp").val(id_clasificacion);
        $("#select_objetivopp").selectpicker("val", id_objetivo);
        $("#id_anticorrupcionpp").selectpicker("val", id_anticorrupcion);
        $("#select_topologiapp").selectpicker("val", id_tipologia);
        $("#consecutivopp").val(consecutivo);
        $("#descriptivopp").val(descripcion);
        $("#descripcionpp").val(descripcion);

        $("#id_secretaria_real").val(id_secretaria);
        $("#id_clasificacion_real").val(id_clasificacion);
        $("#select_objetivo_real").val(id_objetivo);
        $("#id_anticorrupcion_real").val(id_anticorrupcion);
        $("#select_topologia_real").val(id_tipologia);
        $("#consecutivo_real").val(consecutivo);

        $("#ModalActualizacion").modal("show");

    });
}

function OnChange_SecretariaPP(){
    $("#select_secretariapp").on("change", function(){
        var Id_Secretaria = $(this).val();
        $("#id_secretariapp").val(Id_Secretaria);
    });
}

function GuardarActualizarPP(){
    $("#form_pp").on("submit", function(event) {
        event.preventDefault();
        
        var request = {
            id_secretaria: $("#select_secretariapp").val(),
            id_objetivo: $("#select_objetivopp").val(),
            id_anticorrupcion: $("#id_anticorrupcionpp").val(),
            id_topologia: $("#select_topologiapp").val(),
            descripcion: $("#descripcionpp").val(),

            id_secretaria_real: $("#id_secretaria_real").val(),
            id_clasificacion_real: $("#id_clasificacion_real").val(),
            id_objetivo_real: $("#select_objetivo_real").val(),
            id_anticorrupcion_real: $("#id_anticorrupcion_real").val(),
            id_topologia_real: $("#select_topologia_real").val(),
            consecutivo_real: $("#consecutivo_real").val(),
            ejercicio_fiscal: $("#select_ef").val()
        }

        Func_DespliegaConfirmacion("Guardar", "¿Deseas actualizar la información de la Actividad Institucional?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                Func_Cargando();
                repository.ActividadesInstitucionales.EditActividadInstitucional(request)
                    .then(ResponseEditActividadInstitucional);
            }
        });
        
    });
}

function ResponseEditActividadInstitucional(response) {
    if (!response.error) {
        Func_Toast("success", "Programa editado.", "La Actividad Institucional ha sido actualizada.");
        swal.close();
        let id_secretaria = $("#select_secretaria").val();
        let descripcion = $("#descripcionpp").val();
        $("#descriptivopp").val(descripcion);
        if (id_secretaria == ""){
            GetAllActividadesI();
        }else{
            GetActividadesI(id_secretaria);
        }
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", response.result, "error");
    }
}

// ======================================================
// Funciones
// ======================================================

function Func_LimpiarModal() {
    $(".modal .form-control").val("");
    $(".modal .form-control").removeClass("is-invalid");
    $(".modal .form-control").removeClass("is-valid");
}

function getSelectedAI() {
    var table = $('#table').DataTable();
    var index = table.row('.selected').index();
    const p = actividades[index];

    return p;
}

function getSelectedComponente() {
    var table = $('#table_componentes').DataTable();
    var index = table.row('.selected').index();
    var data = componentes[index];

    return data;
}