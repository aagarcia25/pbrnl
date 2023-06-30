
$(document).ready(function() {
    Eventos();
});

function Eventos() {
    
}

function ver_opciones(opcion) {
    $(".grupo-catalogos").addClass("d-none");
    $("#" + opcion).removeClass("d-none");
}
