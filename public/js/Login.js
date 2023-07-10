const repository = new Repository();

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    
}

function Eventos() {
    Login();
    BtnOlvidasteContrasena()
}

function BtnOlvidasteContrasena() {
    $("#btnOlvidasteContrasena").on("click", function() {
        Func_DespliegaConfirmacion(
            "Solicitud de recuperación de contraseña",
            "Si el usuario existe, se enviará un correo electrónico con las instrucciones para recuperar la contraseña ¿Está de acuerdo?",
            "",
            "Aceptar",
            "Cancelar",
            EnviarCorreoRecuperacion
        )
    });
}

function EnviarCorreoRecuperacion(r) {
    if(!r)
        return;

    Func_Cargando("Enviando correo de recuperación, espere por favor");
    var request = {
        id_usuario: $("#id_usuario").val().toUpperCase()
    };

    repository.Login.SolicitarRecuperacionContrasena(request)
    .then(ResponseSolicitarRecuperacionContrasena);
}

function Login(){
    $("#form_login").on("submit", function(event){
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_usuario: $("#id_usuario").val(),
                password: $("#password").val()
            };

            // Func_Cargando();
            repository.Login.Login(request)
                .then(ResponseLogin);
        }
    });
}

function ResponseLogin(response){
    console.log(response)
    swal.close();
    if (response.error){
        $("#mensaje_modal").text(response.message);
        $("#Modal").modal("show");
    }else{
        window.location.href = 'Menu';
    }
}

function ResponseSolicitarRecuperacionContrasena(response) {
    swal.close();
    if (!response.error) {
        Func_Aviso("Correcto", "Se han enviado las instrucciones de recuperación de contraseña a su correo electrónico");
    } else {
        Func_Aviso("Error", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}
// ======================================================
// Funciones
// ======================================================

function Func_Valida() {
    var id_usuario = $("#id_usuario");
    var password = $("#password");
    var resultado = true;

    if (id_usuario.val() == "" || id_usuario.val() == null || id_usuario.val() == undefined) {
        resultado = false;
        id_usuario.addClass("is-invalid");
        id_usuario.removeClass("is-valid");
    } else {
        id_usuario.removeClass("is-invalid");
        id_usuario.addClass("is-valid");
    }

    if (password.val() == "" || password.val() == null || password.val() == undefined) {
        resultado = false;
        password.addClass("is-invalid");
        password.removeClass("is-valid");
    } else {
        password.removeClass("is-invalid");
        password.addClass("is-valid");
    }

    if (!resultado) {
        Func_Aviso("Atención", "Favor de ingresar la información señalada.", "info")
    }

    return resultado;

}

