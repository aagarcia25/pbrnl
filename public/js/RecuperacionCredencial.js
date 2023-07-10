const repository = new Repository();

$(document).ready(function() {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    $("#mensajeCoinciden").hide();
}

function Eventos() {
    Login();
}

function Login(){
    $("#form_login").on("submit", function(event){
        event.preventDefault();

        if (Func_Valida()) {
            var request = {
                id_usuario: $("#id_usuario").val(),
                password: $("#password").val()
            };

            Func_Cargando();
            repository.Login.Recuperar(request)
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
        Func_DespliegaConfirmacion("Contraseña cambiada", 
            "Su contraseña ha sido cambiada, por favor inicie sesión con su nombre de usuario y su nueva contraseña",
            "",
            "Aceptar", null, ()=>{
                window.location.href = 'Login';
            }
        );
    }
}

// ======================================================
// Funciones
// ======================================================

function Func_Valida() {
    var id_usuario = $("#id_usuario");
    var password = $("#password");
    var passwordConfirm = $("#passwordConfirm");
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

    if(password.val() != passwordConfirm.val()) {
        resultado = false;
        password.addClass("is-invalid");
        password.removeClass("is-valid");

        passwordConfirm.addClass("is-invalid");
        passwordConfirm.removeClass("is-valid");

        $("#mensajeCoinciden").show();
    }
    else {
        password.addClass("is-valid");
        password.removeClass("is-invalid");

        passwordConfirm.addClass("is-valid");
        passwordConfirm.removeClass("is-invalid");

        $("#mensajeCoinciden").hide();
    }

    if (!resultado) {
        Func_Aviso("Atención", "Favor de ingresar la información señalada.", "info")
    }

    return resultado;

}

