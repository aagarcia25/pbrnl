// ------------------------------------------------------
// Funciones generales
// ------------------------------------------------------
function Func_DataTable(Tabla, Paginado = true, Info = true, Buscador = true, Order = 0, Order2 = "asc", Menu = 20, Columnas = "_all", Visible = true) {
    $("#" + Tabla).DataTable({
        "paging": Paginado,
        "info": Info,
        "searching": Buscador,
        "order": [
            [Order, Order2]
        ],
        "lengthMenu": [
            [(Menu * 1), (Menu * 2), (Menu * 3), (Menu * 4), (Menu * 5), -1],
            [(Menu * 1), (Menu * 2), (Menu * 3), (Menu * 4), (Menu * 5), "Todos"]
        ],
        fixedHeader: true,
        "language": {
            "decimal": "",
            "emptyTable": "No hay elementos disponibles",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ filas.",
            "infoEmpty": "Mostrando 0 a 0 de 0 filas.",
            "infoFiltered": "(filtrado de _MAX_ entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ filas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar",
            "zeroRecords": "No hay coincidencias.",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar ascendentemente",
                "sortDescending": ": activar para ordenar descendentemente"
            }
        },
        "sPaginationType": "full_numbers"
    });
}

function Func_SearchDataTable(Tabla, Search) {
    $("#" + Tabla).DataTable().search(Search).draw();
}

function DestroyDataTable(Tabla) {
    $("#" + Tabla).DataTable().destroy();
}

function justNumbers(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46)) {
        return true;
    }

    return /\d/.test(String.fromCharCode(keynum));
}

function Func_FormatoMoneda(amount, decimals) {
    amount += '';
    Monto = amount;
    amount = parseFloat(amount.replace(/[^0-9\.]/g, ''));
    decimals = decimals || 2;

    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);

    amount = '' + amount.toFixed(decimals);
    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    if (Monto.includes("-")) {
        return "-" + amount_parts.join('.');
    } else {
        return amount_parts.join('.');
    }
}

function Func_Moneda(amount, decimals) {
    Resultado = Func_FormatoMoneda(amount, decimals);
    return Resultado = "$ " + Resultado;
}

function Func_DespliegaConfirmacion(title, text, icon, btnConfirm, btnCancel, next) {
    swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: btnCancel != null ? true : false,
        confirmButtonColor: '#cfe1b9',
        cancelButtonColor: '#adb5bd',
        cancelButtonText: btnCancel,
        confirmButtonText: btnConfirm,
        allowOutsideClick: false,
        allowEscapeKey: false,
        reverseButtons: true,
        focusConfirm: false,
        focusCancel: false
    }).then((function(result) {
        next(result.value)
    }));
}

function Func_DespliegaConfirmacion2(title, text, icon, btnConfirm, btnCancel, next) {
    swal.fire({
        title: title,
        html: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#cfe1b9',
        cancelButtonColor: '#adb5bd',
        cancelButtonText: btnCancel,
        confirmButtonText: btnConfirm,
        allowOutsideClick: false,
        allowEscapeKey: false,
        reverseButtons: true,
        focusConfirm: false,
        focusCancel: false
    }).then((function(result) {
        next(result.value)
    }));
}

function Func_Aviso(title, text, type) {
    Swal.fire(
        title,
        text,
        type
    );
}

function Func_Cargando(Mensaje = "Cargando...") {
    swal.fire({
        title: Mensaje,
        allowOutsideClick: false,
        didOpen: function() {
            swal.showLoading()
        }
    });
}

function Func_Mensaje(Mensaje) {
    swal.fire({
        title: Mensaje,
        allowOutsideClick: false,
        didOpen: function() {
            swal.showLoading()
        }
    });
}

function Func_Toast(icon, title, text, time = 5000) {
    $.toast({
        heading: title,
        text: text,
        showHideTransition: 'slide',
        icon: icon,
        hideAfter: time,
        position: 'top-right',
        bgColor: '#C8B294',
        loaderBg: '#B58E5A',
        textColor: 'white'
    })
}

function SetYYYYMMDD_DDMMYYYY(Fecha){
    var Fechas = Fecha.split("-");
    return FechaFinal = Fechas[2] + "/" + Fechas[1] + "/" + Fechas[0];
}

function SetDDMMYYYY_YYYYMMDD(Fecha){
    var Fechas = Fecha.split("/");
    return FechaFinal = Fechas[2] + "-" + Fechas[1] + "-" + Fechas[0];
}

$(document).ready(function () {
    $('#Modal').on('hidden.bs.modal', function () {
        $("body").removeAttr("style");
    });
    $('#ModalActualizacion').on('hidden.bs.modal', function () {
        $("body").removeAttr("style");
    });
});

function img_over(id, nombre) {
    $("#" + id).attr('src', nombre);
}

function img_out(id, nombre) {
    $("#" + id).attr('src', nombre);
}

function MostrarHttpError(response) {
    console.error(response);
    var mensaje = response.result;
    Func_Aviso("Error", "" + mensaje + "", "error");
}

function Func_LimpiarMoneda(numero) {
    if (numero == 0 || numero == "0") {
        return numero;
    } else {
        if (numero.includes('$')) {
            while (numero.includes('$')) {
                numero = numero.replace("$", "");
            }
        }
        if (numero.includes(',')) {
            while (numero.includes(',')) {
                numero = numero.replace(",", "");
            }
        }
    }

    return numero.trim().replace(/\s+/g, '');
}
