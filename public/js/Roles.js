const repository = new Repository();

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    GetRoles();
}

function GetRoles(){
    // Func_Cargando();
    repository.Roles.GetRoles()
        .then(ResponseGetRoles);
}

function ResponseGetRoles(response){
    if (!response.error) {
        if (response.data[0].RolAdmin == "1"){
            $("#check_AdministracionAccesoTotal").prop("checked", true);
        }
        
        if (response.data[1].RolAdd == "1"){
            $("#check_CapturaAnadir").prop("checked", true);
        }
        
        if (response.data[1].RolEdit == "1"){
            $("#check_CapturaEditar").prop("checked", true);
        }
        
        if (response.data[2].RolAdd == "1"){
            $("#check_RevisionAnadir").prop("checked", true);
        }
        
        if (response.data[2].RolEdit == "1"){
            $("#check_RevisionEditar").prop("checked", true);
        }
        
        if (response.data[3].RolAdd  == "1"){
            $("#check_CapturaRevisionAnadir").prop("checked", true);
        }
        
        if (response.data[3].RolEdit == "1"){
            $("#check_CapturaRevisionEditar").prop("checked", true);
        }
        
        if (response.data[4].RolAdd == "1"){
            $("#check_AutorizacionAnadir").prop("checked", true);
        }
        
        if (response.data[4].RolEdit == "1"){
            $("#check_AutorizacionEditar").prop("checked", true);
        }

        if (response.data[5].RolEdit == "1"){
            $("#check_EnlaceEditar").prop("checked", true);
        }
        
        if (response.data[5].RolEditDatosMir == "1"){
            $("#check_EnlaceEditarMir").prop("checked", true);
        }
        
        swal.close();
    } else {
        swal.close();
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function Eventos() {
    BtnGuardarSecretaria();
}

function BtnGuardarSecretaria() {
    $("#form_roles").on("submit", function(event) {
        event.preventDefault();

        var request = [
            { // Administracion
                Id: 1,
                AccesoTotal: $("#check_AdministracionAccesoTotal").prop("checked"),
                Anadir: 1,
                Editar: 0
            }
            ,
            { // Captura
                Id: 2,
                AccesoTotal: 0,
                Anadir: $("#check_CapturaAnadir").prop("checked"),
                Editar: $("#check_CapturaEditar").prop("checked")
            },
            { // Revision
                Id: 3,
                AccesoTotal: 0,
                Anadir: $("#check_RevisionAnadir").prop("checked"),
                Editar: $("#check_RevisionEditar").prop("checked")
            },
            { // Captura y revision
                Id: 4,
                AccesoTotal: 0,
                Anadir: $("#check_CapturaRevisionAnadir").prop("checked"),
                Editar: $("#check_CapturaRevisionEditar").prop("checked")
            },
            { // Autorizacion
                Id: 5,
                AccesoTotal: 0,
                Anadir: $("#check_AutorizacionAnadir").prop("checked"),
                Editar: $("#check_AutorizacionEditar").prop("checked")
            }
        ];
        
        Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información de los roles?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                Func_Cargando();
                var error = false;
                
                for (let i = 0; i < request.length; i++) {
                    const element = request[i];

                    if (request.length-1 != i){
                        repository.Roles.UpdateRoles(element)
                        .then(function(response){
                            if (response.error) {
                                error = true;
                            }
                        });
                    }else{
                        repository.Roles.UpdateRoles(element)
                            .then(ResponseRoles);
                    }
                }
            }
        });
    });
}

function ResponseRoles(response) {
    if (!response.error) {
        Func_Toast("success", "Roles actualizados.", "Los roles han sido guardados exitosamente.");
        GetRoles();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

// ======================================================
// Funciones
// ======================================================


