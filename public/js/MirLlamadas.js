function GetSecretarias() {
    repository.Secretarias.GetSecretarias()
        .then(ResponseGetSecretarias);
}

function ResponseGetSecretarias(response) {
    if (!response.error) {
        $('#select_entepublido').selectpicker("destroy");
        $('#select_Secretaria').children().remove();
        $('#select_entepublido').children('option:not(:first)').remove();
        info_secretarias = response.data;

        if(info_secretarias.length > 1) {
            $('#select_Secretaria').append($('<option>', {
                value: "0",
                text: "-"
            }));
        }
        
        for (var i = 0; i < response.data.length; i++) {
            $('#select_Secretaria').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
            $('#select_entepublido').append($('<option>', {
                value: response.data[i].idSecretaria,
                text: ("[" + response.data[i].idSecretaria + "] " + response.data[i].Descripcion)
            }));
        }


        $('#select_Secretaria').selectpicker("refresh");
        $('#select_entepublido').selectpicker();

        if(info_secretarias.length == 1)
            $('#select_Secretaria').selectpicker("val", info_secretarias[0].idSecretaria);

        swal.close();
        GetUnidadesAdministrativas();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetUnidadesAdministrativas(){
    repository.UnidadesAdministrativas.GetAllUnidadesAdministrativas()
        .then(ResponseGetUnidadesAdministrativas);
}

function ResponseGetUnidadesAdministrativas(response){
    if (!response.error) {
        agregarUnidadesAdministrativas(response.data);

        GetEjes();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function agregarUnidadesAdministrativas(data) {
    $('#select_UnidadAdministrativa').selectpicker("destroy");
    $('#select_UnidadAdministrativa').empty();
    info_unidadadministrativa = data;
    if(info_unidadadministrativa.length > 1) {
        $('#select_UnidadAdministrativa').append($('<option>', {
            value: "",
            text: "-"
        }));
    }
    for (var i = 0; i < data.length; i++) {
        $('#select_UnidadAdministrativa').append($('<option>', {
            value: data[i].idUnidad,
            text: ("[" + data[i].idUnidad + "] " + data[i].Descripcion)
        }));
    }
    $('#select_UnidadAdministrativa').selectpicker();
    if(info_unidadadministrativa.length == 1)
        $('#select_UnidadAdministrativa').selectpicker("val",info_unidadadministrativa[0].idUnidad);
    else
        $('#select_UnidadAdministrativa').selectpicker("val","");
}

function GetEjes() {
    // Func_Cargando();
    repository.Eje.GetEjes()
        .then(ResponseGetEjes);
}

function ResponseGetEjes(response) {
    if (!response.error) {
        info_ejes = response.data;
        $('#select_ejeped').selectpicker("destroy");
        for (var i = 0; i < response.data.length; i++) {
            $('#select_ejeped').append($('<option>', {
                value: response.data[i].IdEje,
                text: ("[" + response.data[i].IdEje + "] " + response.data[i].Descripcion)
            }));
        }
        $('#select_ejeped').selectpicker();
        GetAllTemas()
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllTemas() {
    repository.Tema.GetAllTemas()
        .then(ResponseGetTemas);
}

function ResponseGetTemas(response) {
    if (!response.error) {
        info_temas = response.data;
        // $('#select_temaped').selectpicker("destroy");
        // for (var i = 0; i < response.data.length; i++) {
        //     $('#select_temaped').append($('<option>', {
        //         value: response.data[i].IdTema,
        //         text: ("[" + response.data[i].IdTema + "] " + response.data[i].Descripcion)
        //     }));
        // }
        // $('#select_temaped').selectpicker();

        FiltrarTemaPED()

        GetObjetivos();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetObjetivos(){
    repository.Objetivos.GetAllObjetivos()
        .then(ResponseGetObjetivos);
}

function ResponseGetObjetivos(response){
    if (!response.error) {
        info_objetivos = response.data;
        // $('#select_objetivo').selectpicker("destroy");
        // for (var i = 0; i < response.data.length; i++) {
        //     $('#select_objetivo').append($('<option>', {
        //         value: response.data[i].IdObjetivo,
        //         text: ("[" + response.data[i].IdObjetivo + "] " + response.data[i].Descripcion)
        //     }));
        // }
        // $('#select_objetivo').selectpicker();
        GetAllEstretegias();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllEstretegias(){
    repository.Estrategias.GetAllEstretegias()
        .then(ResponseGetAllEstretegias);
}

function ResponseGetAllEstretegias(response){
    if (!response.error) {
        info_estrategias = response.data;
        GetAllLineasAccion();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllLineasAccion(){
    repository.LineasAccion.GetAllLineasAccion()
        .then(ResponseGetAllLineasAccion);
}

function ResponseGetAllLineasAccion(response){
    if (!response.error) {
        info_lineasaccion = response.data;
        GetTiposBeneficiarios();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetTiposBeneficiarios(){
    repository.Beneficiarios.GetTiposBeneficiarios()
        .then(ResponseGetTiposBeneficiarios);
}

function ResponseGetTiposBeneficiarios(response){
    if (!response.error) {
        info_tiposbeneficiarios = response.data;
        $('#select_tipobeneficiario').selectpicker("destroy");
        for (var i = 0; i < response.data.length; i++) {
            $('#select_tipobeneficiario').append($('<option>', {
                value: response.data[i].idBeneficiario,
                text: ("[" + response.data[i].idBeneficiario + "] " + response.data[i].TipoBeneficiario)
            }));
        }
        $('#select_tipobeneficiario').selectpicker();
        GetAllBeneficiarios();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetAllBeneficiarios(){
    repository.Beneficiarios.GetAllBeneficiarios()
        .then(ResponseGetAllBeneficiarios);
}

function ResponseGetAllBeneficiarios(response){
    if (!response.error) {
        info_beneficiarios = response.data;
        GetEjercicios();
        
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
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
        GetMir();
        GetConteos();
    })
    .catch((e)=>{
        swal.close();
        MostrarHttpError(e);
    });
}

function GetConteos() {
    $("#numIndicadores").html("...");
    $("#numProgramas").text("...");
    $("#numComponentes").text("...");

    var req = {
        ejercicio_fiscal: $("#select_ef").val(),
        idSecretaria: $("#select_Secretaria").val(),
        id_unidad: $("#select_UnidadAdministrativa").val()
    }
    repository.Mir.ContarIndicadores(req)
    .then((response)=>{
        $("#numIndicadores").html(response.data[0].indicadores)
    });

    if(req.idSecretaria == '0' || req.idSecretaria == '') {
        repository.ProgramasPresupuestales
            .GetAllCountProgramasP({ejercicio_fiscal: req.ejercicio_fiscal})
            .then((response)=> {
                $("#numProgramas").text(response.data[0]['Programas']);
                $("#numComponentes").text(response.data[0]['Componentes']);
        });
    }
    else {
        repository.ProgramasPresupuestales.GetCountProgramasP({
            id_secretaria: req.idSecretaria,
            ejercicio_fiscal: req.ejercicio_fiscal,
            id_unidad: req.id_unidad
        })
        .then((response)=>{
            $("#numProgramas").text(response.data[0]['Programas']);
            $("#numComponentes").text(response.data[0]['Componentes']);
        });
    }
    
}
