const repository = new Repository();
var info_tipobeneficiarios = null;
var selectTipoBeneficiario = null;
var info_beneficiarios = null;

$(document).ready(function () {
    Funciones_Iniciales();
    Eventos();
});

function Funciones_Iniciales() {
    Func_Cargando();
    GetTipoBeneficiario();
}

function GetTipoBeneficiario() {
    repository.Beneficiarios.GetTiposBeneficiarios()
        .then(ResponseGetTipoBeneficiario);
}

function ResponseGetTipoBeneficiario(response) {
    if (!response.error) {
        
        $('#select_TipoBeneficiario').children().remove();
        $('#select_TipoBeneficiarioModal').children().remove();
        info_tipobeneficiarios = response.data;
        for (var i = 0; i < response.data.length; i++) {
            if (i == 0){
                selectTipoBeneficiario = response.data[i].idBeneficiario;
            }

            $('#select_TipoBeneficiario').append($('<option>', {
                value: response.data[i].idBeneficiario,
                text: ("[" + response.data[i].idBeneficiario + "] " + response.data[i].TipoBeneficiario)
            }));

            $('#select_TipoBeneficiarioModal').append($('<option>', {
                value: response.data[i].idBeneficiario,
                text: ("[" + response.data[i].idBeneficiario + "] " + response.data[i].TipoBeneficiario)
            }));
        }
        
        $('#select_TipoBeneficiario').selectpicker("refresh");
        $('#select_TipoBeneficiario').selectpicker("val", selectTipoBeneficiario);
        
        $('#select_TipoBeneficiarioModal').selectpicker("refresh");
        $('#select_TipoBeneficiarioModal').selectpicker("val", "");
        GetBeneficiarios();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function GetBeneficiarios(){
    var request = {
        "id_TipoBeneficiario": selectTipoBeneficiario
    }
    repository.Beneficiarios.GetBeneficiarios(request)
        .then(ResponseGetBeneficiarios);
}

function ResponseGetBeneficiarios(response){
    if (!response.error) {
        DestroyDataTable("table");
        $("#table > tbody > tr").remove();
        info_beneficiarios = response.data;
        if (response.data.length > 0) {
            for (var i = 0; i < response.data.length; i++) {
                $("#table > tbody").append(`
                    <tr>
                        <td>${response.data[i].idBeneficiario}</td>
                        <td>${response.data[i].idCatBeneficiario}</td>
                        <td>${response.data[i].Poblacion}</td>
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
    OnChange_TipoBeneficiario();

    BtnAgregarCatalogo();
    BtnEditarCatalogo();
    BtnEliminarCatalogo();
    BtnGuardarBeneficiario();

    BtnAgregarTipoBeneficiario();
    BtnEditarTipoBeneficiario();
    BtnEliminarTipoBeneficiario();
    BtnGuardarTipoBeneficiario();
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

function OnChange_TipoBeneficiario(){
    $("#select_TipoBeneficiario").on("change", function(){
        selectTipoBeneficiario = $(this).val();
        Func_Cargando();
        GetBeneficiarios();
    });
}

function BtnAgregarCatalogo(){
    $("#BtnAgregarCatalogo").on("click", function() {
        $("#modal_accion").text("Agregar");

        $("#select_TipoBeneficiarioModal").selectpicker("val", selectTipoBeneficiario);
        $("#select_TipoBeneficiarioModal").attr("disabled","");
        $("#select_TipoBeneficiarioModal").selectpicker("refresh");
        //$("#select_TipoBeneficiarioModal").selectpicker("hide");

        $("#id_Beneficiario").val(Func_ObtenSiguienteBeneficiario());
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
            Func_Aviso("Atención", "Para continuar favor de seleccionar un Beneficiario.", "info");
            return false;
        }

        Func_LimpiarModal();
        $("#select_TipoBeneficiarioModal").prop("disabled",true);
        $("#select_TipoBeneficiarioModal").val(data[0]);
        $("#select_TipoBeneficiarioModal").selectpicker("refresh");
        
        $("#id_Beneficiario").val(data[1]);
        $("#descripcion").val(data[2]);
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
            Func_Aviso("Atención", "Para continuar favor de seleccionar un Beneficiario.", "info");
            return false;
        }

        Func_DespliegaConfirmacion("Eliminar " + data[2], "¿Deseas eliminar el Beneficiario seleccionado?", "question", "Aceptar", "Cancelar", function(response) {
            if (response) {
                var id_beneficiario = data[0];
                var request = {
                    id_beneficiario: id_beneficiario
                };
                Func_Cargando();
                repository.Beneficiarios.DeleteBeneficiario(request)
                    .then(ResponseDeleteBeneficiario);

            }
        });
    });
}

function BtnGuardarBeneficiario(){
    $("#form_modal").on("submit", function(event) {
        event.preventDefault();

        var request = {
            id_tipobeneficiario: $("#select_TipoBeneficiarioModal").val(),
            id_beneficiario: $("#id_Beneficiario").val(),
            descripcion: $("#descripcion").val()
        };

        if ($("#modal_accion").text() == "Editar") {
            repository.Beneficiarios.EditBeneficiario(request)
                .then(ResponseEditBeneficiario);
        } else {
            repository.Beneficiarios.AddBeneficiario(request)
                .then(ResponseAddBeneficiario);
        }

        // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del Beneficiario?", "question", "Aceptar", "Cancelar", function(response) {
        //     if (response) {
        //         Func_Cargando();
        //         if ($("#modal_accion").text() == "Editar") {
        //             repository.Beneficiarios.EditBeneficiario(request)
        //                 .then(ResponseEditBeneficiario);
        //         } else {
        //             repository.Beneficiarios.AddBeneficiario(request)
        //                 .then(ResponseAddBeneficiario);
        //         }
        //     }
        // });
    });
}

function ResponseAddBeneficiario(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Beneficiario agregado.", "El Beneficiario fue agregado con éxito.");
        Func_Cargando();
        GetBeneficiarios();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseEditBeneficiario(response) {
    if (!response.error) {
        $("#Modal").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Beneficiario editado.", "El beneficiario ha sido modificado.");
        Func_Cargando();
        GetBeneficiarios();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseDeleteBeneficiario(response) {
    if (!response.error) {
        Func_Toast("success", "Beneficiario eliminado.", "El beneficiario fue eliminado de Interfaz PbR.");
        Func_Cargando();
        GetBeneficiarios();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function BtnAgregarTipoBeneficiario() {
    $("#BtnAgregarTipoBeneficiario").on("click", function(){
        $("#modal_acciontipobeneficiario").text("Agregar");

        $("#id_tipobeneficiario").val();
        $("#descripcion_tipobeneficiario").val();

        $("#Modal_TipoBeneficiario").modal("show");

        //generar el id del beneficiario
        get_ultimo_beneficiario()
        .then((response)=> {
            if(response.error == true)
            {
                Func_Aviso("Error", response.result, 'error');
                return;
            }
            $("#id_tipobeneficiario").val(response.data);
            
        });
    });
}

function BtnEditarTipoBeneficiario() {
    $("#BtnEditarTipoBeneficiario").on("click", function(){
        $("#modal_acciontipobeneficiario").text("Editar");

        let id_tipobeneficiarioseleccionado = $("#select_TipoBeneficiario").val();
        
        for (let i = 0; i < info_tipobeneficiarios.length; i++) {
            const element = info_tipobeneficiarios[i];
            
            if (element['idBeneficiario'] == id_tipobeneficiarioseleccionado){
                nombre_tipobeneficiarioseleccionado = element['TipoBeneficiario'];
                break;
            }
        }

        $("#id_tipobeneficiario").val(id_tipobeneficiarioseleccionado);
        $("#descripcion_tipobeneficiario").val(nombre_tipobeneficiarioseleccionado);

        $("#Modal_TipoBeneficiario").modal("show");
    });
}

function BtnEliminarTipoBeneficiario() {
    $('#BtnEliminarTipoBeneficiario').click(function() {
        let beneficiario =  info_tipobeneficiarios[$("#select_TipoBeneficiario")[0].selectedIndex - 1];
        console.log(beneficiario);

        Func_DespliegaConfirmacion("Eliminar " + beneficiario.TipoBeneficiario, 
            "¿Deseas eliminar el Tipo de Beneficiario seleccionado?", 
            "question", "Aceptar", "Cancelar", function(response) {
            if (!response) {
                return;
            }
            var request = {
                id: beneficiario.idBeneficiario
            };
            Func_Cargando();
            repository.Beneficiarios.DeleteTipoBeneficiario(request)
                .then(ResponseDeleteTipoBeneficiario);
        });
    });
}

function ResponseDeleteTipoBeneficiario(response) {
    swal.close();
    if(response.error){
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
        return;
    }

    const index = $("#select_TipoBeneficiario")[0].selectedIndex - 1;
    const beneficiario = info_tipobeneficiarios[index];
    info_tipobeneficiarios.splice(index, 1);
    
    $("#select_TipoBeneficiario").find("[value="+beneficiario.idBeneficiario+"]").remove();
    $("#select_TipoBeneficiario").selectpicker("refresh");
}

function BtnGuardarTipoBeneficiario() {
    $("#form_modaltipobeneficiario").on("submit", function(event){
        event.preventDefault();

        var request = {
            id_tipobeneficiario: $("#id_tipobeneficiario").val(),
            descripcion: $("#descripcion_tipobeneficiario").val()
        };

        if ($("#modal_acciontipobeneficiario").text() == "Editar") {
            repository.Beneficiarios.EditTipoBeneficiario(request)
                .then(ResponseEditTipoBeneficiario);
        } else {
            repository.Beneficiarios.AddTipoBeneficiario(request)
                .then(ResponseAddTipoBeneficiario);
        }

        // Func_DespliegaConfirmacion("Guardar", "¿Deseas guardar la información del Tipo de Beneficiario?", "question", "Aceptar", "Cancelar", function(response) {
        //     if (response) {
        //         Func_Cargando();
        //         if ($("#modal_acciontipobeneficiario").text() == "Editar") {
        //             repository.Beneficiarios.EditTipoBeneficiario(request)
        //                 .then(ResponseEditTipoBeneficiario);
        //         } else {
        //             repository.Beneficiarios.AddTipoBeneficiario(request)
        //                 .then(ResponseAddTipoBeneficiario);
        //         }
        //     }
        // });
    });
}

function ResponseEditTipoBeneficiario(response) {
    swal.close();
    if (!response.error) {
        $("#Modal_TipoBeneficiario").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Tipo de beneficiario editado.", "El Tipo Beneficiario ha sido modificado.");
        Func_Cargando();
        GetTipoBeneficiarioRefresh();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseAddTipoBeneficiario(response) {
    if (!response.error) {
        $("#Modal_TipoBeneficiario").modal("hide");
        Func_LimpiarModal();
        Func_Toast("success", "Tipo de beneficiario agregado.", "El tipo beneficiario fue agregado con éxito.");
        Func_Cargando();
        GetTipoBeneficiarioRefresh();
    } else {
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al realizar el proceso, favor de intentarlo nuevamente.", "error");
    }
}

function GetTipoBeneficiarioRefresh() {
    repository.Beneficiarios.GetTiposBeneficiarios()
        .then(ResponseGetTipoBeneficiarioRefresh);
}

function ResponseGetTipoBeneficiarioRefresh(response) {
    if (!response.error) {
        $('#select_TipoBeneficiario').selectpicker("destroy");
        $('#select_TipoBeneficiarioModal').selectpicker("destroy");

        $('#select_TipoBeneficiario').children().remove();
        $('#select_TipoBeneficiarioModal').children().remove();
        info_tipobeneficiarios = response.data;
        for (var i = 0; i < response.data.length; i++) {
            $('#select_TipoBeneficiario').append($('<option>', {
                value: response.data[i].idBeneficiario,
                text: ("[" + response.data[i].idBeneficiario + "] " + response.data[i].TipoBeneficiario)
            }));

            $('#select_TipoBeneficiarioModal').append($('<option>', {
                value: response.data[i].idBeneficiario,
                text: ("[" + response.data[i].idBeneficiario + "] " + response.data[i].TipoBeneficiario)
            }));
        }
        
        $('#select_TipoBeneficiario').selectpicker();
        $('#select_TipoBeneficiario').selectpicker("val", selectTipoBeneficiario);
        
        $('#select_TipoBeneficiarioModal').selectpicker();
        $('#select_TipoBeneficiarioModal').selectpicker("val", selectTipoBeneficiario);
        swal.close();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function get_ultimo_beneficiario() {
    return repository.Beneficiarios.GetUltimoIdTipoBeneficiario();
}

// ======================================================
// Funciones
// ======================================================

function Func_LimpiarModal() {
    $(".form-control").val("");
    $(".form-control").removeClass("is-invalid");
    $(".form-control").removeClass("is-valid");
}

function Func_ObtenSiguienteBeneficiario(){
    let contador = parseInt(info_beneficiarios.length) + parseInt(1);
    return selectTipoBeneficiario + "." + (contador < 10 ? '0' : '') + contador;
}
