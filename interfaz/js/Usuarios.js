const repository = new Repository();
var info_secretarias = null;
var info_usuarios = null;
var info_roles = null;
var info_ua = null;

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    Func_Cargando();
    GetSecretarias();
    Datepicker();
    Mask();
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
                text: response.data[i].Descripcion
            }));
        }
        $('#select_secretaria').selectpicker("refresh");
        GetUnidadesAdministrativas();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetUnidadesAdministrativas(){
    repository.UnidadesAdministrativas.GetAllUnidadesAdministrativas()
        .then(ResponseGetAllUnidadesAdministrativas);
}

function ResponseGetAllUnidadesAdministrativas(response){
    if (!response.error) {
        $('#select_ua').children().remove();
        info_ua = response.data;
        /*for (var i = 0; i < response.data.length; i++) {
            $('#select_ua').append($('<option>', {
                value: response.data[i].idUnidad,
                text: response.data[i].Descripcion
            }));
        }*/
        $('#select_ua').selectpicker("refresh");
        GetRoles();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetRoles(){
    repository.Roles.GetRoles()
        .then(ResponseGetRoles);
}

function ResponseGetRoles(response){
    if (!response.error) {
        $('#select_roles').children().remove();
        info_roles = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_roles').append($('<option>', {
                value: response.data[i].idRol,
                text: response.data[i].Descripcion
            }));
        }
        $('#select_roles').selectpicker("refresh");
        GetUsuarios()
    } else {
        swal.close();
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetUsuarios(){
    repository.Usuarios.GetUsuarios()
        .then(ResponseGetUsuarios);
}

function ResponseGetUsuarios(response){
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        if (response.data.length > 0) {
            info_usuarios = response.data;
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].idUsuario}</td>
                        <td>${response.data[i].Nombre}</td>
                        <td>${response.data[i].APaterno}</td>
                        <td>${response.data[i].AMaterno}</td>
                        <td class="text-center">${(response.data[i].Estatus == "A" ? "SI" : "NO")}</td>
                        <td class="text-center">${response.data[i].Notificado == "S" ? `<img src="./../img/check2-circle-Activo2.svg" width="20%" class="border-none">` : `<img src="./../img/check2-circle-Inactivo2.svg" width="20%" class="border-none">`}</td>
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

function Datepicker(){
    $('.fecha').datepicker({
        format: "dd/mm/yyyy"
    });
}

function Mask(){
    $('#telefono_usuario').mask('(00) 0000 0000');
    $('#movil_usuario').mask('(00) 0000 0000');
}

function Eventos() {
    SeleccionarTabla();
    OnChange_Secretaria();
    OnChange_Ua();
    OnChange_IdUsuario();
    BtnCerrarSesionUsuario();
    BtnNotificarUsuario();
    BtnAgregarUsuario();
    BtnEditarUsuario();
    BtnGuardarUsuario();
    BtnBajaUsuario();
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

function OnChange_Secretaria(){
    $("#select_secretaria").on("change", function(){
        let id_secretaria = $(this).val();
        $("#secretaria_usuario").val(id_secretaria);

        $('#select_ua').selectpicker("destroy");
        $('#select_ua').children().remove();
        for (var i = 0; i < info_ua.length; i++) {
            if (info_ua[i].idSecretaria == id_secretaria){
                $('#select_ua').append($('<option>', {
                    value: info_ua[i].idUnidad,
                    text: info_ua[i].Descripcion
                }));
            }
        }
        $('#select_ua').selectpicker();

    });
}

function OnChange_Ua(){
    $("#select_ua").on("change", function(){
        let id_ua = $(this).val();
        $("#ua_usuario").val(id_ua);
    });
}

function OnChange_IdUsuario(){
    $(".calc_id").on("change", function(){
        let Nombre = $("#nombre_usuario").val().toUpperCase();
        let Apellido = $("#appaterno_usuario").val().toUpperCase();
        let Apellido2 = $("#apmaterno_usuario").val().toUpperCase();
        let Fecha = $("#fechanacimiento_usuario").val().toUpperCase();

        if (Nombre == ""){
            return false;
        }

        if (Apellido == ""){
            return false;
        }
        
        if (Apellido2 == ""){
            return false;
        }

        if (Fecha == ""){
            return false;
        }

        var Id_usuario = Nombre.substr(0,1) + Apellido.substr(0,1) + Apellido2.substr(0,1) + Fecha.substr(0,2) + Fecha.substr(3,2);
        $("#id_usuario").val(Id_usuario);
    });
}

function BtnCerrarSesionUsuario(){
    $("#BtnCerrarSesionUsuario").on("click", function(){
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        var request = {
            id_usuario: data[0]
        }
        
        Func_DespliegaConfirmacion("Cerrar sesión", "¿Deseas cerrar la sesión del usuario", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                Func_Cargando();
                repository.Usuarios.SaveCerrarSesion(request)
                    .then(ResponseSaveCerrarSesion);
            }
        });
    });
}

function ResponseSaveCerrarSesion(response){
    if (!response.error) {
        Func_Toast("success", "Sesión cerrada.", "La sesión del usuario seleccionado fue cerrada.");
        GetUsuarios();
    } else {
        console.log(response)
        Func_Aviso("Atención", response.message, "error");
    }
}

function BtnNotificarUsuario(){
    $("#BtnNotificarUsuario").on("click", function(){
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        var request = {
            id_usuario: data[0]
        }
        repository.Usuarios.SaveNotificacion(request)
        .then(ResponseSaveNotificacion);

/*         Func_DespliegaConfirmacion("Notificar", "¿Deseas notificar al usuario", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                Func_Cargando();
                repository.Usuarios.SaveNotificacion(request)
                    .then(ResponseSaveNotificacion);
            }
        });
 */    });
}

function ResponseSaveNotificacion(response){
    if (!response.error) {
        Func_Toast("success", "Usuario notificado.", "Se ha enviado un correo electrónico con la notificación al usuario.");
        Func_Cargando();
        GetUsuarios();
    } else {
        console.log(response)
        Func_Aviso("Atención", response.result, "error");
    }
}

function BtnAgregarUsuario(){
    $("#BtnAgregarUsuario").on("click", function() {
        $("#modal_accion").text("Agregar");
        $("#id_usuario").val("");
        $("#id_usuario").prop("disabled", false);
        $("#nombre_usuario").val("");
        $("#appaterno_usuario").val("");
        $("#apmaterno_usuario").val("");
        $("#check_Activo").prop("checked", false);
        $("#fechanacimiento_usuario").val("");
        $("#rfc_usuario").val("");
        $("#correo_usuario").val("");
        $("#telefono_usuario").val("");
        $("#movil_usuario").val("");
        $("#secretaria_usuario").val("");
        $("#select_secretaria").selectpicker("val", "");
        $('#select_ua').children().remove();
        $('#select_ua').selectpicker("refresh");
        $("#ua_usuario").val("");
        $("#select_ua").selectpicker("val", "");
        $("#puesto_usuario").val("");
        $("#select_roles").selectpicker("val", "");
        $("#check_CatalogoPbR").prop("checked", false);
        $("#check_Clasificacion").prop("checked", false);
        $("#check_Mir").prop("checked", false);
        $("#Modal").modal("show");
    });
}

function BtnEditarUsuario(){
    $("#BtnEditarUsuario").on("click", function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        var id_usuario = data[0];
        Func_LimpiarModal();
        
        for (var i = 0; i < info_usuarios.length; i++) {
            const usuario = info_usuarios[i];
            
            if (usuario.idUsuario == id_usuario){
                $("#nombre_usuario").val(usuario.Nombre);
                $("#appaterno_usuario").val(usuario.APaterno);
                $("#apmaterno_usuario").val(usuario.AMaterno);

                if (usuario.Estatus == "A"){
                    $("#check_Activo").prop("checked", true);
                }else{
                    $("#check_Activo").prop("checked", false);
                }
                
                $("#fechanacimiento_usuario").datepicker("setDate", SetYYYYMMDD_DDMMYYYY(usuario.FechaNacimiento));

                $("#rfc_usuario").val(usuario.RFC);
                $("#correo_usuario").val(usuario.eMail);
                $("#telefono_usuario").val(usuario.TelefonoOficina);
                $("#movil_usuario").val(usuario.TelefonoParticular);
                
                $("#select_secretaria").selectpicker("val", usuario.idSecretaria);
                for (let j = 0; j < info_secretarias.length; j++) {
                    const secretaria = info_secretarias[j];
                    
                    if (usuario.idSecretaria == secretaria.idSecretaria){
                        $("#secretaria_usuario").val(secretaria.idSecretaria);
                        break;
                    }
                }
                
                $('#select_ua').selectpicker("destroy");
                $('#select_ua').children().remove();

                for (let k = 0; k < info_ua.length; k++) {
                    if (info_ua[k].idSecretaria == usuario.idSecretaria){
                        $('#select_ua').append($('<option>', {
                            value: info_ua[k].idUnidad,
                            text: info_ua[k].Descripcion
                        }));
                    }
                }
                $('#select_ua').selectpicker();
                $("#select_ua").selectpicker("val", usuario.idUnidad);

                for (let l = 0; l < info_ua.length; l++) {
                    const secretaria = info_ua[l];
                    
                    if (info_ua[l].idSecretaria == usuario.idSecretaria && info_ua[l].idUnidad == usuario.idUnidad){
                        $("#ua_usuario").val(usuario.idUnidad);
                        break;
                    }
                }

                $("#puesto_usuario").val(usuario.Puesto);
                $("#select_roles").selectpicker("val", usuario.TipoUsuario);

                if (usuario.CatalogosPbR == 1){
                    $("#check_CatalogoPbR").prop("checked", true);
                }else{
                    $("#check_CatalogoPbR").prop("checked", false);
                }               

                if (usuario.ClasProgramatica == 1){
                    $("#check_Clasificacion").prop("checked", true);
                }else{
                    $("#check_Clasificacion").prop("checked", false);
                }

                if (usuario.AdminMIR == 1){
                    $("#check_Mir").prop("checked", true);
                }else{
                    $("#check_Mir").prop("checked", false);
                }
                $("#id_usuario").val(usuario.idUsuario);
                $("#id_usuario").prop("disabled", true);
                break;
            }
        }
        
        $("#modal_accion").text("Editar");
        $("#Modal").modal("show");
    });
}

function BtnBajaUsuario(){
    $('#BtnBajaUsuario').click(function() {
        var table = $('#table').DataTable();
        var index = table.row('.selected').index();
        var data = table.row(index).data();

        if (!table.rows('.selected').any()) {
            Func_Aviso("Atención", "Para continuar favor de seleccionar un registro.", "info");
            return false;
        }

        Func_DespliegaConfirmacion("Dar de baja ", "¿Deseas dar de baja el registro seleccionado?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                
                var request = {
                    id_usuario: data[0]
                };
                Func_Cargando();
                repository.Usuarios.DeleteUsuario(request)
                    .then(ResponseDeleteUsuario);

            }
        });
    });
}

function BtnGuardarUsuario(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        var request = {
            id_usuario: $("#id_usuario").val().toUpperCase(),
            nombre_usuario: $("#nombre_usuario").val().toUpperCase(),
            appaterno_usuario: $("#appaterno_usuario").val().toUpperCase(),
            apmaterno_usuario: $("#apmaterno_usuario").val().toUpperCase(),
            check_Activo: ($("#check_Activo").prop("checked") ? "A" : "I"),
            fechanacimiento_usuario: SetDDMMYYYY_YYYYMMDD($("#fechanacimiento_usuario").val()),
            rfc_usuario: $("#rfc_usuario").val(),
            correo_usuario: $("#correo_usuario").val(),
            telefono_usuario: $("#telefono_usuario").val(),
            movil_usuario: $("#movil_usuario").val(),
            secretaria_usuario: $("#secretaria_usuario").val(),
            ua_usuario: $("#ua_usuario").val(),
            puesto_usuario: $("#puesto_usuario").val().toUpperCase(),
            select_roles: $("#select_roles").val(),
            check_CatalogoPbR: ($("#check_CatalogoPbR").prop("checked") ? 1 : 0),
            check_Clasificacion: ($("#check_Clasificacion").prop("checked") ? 1 : 0),
            check_Mir: ($("#check_Mir").prop("checked") ? 1 : 0)
        };
        
        if ($("#modal_accion").text() == "Editar") {
            repository.Usuarios.EditUsuario(request)
                .then(ResponseEditUsuario);
        } else {
            repository.Usuarios.AddUsuario(request)
                .then(ResponseAddUsuario);
        }

        // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del usuario?", "question", "Aceptar", "Cancelar", function(response) {
        //     if (response) {
        //         Func_Cargando();
        //         if ($("#modal_accion").text() == "Editar") {
        //             repository.Usuarios.EditUsuario(request)
        //                 .then(ResponseEditUsuario);
        //         } else {
        //             repository.Usuarios.AddUsuario(request)
        //                 .then(ResponseAddUsuario);
        //         }
        //     }
        // });
    });
}

// *********************** CODIGO ORIGINAL *********************
// Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del usuario?", "question", "Aceptar", "Cancelar", function(response) {
//     if (response) {
//         Func_Cargando();
//         if ($("#modal_accion").text() == "Editar") {
//             repository.Usuarios.EditUsuario(request)
//                 .then(ResponseEditUsuario);
//         } else {
//             repository.Usuarios.AddUsuario(request)
//                 .then(ResponseAddUsuario);
//         }
//     }
// });
// *************************************************************


function ResponseAddUsuario(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Usuario agregado.", "El usuario fue agregado exitosamente.");
        Func_Cargando();
        GetUsuarios();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", response.message, "error");
    }
}

function ResponseEditUsuario(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Usuario editado.", "El usuario fue editado exitosamente.");
        Func_Cargando();
        GetUsuarios();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteUsuario(response) {
    if (!response.error) {
        Func_Toast("success", "Usuario dado de baja.", "El usuario fue dado de baja exitosamente.");
        Func_Cargando();
        GetUsuarios();
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


