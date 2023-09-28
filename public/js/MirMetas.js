
// ======================================================
// C O M P O N E N T E
// S E M E S T R A L
// ======================================================

function OnBlur_MetaS1V1D_Componente(){
    $("#metasemestral1V1D_componente").on("blur", function(){
        MetaS1V1D_Componente();
    });
}

function MetaS1V1D_Componente(){
    let total = $("#metasemestral1V1D_componente").val();
    $("#metasemestral1V1D_componente").val(Func_FormatoMoneda(total,2));
    $("#metasemestral1V1A_componente").val(Func_FormatoMoneda(total, 2));
}

function OnBlur_MetaS2V1D_Componente(){
    $("#metasemestral2V1D_componente").on("blur", function(){
        MetaS2V1D_Componente();
    });
}

function MetaS2V1D_Componente(){
    let metasemestral1V1A = $("#metasemestral1V1A_componente").val();
    let total = $("#metasemestral2V1D_componente").val();
    $("#metasemestral2V1D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metasemestral2V1D_componente").val()) + parseFloat(metasemestral1V1A);
    $("#metasemestral2V1A_componente").val(Func_FormatoMoneda(sumatoria, 2));
}

function OnBlur_MetaS1V2D_Componente(){
    $("#metasemestral1V2D_componente").on("blur", function(){
        let valor = $("#metasemestral1V2D_componente").val();
        if ($("#clicDenominador_componente").val() == 1){

            $("#metasemestral1V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metasemestral2V2D_componente").val(Func_FormatoMoneda(valor,2));

            $("#metasemestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metasemestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
        }

        MetaS1V2D_Componente();
    });
}

function MetaS1V2D_Componente(){
    let total = $("#metasemestral1V2D_componente").val();
    $("#metasemestral1V2D_componente").val(Func_FormatoMoneda(total,2));
    $("#metasemestral1V2A_componente").val(Func_FormatoMoneda(total, 2));
}

function OnBlur_MetaS2V2D_Componente(){
    $("#metasemestral2V2D_componente").on("blur", function(){
        let valor = $("#metasemestral2V2D_componente").val();
        if ($("#clicDenominador_componente").val() == 1){

            $("#metasemestral1V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metasemestral2V2D_componente").val(Func_FormatoMoneda(valor,2));

            $("#metasemestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metasemestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
        }
        MetaS2V2D_Componente();
    });
}

function MetaS2V2D_Componente(){
    let metasemestral1V2A = $("#metasemestral1V2A_componente").val();
    let total = $("#metasemestral2V2D_componente").val();
    $("#metasemestral2V2D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metasemestral2V2D_componente").val()) + parseFloat(metasemestral1V2A);
    
    if ($("#clicDenominador_componente").val() == 0){
        $("#metasemestral2V2A_componente").val(Func_FormatoMoneda(sumatoria, 2));
    }
}

// ======================================================
// C O M P O N E N T E
// T R I M E S T R A L
// ======================================================

function OnBlur_MetaT1V1D_Componente(){
    $("#metatrimestral1V1D_componente").on("blur", function(){
        MetaT1V1D_Componente();
    });
}

function MetaT1V1D_Componente(){
    let total = $("#metatrimestral1V1D_componente").val();
    $("#metatrimestral1V1D_componente").val(Func_FormatoMoneda(total,2));
    $("#metatrimestral1V1A_componente").val(Func_FormatoMoneda(total, 2));
}

function OnBlur_MetaT2V1D_Componente(){
    $("#metatrimestral2V1D_componente").on("blur", function(){
        MetaT2V1D_Componente();
    });
}

function MetaT2V1D_Componente(){
    let metatrimestral1V1A = $("#metatrimestral1V1A_componente").val();
    let total = $("#metatrimestral2V1D_componente").val();
    $("#metatrimestral2V1D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral2V1D_componente").val()) + parseFloat(metatrimestral1V1A);
    $("#metatrimestral2V1A_componente").val(Func_FormatoMoneda(sumatoria, 2));
}

function OnBlur_MetaT3V1D_Componente(){
    $("#metatrimestral3V1D_componente").on("blur", function(){
        MetaT3V1D_Componente();
    });
}

function MetaT3V1D_Componente(){
    let metatrimestral2V1A = $("#metatrimestral2V1A_componente").val();
    let total = $("#metatrimestral3V1D_componente").val();
    $("#metatrimestral3V1D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral3V1D_componente").val()) + parseFloat(metatrimestral2V1A);
    $("#metatrimestral3V1A_componente").val(Func_FormatoMoneda(sumatoria, 2));
}

function OnBlur_MetaT4V1D_Componente(){
    $("#metatrimestral4V1D_componente").on("blur", function(){
        MetaT4V1D_Componente();
    });
}

function MetaT4V1D_Componente(){
    let metatrimestral3V1A = $("#metatrimestral3V1A_componente").val();
    let total = $("#metatrimestral4V1D_componente").val();
    $("#metatrimestral4V1D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral4V1D_componente").val()) + parseFloat(metatrimestral3V1A);
    $("#metatrimestral4V1A_componente").val(Func_FormatoMoneda(sumatoria, 2));
    $("#variableV1_componente").val(Func_FormatoMoneda(sumatoria, 2));
}

function OnBlur_MetaT1V2D_Componente(){
    $("#metatrimestral1V2D_componente").on("blur", function(){
        let valor = $("#metatrimestral1V2D_componente").val();
        if ($("#clicDenominador_componente").val() == 1){

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_componente").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_componente").val(Func_FormatoMoneda(valor,2));
        }
        MetaT1V2D_Componente();
    });
}

function MetaT1V2D_Componente(){
    let total = $("#metatrimestral1V2D_componente").val();
    $("#metatrimestral1V2D_componente").val(Func_FormatoMoneda(total,2));
    $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(total, 2));
}

function OnBlur_MetaT2V2D_Componente(){
    $("#metatrimestral2V2D_componente").on("blur", function(){
        let valor = $("#metatrimestral2V2D_componente").val();
        if ($("#clicDenominador_componente").val() == 1){

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_componente").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_componente").val(Func_FormatoMoneda(valor,2));
        }
        MetaT2V2D_Componente();
    });
}

function MetaT2V2D_Componente(){
    let metatrimestral1V2A = $("#metatrimestral1V2A_componente").val();
    let total = $("#metatrimestral2V2D_componente").val();
    $("#metatrimestral2V2D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral2V2D_componente").val()) + parseFloat(metatrimestral1V2A);

    if ($("#clicDenominador_componente").val() == 0){
        $("#metatrimestral2V2A_componente").val(Func_FormatoMoneda(sumatoria, 2));
    }
}

function OnBlur_MetaT3V2D_Componente(){
    $("#metatrimestral3V2D_componente").on("blur", function(){
        let valor = $("#metatrimestral3V2D_componente").val();
        if ($("#clicDenominador_componente").val() == 1){

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_componente").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_componente").val(Func_FormatoMoneda(valor,2));
        }
        MetaT3V2D_Componente();
    });
}

function MetaT3V2D_Componente(){
    let metatrimestral3V2A = $("#metatrimestral2V2A_componente").val();
    let total = $("#metatrimestral3V2D_componente").val();
    $("#metatrimestral3V2D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral3V2D_componente").val()) + parseFloat(metatrimestral3V2A);
    
    if ($("#clicDenominador_componente").val() == 0){
        $("#metatrimestral3V2A_componente").val(Func_FormatoMoneda(sumatoria, 2));
    }
}

function OnBlur_MetaT4V2D_Componente(){
    $("#metatrimestral4V2D_componente").on("blur", function(){
        let valor = $("#metatrimestral4V2D_componente").val();
        if ($("#clicDenominador_componente").val() == 1){

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_componente").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_componente").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_componente").val(Func_FormatoMoneda(valor,2));
        }
        MetaT4V2D_Componente();
    });
}

function MetaT4V2D_Componente(){
    let metatrimestral3V2A = $("#metatrimestral3V2A_componente").val();
    let total = $("#metatrimestral4V2D_componente").val();
    $("#metatrimestral4V2D_componente").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral4V2D_componente").val()) + parseFloat(metatrimestral3V2A);
    
    if ($("#clicDenominador_componente").val() == 0){
        $("#metatrimestral4V2A_componente").val(Func_FormatoMoneda(sumatoria, 2));
    }
    
    $("#variableV2_componente").val(Func_FormatoMoneda(sumatoria, 2));
}

// ======================================================
// A C T I V I D A D
// T R I M E S T R A L
// ======================================================

function OnBlur_MetaT1V1D_Actividad(){
    $("#metatrimestral1V1D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
    });
}

function MetaT1V1D_Actividad(){
    let total = $("#metatrimestral1V1D_actividad").val();
    $("#metatrimestral1V1D_actividad").val(Func_FormatoMoneda(total,2));
    $("#metatrimestral1V1A_actividad").val(Func_FormatoMoneda(total, 2));
}

function OnBlur_MetaT2V1D_Actividad(){
    $("#metatrimestral2V1D_actividad").on("blur", function(){
        MetaT2V1D_Actividad();
    });
}

function MetaT2V1D_Actividad(){
    let metatrimestral1V1A = $("#metatrimestral1V1A_actividad").val();
    let total = $("#metatrimestral2V1D_actividad").val();
    $("#metatrimestral2V1D_actividad").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral2V1D_actividad").val()) + parseFloat(metatrimestral1V1A);
    $("#metatrimestral2V1A_actividad").val(Func_FormatoMoneda(sumatoria, 2));
}

function OnBlur_MetaT3V1D_Actividad(){
    $("#metatrimestral3V1D_actividad").on("blur", function(){
        MetaT3V1D_Actividad();
    });
}

function MetaT3V1D_Actividad(){
    let metatrimestral2V1A = $("#metatrimestral2V1A_actividad").val();
    let total = $("#metatrimestral3V1D_actividad").val();
    $("#metatrimestral3V1D_actividad").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral3V1D_actividad").val()) + parseFloat(metatrimestral2V1A);
    $("#metatrimestral3V1A_actividad").val(Func_FormatoMoneda(sumatoria, 2));
}

function OnBlur_MetaT4V1D_Actividad(){
    $("#metatrimestral4V1D_actividad").on("blur", function(){
        MetaT4V1D_Actividad();
    });
}

function MetaT4V1D_Actividad(){
    let metatrimestral3V1A = $("#metatrimestral3V1A_actividad").val();
    let total = $("#metatrimestral4V1D_actividad").val();
    $("#metatrimestral4V1D_actividad").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral4V1D_actividad").val()) + parseFloat(metatrimestral3V1A);
    $("#metatrimestral4V1A_actividad").val(Func_FormatoMoneda(sumatoria, 2));
    $("#variableV1_actividad").val(Func_FormatoMoneda(sumatoria, 2));
}

function OnBlur_MetaT1V2D_Actividad(){
    $("#metatrimestral1V2D_actividad").on("blur", function(){
        let valor = $("#metatrimestral1V2D_actividad").val();
        if ($("#clicDenominador_actividad").val() == 1){

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_actividad").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_actividad").val(Func_FormatoMoneda(valor,2));
        }

        MetaT1V2D_Actividad();
    });
}

function MetaT1V2D_Actividad(){
    let total = $("#metatrimestral1V2D_actividad").val();
    $("#metatrimestral1V2D_actividad").val(Func_FormatoMoneda(total,2));
    $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(total, 2));
}

function OnBlur_MetaT2V2D_Actividad(){
    $("#metatrimestral2V2D_actividad").on("blur", function(){
        let valor = $("#metatrimestral1V2D_actividad").val();
        if ($("#clicDenominador_actividad").val() == 1){

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_actividad").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_actividad").val(Func_FormatoMoneda(valor,2));
        }
        MetaT2V2D_Actividad();
    });
}

function MetaT2V2D_Actividad(){
    let metatrimestral1V2A = $("#metatrimestral1V2A_actividad").val();
    let total = $("#metatrimestral2V2D_actividad").val();
    $("#metatrimestral2V2D_actividad").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral2V2D_actividad").val()) + parseFloat(metatrimestral1V2A);
    
    if ($("#clicDenominador_actividad").val() == 0){
        $("#metatrimestral2V2A_actividad").val(Func_FormatoMoneda(sumatoria, 2));
    }
}

function OnBlur_MetaT3V2D_Actividad(){
    $("#metatrimestral3V2D_actividad").on("blur", function(){
        let valor = $("#metatrimestral1V2D_actividad").val();
        if ($("#clicDenominador_actividad").val() == 1){

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_actividad").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_actividad").val(Func_FormatoMoneda(valor,2));
        }
        MetaT3V2D_Actividad();
    });
}

function MetaT3V2D_Actividad(){
    let metatrimestral3V2A = $("#metatrimestral2V2A_actividad").val();
    let total = $("#metatrimestral3V2D_actividad").val();
    $("#metatrimestral3V2D_actividad").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral3V2D_actividad").val()) + parseFloat(metatrimestral3V2A);
    
    if ($("#clicDenominador_actividad").val() == 0){
        $("#metatrimestral3V2A_actividad").val(Func_FormatoMoneda(sumatoria, 2));
    }
}

function OnBlur_MetaT4V2D_Actividad(){
    $("#metatrimestral4V2D_actividad").on("blur", function(){
        let valor = $("#metatrimestral1V2D_actividad").val();
        if ($("#clicDenominador_actividad").val() == 1){

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2D_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2D_actividad").val(Func_FormatoMoneda(valor,2));

            $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral2V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral3V2A_actividad").val(Func_FormatoMoneda(valor,2));
            $("#metatrimestral4V2A_actividad").val(Func_FormatoMoneda(valor,2));
        }
        MetaT4V2D_Actividad();
    });
}

function MetaT4V2D_Actividad(){
    let metatrimestral3V2A = $("#metatrimestral3V2A_actividad").val();
    let total = $("#metatrimestral4V2D_actividad").val();
    $("#metatrimestral4V2D_actividad").val(Func_FormatoMoneda(total,2));
    let sumatoria = parseFloat($("#metatrimestral4V2D_actividad").val()) + parseFloat(metatrimestral3V2A);
    
    if ($("#clicDenominador_actividad").val() == 0){
        $("#metatrimestral4V2A_actividad").val(Func_FormatoMoneda(sumatoria, 2));
    }

    $("#variableV2_actividad").val(Func_FormatoMoneda(sumatoria, 2));
}

// ======================================================
// C O M P O N E N T E
// M E T A S   T R I M E S T R A L E S
// ======================================================

function MetaT12Anual_Componente(){
    $("#metatrimestral2V1A_componente").change(function(){
        let metatrimestral2V1A = $("#metatrimestral2V1A_componente").val();
        let metatrimestral2V2A = $("#metatrimestral2V2A_componente").val();

        let formula = Func_CalcularMeta(metatrimestral2V1A, metatrimestral2V2A, "componente");
        $("#metatrimestral2_componente").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral2V2A_componente").change(function(){
        let metatrimestral2V1A = $("#metatrimestral2V1A_componente").val();
        let metatrimestral2V2A = $("#metatrimestral2V2A_componente").val();

        let formula = Func_CalcularMeta(metatrimestral2V1A, metatrimestral2V2A, "componente");
        $("#metatrimestral2_componente").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral3V1A_componente").change(function(){
        let metatrimestral3V1A = $("#metatrimestral3V1A_componente").val();
        let metatrimestral3V2A = $("#metatrimestral3V2A_componente").val();

        let formula = Func_CalcularMeta(metatrimestral3V1A, metatrimestral3V2A, "componente");
        $("#metatrimestral3_componente").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral3V2A_componente").change(function(){
        let metatrimestral3V1A = $("#metatrimestral3V1A_componente").val();
        let metatrimestral3V2A = $("#metatrimestral3V2A_componente").val();

        let formula = Func_CalcularMeta(metatrimestral3V1A, metatrimestral3V2A, "componente");
        $("#metatrimestral3_componente").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral4V1A_componente").change(function(){
        let metatrimestral4V1A = $("#metatrimestral4V1A_componente").val();
        let metatrimestral4V2A = $("#metatrimestral4V2A_componente").val();

        let formula = Func_CalcularMeta(metatrimestral4V1A, metatrimestral4V2A, "componente");
        $("#metatrimestral4_componente").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral4V2A_componente").change(function(){
        let metatrimestral4V1A = $("#metatrimestral4V1A_componente").val();
        let metatrimestral4V2A = $("#metatrimestral4V2A_componente").val();

        let formula = Func_CalcularMeta(metatrimestral4V1A, metatrimestral4V2A, "componente");
        $("#metatrimestral4_componente").val(Func_FormatoMoneda(formula, 2));
    });


    $("#metatrimestral1_componente").change(function(){
        let metatrimestral4 = $("#metatrimestral4_componente").val();

        $("#metaanual_componente").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
    $("#metatrimestral2_componente").change(function(){
        let metatrimestral4 = $("#metatrimestral4_componente").val();

        $("#metaanual_componente").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
    $("#metatrimestral3_componente").change(function(){
        let metatrimestral4 = $("#metatrimestral4_componente").val();

        $("#metaanual_componente").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
    $("#metatrimestral4_componente").change(function(){
        let metatrimestral4 = $("#metatrimestral4_componente").val();

        $("#metaanual_componente").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
}

function MetaT1V12_Componente(){
    $("#metatrimestral1V1D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral1V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral1V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral1_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral1_componente").trigger('change');
    });
    $("#metatrimestral1V2D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral1V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral1V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral1_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral1_componente").trigger('change');
    });
}

function MetaT2V12_Componente(){
    $("#metatrimestral2V1D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral2V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral2V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral2_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral2_componente").trigger('change');
    });
    $("#metatrimestral2V2D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral2V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral2V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral2_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral2_componente").trigger('change');
    });
}

function MetaT3V12_Componente(){
    $("#metatrimestral3V1D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral3V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral3V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral3_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral3_componente").trigger('change');
    });
    $("#metatrimestral3V2D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral3V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral3V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral3_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral3_componente").trigger('change');
    });
}

function MetaT4V12_Componente(){
    $("#metatrimestral4V1D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral4V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral4V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral4_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral4_componente").trigger('change');
    });
    $("#metatrimestral4V2D_componente").on("blur", function(){

        MetaT1V1D_Componente();
        MetaT2V1D_Componente();
        MetaT3V1D_Componente();
        MetaT4V1D_Componente();
        MetaT1V2D_Componente();
        MetaT2V2D_Componente();
        MetaT3V2D_Componente();
        MetaT4V2D_Componente();

        let metatrimestral1V2A = parseFloat($("#metatrimestral4V1A_componente").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral4V2A_componente").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
        $("#metatrimestral4_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_componente").trigger('change');
        $("#metatrimestral2V2A_componente").trigger('change');
        $("#metatrimestral3V1A_componente").trigger('change');
        $("#metatrimestral3V2A_componente").trigger('change');
        $("#metatrimestral4V1A_componente").trigger('change');
        $("#metatrimestral4V2A_componente").trigger('change');
        $("#metatrimestral4_componente").trigger('change');
    });
}

// ======================================================
// A C T I V I D A D
// M E T A S   T R I M E S T R A L E S
// ======================================================

function MetaT12Anual_Actividad(){
    $("#metatrimestral2V1A_actividad").change(function(){
        let metatrimestral2V1A = $("#metatrimestral2V1A_actividad").val();
        let metatrimestral2V2A = $("#metatrimestral2V2A_actividad").val();

        let formula = Func_CalcularMeta(metatrimestral2V1A, metatrimestral2V2A, "actividad");
        $("#metatrimestral2_actividad").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral2V2A_actividad").change(function(){
        let metatrimestral2V1A = $("#metatrimestral2V1A_actividad").val();
        let metatrimestral2V2A = $("#metatrimestral2V2A_actividad").val();

        let formula = Func_CalcularMeta(metatrimestral2V1A, metatrimestral2V2A, "actividad");
        $("#metatrimestral2_actividad").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral3V1A_actividad").change(function(){
        let metatrimestral3V1A = $("#metatrimestral3V1A_actividad").val();
        let metatrimestral3V2A = $("#metatrimestral3V2A_actividad").val();

        let formula = Func_CalcularMeta(metatrimestral3V1A, metatrimestral3V2A, "actividad");
        $("#metatrimestral3_actividad").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral3V2A_actividad").change(function(){
        let metatrimestral3V1A = $("#metatrimestral3V1A_actividad").val();
        let metatrimestral3V2A = $("#metatrimestral3V2A_actividad").val();

        let formula = Func_CalcularMeta(metatrimestral3V1A, metatrimestral3V2A, "actividad");
        $("#metatrimestral3_actividad").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral4V1A_actividad").change(function(){
        let metatrimestral4V1A = $("#metatrimestral4V1A_actividad").val();
        let metatrimestral4V2A = $("#metatrimestral4V2A_actividad").val();

        let formula = Func_CalcularMeta(metatrimestral4V1A, metatrimestral4V2A, "actividad");
        $("#metatrimestral4_actividad").val(Func_FormatoMoneda(formula, 2));
    });
    $("#metatrimestral4V2A_actividad").change(function(){
        let metatrimestral4V1A = $("#metatrimestral4V1A_actividad").val();
        let metatrimestral4V2A = $("#metatrimestral4V2A_actividad").val();

        let formula = Func_CalcularMeta(metatrimestral4V1A, metatrimestral4V2A, "actividad");
        $("#metatrimestral4_actividad").val(Func_FormatoMoneda(formula, 2));
    });


    $("#metatrimestral1_actividad").change(function(){
        let metatrimestral4 = $("#metatrimestral4_actividad").val();

        $("#metaanual_actividad").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
    $("#metatrimestral2_actividad").change(function(){
        let metatrimestral4 = $("#metatrimestral4_actividad").val();

        $("#metaanual_actividad").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
    $("#metatrimestral3_actividad").change(function(){
        let metatrimestral4 = $("#metatrimestral4_actividad").val();

        $("#metaanual_actividad").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
    $("#metatrimestral4_actividad").change(function(){
        let metatrimestral4 = $("#metatrimestral4_actividad").val();

        $("#metaanual_actividad").val(Func_FormatoMoneda(metatrimestral4, 2));
    });
}

function MetaT1V12_Actividad(){
    $("#metatrimestral1V1D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral1V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral1V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral1_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral1_actividad").trigger('change');
    });
    $("#metatrimestral1V2D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral1V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral1V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral1_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral1_actividad").trigger('change');
    });
}

function MetaT2V12_Actividad(){
    $("#metatrimestral2V1D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral2V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral2V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral2_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral2_actividad").trigger('change');
    });
    $("#metatrimestral2V2D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral2V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral2V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral2_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral2_actividad").trigger('change');
    });
}

function MetaT3V12_Actividad(){
    $("#metatrimestral3V1D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral3V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral3V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral3_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral3_actividad").trigger('change');
    });
    $("#metatrimestral3V2D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral3V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral3V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral3_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral3_actividad").trigger('change');
    });
}

function MetaT4V12_Actividad(){
    $("#metatrimestral4V1D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral4V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral4V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral4_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral4_actividad").trigger('change');
    });
    $("#metatrimestral4V2D_actividad").on("blur", function(){
        MetaT1V1D_Actividad();
        MetaT2V1D_Actividad();
        MetaT3V1D_Actividad();
        MetaT4V1D_Actividad();
        MetaT1V2D_Actividad();
        MetaT2V2D_Actividad();
        MetaT3V2D_Actividad();
        MetaT4V2D_Actividad();

        let metatrimestral1V2A = parseFloat($("#metatrimestral4V1A_actividad").val());
        let metatrimestral2V2A = parseFloat($("#metatrimestral4V2A_actividad").val());
        
        let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
        $("#metatrimestral4_actividad").val(Func_FormatoMoneda(formula, 2));
        $("#metatrimestral2V1A_actividad").trigger('change');
        $("#metatrimestral2V2A_actividad").trigger('change');
        $("#metatrimestral3V1A_actividad").trigger('change');
        $("#metatrimestral3V2A_actividad").trigger('change');
        $("#metatrimestral4V1A_actividad").trigger('change');
        $("#metatrimestral4V2A_actividad").trigger('change');
        $("#metatrimestral4_actividad").trigger('change');
    });
}

// ======================================================
// C O M P O N E N T E
// M E T A S   T R I M E S T R A L E S
// ======================================================

function MetaS12Anual_Componente(){
    $("#metasemestral2V1A_componente").change(function(){
        let metasemestral1V2A = $("#metasemestral2V1A_componente").val();

        $("#variableV1_componente").val(Func_FormatoMoneda(metasemestral1V2A, 2));
    });
    $("#metasemestral2V2A_componente").change(function(){
        let metasemestral2V2A = $("#metasemestral2V2A_componente").val();

        $("#variableV2_componente").val(Func_FormatoMoneda(metasemestral2V2A, 2));
    });
    $("#metasemestral1_componente").change(function(){
        let metasemestral2 = $("#metasemestral2_componente").val();

        $("#metaanual_componente").val(Func_FormatoMoneda(metasemestral2, 2));
    });
    $("#metasemestral2_componente").change(function(){
        let metasemestral2 = $("#metasemestral2_componente").val();

        $("#metaanual_componente").val(Func_FormatoMoneda(metasemestral2, 2));
    });
}

function MetaS1V12_Componente(){
    $("#metasemestral1V1D_componente").on("blur", function(){
        MetaS1V1D_Componente();
        MetaS1V2D_Componente();
        MetaS2V1D_Componente();
        MetaS2V2D_Componente();

        let metasemestral1V1A = parseFloat($("#metasemestral1V1A_componente").val());
        let metasemestral1V2A = parseFloat($("#metasemestral1V2A_componente").val());
        
        let formula = Func_CalcularMeta(metasemestral1V1A, metasemestral1V2A, "componente");
        $("#metasemestral1_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metasemestral2V1A_componente").trigger('change');
        $("#metasemestral1_componente").trigger('change');
    });
    $("#metasemestral1V2D_componente").on("blur", function(){
        MetaS1V1D_Componente();
        MetaS1V2D_Componente();
        MetaS2V1D_Componente();
        MetaS2V2D_Componente();

        let metasemestral1V1A = parseFloat($("#metasemestral1V1A_componente").val());
        let metasemestral1V2A = parseFloat($("#metasemestral1V2A_componente").val());
        
        let formula = Func_CalcularMeta(metasemestral1V1A, metasemestral1V2A, "componente");
        $("#metasemestral1_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metasemestral2V2A_componente").trigger('change');
        $("#metasemestral1_componente").trigger('change');
    });
}

function MetaS2V12_Componente(){
    $("#metasemestral2V1D_componente").on("blur", function(){
        MetaS1V1D_Componente();
        MetaS1V2D_Componente();
        MetaS2V1D_Componente();
        MetaS2V2D_Componente();

        let metasemestral2V1A = parseFloat($("#metasemestral2V1A_componente").val());
        let metasemestral2V2A = parseFloat($("#metasemestral2V2A_componente").val());
        
        let formula = Func_CalcularMeta(metasemestral2V1A, metasemestral2V2A, "componente");
        $("#metasemestral2_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metasemestral2V1A_componente").trigger('change');
        $("#metasemestral2_componente").trigger('change');
    });
    $("#metasemestral2V2D_componente").on("blur", function(){
        MetaS1V1D_Componente();
        MetaS1V2D_Componente();
        MetaS2V1D_Componente();
        MetaS2V2D_Componente();

        let metasemestral2V1A = parseFloat($("#metasemestral2V1A_componente").val());
        let metasemestral2V2A = parseFloat($("#metasemestral2V2A_componente").val());
        
        let formula = Func_CalcularMeta(metasemestral2V1A, metasemestral2V2A, "componente");
        $("#metasemestral2_componente").val(Func_FormatoMoneda(formula, 2));
        $("#metasemestral2V2A_componente").trigger('change');
        $("#metasemestral2_componente").trigger('change');
    });
}

// ======================================================
// C O M P O N E N T E
// L I N E A   B A S E
// ======================================================

function LineaBase_Fin(){
    $("#lineabaseV1_fin").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);

        let lineabaseV1 = parseFloat($("#lineabaseV1_fin").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_fin").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "fin");
        $("#lineabase_fin1").val(Func_FormatoMoneda(formula, 2));
    });

    $("#lineabaseV2_fin").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);

        let lineabaseV1 = parseFloat($("#lineabaseV1_fin").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_fin").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "fin");
        $("#lineabase_fin1").val(Func_FormatoMoneda(formula, 2));
    });
}

function LineaBase_Proposito(){
    $("#lineabaseV1_proposito").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);

        let lineabaseV1 = parseFloat($("#lineabaseV1_proposito").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_proposito").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "proposito");
        $("#lineabase_proposito1").val(Func_FormatoMoneda(formula, 2));
    });

    $("#lineabaseV2_proposito").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);

        let lineabaseV1 = parseFloat($("#lineabaseV1_proposito").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_proposito").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "proposito");
        $("#lineabase_proposito1").val(Func_FormatoMoneda(formula, 2));
    });
}

function LineaBase_Componente(){
    $("#lineabaseV1_componente").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);
        let lineabaseV1 = parseFloat($("#lineabaseV1_componente").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_componente").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "componente");
        $("#lineabase_componente1").val(Func_FormatoMoneda(formula, 2));
    });

    $("#lineabaseV2_componente").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);
        let lineabaseV1 = parseFloat($("#lineabaseV1_componente").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_componente").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "componente");
        $("#lineabase_componente1").val(Func_FormatoMoneda(formula, 2));
    });
}

// ======================================================
// A C T I V I D A D
// L I N E A   B A S E
// ======================================================

function LineaBase_Actividad(){
    $("#lineabaseV1_actividad").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);
        let lineabaseV1 = parseFloat($("#lineabaseV1_actividad").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_actividad").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "actividad");
        $("#lineabase_actividad1").val(Func_FormatoMoneda(formula, 2));
    });

    $("#lineabaseV2_actividad").on("change", function(){
        this.value = Func_FormatoMoneda(this.value);
        let lineabaseV1 = parseFloat($("#lineabaseV1_actividad").val());
        let lineabaseV2 = parseFloat($("#lineabaseV2_actividad").val());

        let formula = Func_CalcularMeta(lineabaseV1, lineabaseV2, "actividad");
        $("#lineabase_actividad1").val(Func_FormatoMoneda(formula, 2));
    });
}

// ======================================================
// I N I C I A L
// ======================================================

function InicialTrimestral_Componente(){
    MetaT1V1D_Componente();
    MetaT2V1D_Componente();
    MetaT3V1D_Componente();
    MetaT4V1D_Componente();
    MetaT1V2D_Componente();
    MetaT2V2D_Componente();
    MetaT3V2D_Componente();
    MetaT4V2D_Componente();

    let metatrimestral1V2A = parseFloat($("#metatrimestral4V1A_componente").val());
    let metatrimestral2V2A = parseFloat($("#metatrimestral4V2A_componente").val());
    
    let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "componente");
    $("#metatrimestral4_componente").val(Func_FormatoMoneda(formula, 2));
    $("#metatrimestral2V1A_componente").trigger('change');
    $("#metatrimestral2V2A_componente").trigger('change');
    $("#metatrimestral3V1A_componente").trigger('change');
    $("#metatrimestral3V2A_componente").trigger('change');
    $("#metatrimestral4V1A_componente").trigger('change');
    $("#metatrimestral4V2A_componente").trigger('change');
    $("#metatrimestral4_componente").trigger('change');
}

function InicialSemestral_Componente(){
    MetaS1V1D_Componente();
    MetaS1V2D_Componente();
    MetaS2V1D_Componente();
    MetaS2V2D_Componente();

    let metasemestral2V1A = parseFloat($("#metasemestral2V1A_componente").val());
    let metasemestral2V2A = parseFloat($("#metasemestral2V2A_componente").val());
    
    let formula = Func_CalcularMeta(metasemestral2V1A, metasemestral2V2A, "componente");
    $("#metasemestral2_componente").val(Func_FormatoMoneda(formula, 2));
    $("#metasemestral2V2A_componente").trigger('change');
    $("#metasemestral2_componente").trigger('change');
}

function InicialTrimestral_Actividad(){
    MetaT1V1D_Actividad();
    MetaT2V1D_Actividad();
    MetaT3V1D_Actividad();
    MetaT4V1D_Actividad();
    MetaT1V2D_Actividad();
    MetaT2V2D_Actividad();
    MetaT3V2D_Actividad();
    MetaT4V2D_Actividad();

    let metatrimestral1V2A = parseFloat($("#metatrimestral1V1A_actividad").val());
    let metatrimestral2V2A = parseFloat($("#metatrimestral1V2A_actividad").val());
    
    let formula = Func_CalcularMeta(metatrimestral1V2A, metatrimestral2V2A, "actividad");
    $("#metatrimestral1_actividad").val(Func_FormatoMoneda(formula, 2));
    $("#metatrimestral2V1A_actividad").trigger('change');
    $("#metatrimestral2V2A_actividad").trigger('change');
    $("#metatrimestral3V1A_actividad").trigger('change');
    $("#metatrimestral3V2A_actividad").trigger('change');
    $("#metatrimestral4V1A_actividad").trigger('change');
    $("#metatrimestral4V2A_actividad").trigger('change');
    $("#metatrimestral1_actividad").trigger('change');
}

function InicialDenominadorFijoTrimestral_Componente(){
    let valor = $("#metatrimestral1V2D_componente").val();
    if ($("#clicDenominador_componente").val() == 1){

        $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral2V2D_componente").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral3V2D_componente").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral4V2D_componente").val(Func_FormatoMoneda(valor,2));

        $("#metatrimestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral3V2A_componente").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral4V2A_componente").val(Func_FormatoMoneda(valor,2));
    }
    InicialTrimestral_Componente();
}

function InicialDenominadorFijoSemestral_Componente(){
    let valor = $("#metasemestral1V2D_componente").val();
    if ($("#clicDenominador_componente").val() == 1){

        $("#metasemestral1V2D_componente").val(Func_FormatoMoneda(valor,2));
        $("#metasemestral2V2D_componente").val(Func_FormatoMoneda(valor,2));

        $("#metasemestral1V2A_componente").val(Func_FormatoMoneda(valor,2));
        $("#metasemestral2V2A_componente").val(Func_FormatoMoneda(valor,2));
    }

    InicialSemestral_Componente();
}

function InicialDenominadorFijoTrimestral_Actividad(){
    let valor = $("#metatrimestral1V2D_actividad").val();
    if ($("#clicDenominador_actividad").val() == 1){

        $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral2V2D_actividad").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral3V2D_actividad").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral4V2D_actividad").val(Func_FormatoMoneda(valor,2));

        $("#metatrimestral1V2A_actividad").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral2V2A_actividad").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral3V2A_actividad").val(Func_FormatoMoneda(valor,2));
        $("#metatrimestral4V2A_actividad").val(Func_FormatoMoneda(valor,2));
    }

    InicialTrimestral_Actividad();
}
