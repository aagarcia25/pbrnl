function Func_GetRequestCaratual() {
    var request_caratula = {
        consecutivo_caratula: $("#consecutivo_caratula").val(),
        conac_caratula: $("#conac_caratula").val(),
        select_entepublido: $("#select_entepublido").val(),
        select_uaresponsable: $("#select_uaresponsable").val(),
        nombre_pp: $("#nombre_pp").val(),
        clave_programatica: $("#clave_programatica").val(),
        ejercicio_fiscal: $("#ejercicio_fiscal").val(),
        select_ejeped: $("#select_ejeped").val(),
        select_temaped: $("#select_temaped").val(),
        select_objetivo: $("#select_objetivo").val(),
        select_estrategia: $("#select_estrategia").val(),
        select_lineaaccion1: $("#select_lineaaccion1").val(),
        select_lineaaccion2: $("#select_lineaaccion2").val(),
        programa_sectorial: $("#programa_sectorial").val(),
        select_tipobeneficiario: $("#select_tipobeneficiario").val(),
        select_descripcionampliabeneficiario1: $("#select_descripcionampliabeneficiario1").val(),
        select_descripcionampliabeneficiario2: $("#select_descripcionampliabeneficiario2").val()
    }

    return request_caratula;
}

function Func_GetRequestFin() {
    var request_fin = {
        fin_fin: $("#fin_fin").val(),
        claseprogramatica_fin: $("#claseprogramatica_fin").val(),
        claveindicador_fin: $("#claveindicador_fin").val(),
        nombreindicar_fin: $("#nombreindicar_fin").val(),
        descripcionformula_fin: $("#descripcionformula_fin").val(),
        variable1_fin: $("#variable1_fin").val(),
        variable2_fin: $("#variable2_fin").val(),
        variable3_fin: $("#variable3_fin").val(),
        select_unidadmedida_fin: $("#select_unidadmedida_fin").val(),
        descripcionunidadmedida_fin: $("#descripcionunidadmedida_fin").val(),
        selectfrecuencia_fin: $("#selectfrecuencia_fin").val(),
        metaanual_fin: $("#metaanual_fin").val(),
        ejecerciciofisca_fin: $("#ejecerciciofisca_fin").val(),
        lineabase_fin1: $("#lineabase_fin1").val(),
        variable1numerador_fin: $("#variable1numerador_fin").val(),
        variable2numerador_fin: $("#variable2numerador_fin").val(),
        lineabaseV1_fin: $("#lineabaseV1_fin").val(),
        lineabaseV2_fin: $("#lineabaseV2_fin").val(),
        mediosverificacion_fin: $("#mediosverificacion_fin").val(),
        fuentesinformacion_fin: $("#fuentesinformacion_fin").val(),
        supuestos_fin: $("#supuestos_fin").val(),
        select_sentidoindicador_fin: $("#select_sentidoindicador_fin").val(),
        select_tipoindicador_fin: $("#select_tipoindicador_fin").val(),
        select_dimensionindicador_fin: $("#select_dimensionindicador_fin").val(),
        claridad_fin: $('input[name=claridad_fin]:checked').val(),
        relevancia_fin: $('input[name=relevancia_fin]:checked').val(),
        economia_fin: $('input[name=economia_fin]:checked').val(),
        monitoreable_fin: $('input[name=monitoreable_fin]:checked').val(),
        adecuado_fin: $('input[name=adecuado_fin]:checked').val(),
        aportemarginal_fin: $('input[name=aportemarginal_fin]:checked').val(),
        select_unidadresponsablereportar_fin: $("#select_unidadresponsablereportar_fin").val(),
        descripcionindicador_fin: $("#descripcionindicador_fin").val(),
        descripcionnumerador_fin: $("#descripcionnumerador_fin").val(),
        descripciondenominador_fin: $("#descripciondenominador_fin").val()
    }

    return request_fin;
}

function Func_GetRequestProposito() {
    var request_proposito = {
        claseprogramatica_proposito: $("#claseprogramatica_proposito").val(),
        proposito_proposito:$("#proposito_proposito").val(),
        claveindicador_proposito: $("#claveindicador_proposito").val(),
        nombreindicar_proposito: $("#nombreindicar_proposito").val(),
        descripcionformula_proposito: $("#descripcionformula_proposito").val(),
        variable1_proposito: $("#variable1_proposito").val(),
        variable2_proposito: $("#variable2_proposito").val(),
        variable3_proposito: $("#variable3_proposito").val(),
        select_unidadmedida_proposito: $("#select_unidadmedida_proposito").val(),
        descripcionunidadmedida_proposito: $("#descripcionunidadmedida_proposito").val(),
        selectfrecuencia_proposito: $("#selectfrecuencia_proposito").val(),
        metaanual_proposito: $("#metaanual_proposito").val(),
        ejecerciciofisca_proposito: $("#ejecerciciofisca_proposito").val(),
        lineabase_proposito1: $("#lineabase_proposito1").val(),
        variable1numerador_proposito: $("#variable1numerador_proposito").val(),
        variable2numerador_proposito: $("#variable2numerador_proposito").val(),
        lineabaseV1_proposito: $("#lineabaseV1_proposito").val(),
        lineabaseV2_proposito: $("#lineabaseV2_proposito").val(),
        mediosverificacion_proposito: $("#mediosverificacion_proposito").val(),
        fuentesinformacion_proposito: $("#fuentesinformacion_proposito").val(),
        supuestos_proposito: $("#supuestos_proposito").val(),
        select_sentidoindicador_proposito: $("#select_sentidoindicador_proposito").val(),
        select_tipoindicador_proposito: $("#select_tipoindicador_proposito").val(),
        select_dimensionindicador_proposito: $("#select_dimensionindicador_proposito").val(),
        claridad_proposito: $('input[name=claridad_proposito]:checked').val(),
        relevancia_proposito: $('input[name=relevancia_proposito]:checked').val(),
        economia_proposito: $('input[name=economia_proposito]:checked').val(),
        monitoreable_proposito: $('input[name=monitoreable_proposito]:checked').val(),
        adecuado_proposito: $('input[name=adecuado_proposito]:checked').val(),
        aportemarginal_proposito: $('input[name=aportemarginal_proposito]:checked').val(),
        select_unidadresponsablereportar_proposito: $("#select_unidadresponsablereportar_proposito").val(),
        descripcionindicador_proposito: $("#descripcionindicador_proposito").val(),
        descripcionnumerador_proposito: $("#descripcionnumerador_proposito").val(),
        descripciondenominador_proposito: $("#descripciondenominador_proposito").val()
    }

    return request_proposito;
}

function Func_GetRequestComponente() {
    var request_componente = {
        claseprogramatica_componente: $("#claseprogramatica_componente").val(),
        id_componente: $("#id_componente").val(),
        nombre_componente: $("#nombre_componente").val(),
        nombre_componenteactividad: $("#nombre_componenteactividad").val(),
        claveindicador_componente: $("#claveindicador_componente").val(),
        nombreindicar_componente: $("#nombreindicar_componente").val(),
        descripcionformula_componente: $("#descripcionformula_componente").val(),
        variable1_componente: $("#variable1_componente").val(),
        variable2_componente: $("#variable2_componente").val(),
        variable3_componente: $("#variable3_componente").val(),
        select_unidadmedida_componente: $("#select_unidadmedida_componente").val(),
        descripcionunidadmedida_componente: $("#descripcionunidadmedida_componente").val(),
        ejecerciciofisca_componente: $("#ejecerciciofisca_componente").val(),
        lineabase_componente1: $("#lineabase_componente1").val(),
        lineabaseV1_componente: $("#lineabaseV1_componente").val(),
        lineabaseV2_componente: $("#lineabaseV2_componente").val(),
        metaanual_componente: $("#metaanual_componente").val(),
        selectfrecuencia_componente: $("#selectfrecuencia_componente").val(),
        metasemestral1_componente: $("#metasemestral1_componente").val(),
        metasemestral2_componente: $("#metasemestral2_componente").val(),
        metatrimestral1_componente: $("#metatrimestral1_componente").val(),
        metatrimestral2_componente: $("#metatrimestral2_componente").val(),
        metatrimestral3_componente: $("#metatrimestral3_componente").val(),
        metatrimestral4_componente: $("#metatrimestral4_componente").val(),
        variableV1_componente: $("#variableV1_componente").val(),
        metasemestral1V1D_componente: $("#metasemestral1V1D_componente").val(),
        metasemestral1V1A_componente: $("#metasemestral1V1A_componente").val(),
        metasemestral2V1D_componente: $("#metasemestral2V1D_componente").val(),
        metasemestral2V1A_componente: $("#metasemestral2V1A_componente").val(),
        metatrimestral1V1D_componente: $("#metatrimestral1V1D_componente").val(),
        metatrimestral1V1A_componente: $("#metatrimestral1V1A_componente").val(),
        metatrimestral2V1D_componente: $("#metatrimestral2V1D_componente").val(),
        metatrimestral2V1A_componente: $("#metatrimestral2V1A_componente").val(),
        metatrimestral3V1D_componente: $("#metatrimestral3V1D_componente").val(),
        metatrimestral3V1A_componente: $("#metatrimestral3V1A_componente").val(),
        metatrimestral4V1D_componente: $("#metatrimestral4V1D_componente").val(),
        metatrimestral4V1A_componente: $("#metatrimestral4V1A_componente").val(),
        variableV2_componente: $("#variableV2_componente").val(),
        metasemestral1V2D_componente: $("#metasemestral1V2D_componente").val(),
        metasemestral1V2A_componente: $("#metasemestral1V2A_componente").val(),
        metasemestral2V2D_componente: $("#metasemestral2V2D_componente").val(),
        metasemestral2V2A_componente: $("#metasemestral2V2A_componente").val(),
        metatrimestral1V2D_componente: $("#metatrimestral1V2D_componente").val(),
        metatrimestral1V2A_componente: $("#metatrimestral1V2A_componente").val(),
        metatrimestral2V2D_componente: $("#metatrimestral2V2D_componente").val(),
        metatrimestral2V2A_componente: $("#metatrimestral2V2A_componente").val(),
        metatrimestral3V2D_componente: $("#metatrimestral3V2D_componente").val(),
        metatrimestral3V2A_componente: $("#metatrimestral3V2A_componente").val(),
        metatrimestral4V2D_componente: $("#metatrimestral4V2D_componente").val(),
        metatrimestral4V2A_componente: $("#metatrimestral4V2A_componente").val(),
        mediosverificacion_componente: $("#mediosverificacion_componente").val(),
        fuentesinformacion_componente: $("#fuentesinformacion_componente").val(),
        supuestos_componente: $("#supuestos_componente").val(),
        select_sentidoindicador_componente: $("#select_sentidoindicador_componente").val(),
        select_tipoindicador_componente: $("#select_tipoindicador_componente").val(),
        select_dimensionindicador_componente: $("#select_dimensionindicador_componente").val(),
        claridad_componente: $('input[name=claridad_componente]:checked').val(),
        relevancia_componente: $('input[name=relevancia_componente]:checked').val(),
        economia_componente: $('input[name=economia_componente]:checked').val(),
        monitoreable_componente: $('input[name=monitoreable_componente]:checked').val(),
        adecuado_componente: $('input[name=adecuado_componente]:checked').val(),
        aportemarginal_componente: $('input[name=aportemarginal_componente]:checked').val(),
        select_unidadresponsablereportar_componente: $("#select_unidadresponsablereportar_componente").val(),
        descripcionindicador_componente: $("#descripcionindicador_componente").val(),
        descripcionnumerador_componente: $("#descripcionnumerador_componente").val(),
        descripciondenominador_componente: $("#descripciondenominador_componente").val()
    }

    return request_componente;
}

function Func_GetRequestActividad() {
    var request_actividad = {
        claseprogramatica_actividad : $("#claseprogramatica_actividad").val(),
        idcomponente_actividad : $("#idcomponente_actividad").val(),
        id_actividad: $("#id_actividad").val(),
        nombre_actividad: $("#nombre_actividad").val(),
        claveindicador_actividad: $("#claveindicador_actividad").val(),
        nombreindicar_actividad: $("#nombreindicar_actividad").val(),
        descripcionformula_actividad: $("#descripcionformula_actividad").val(),
        variable1_actividad: $("#variable1_actividad").val(),
        variable2_actividad: $("#variable2_actividad").val(),
        variable3_actividad: $("#variable3_actividad").val(),
        select_unidadmedida_actividad: $("#select_unidadmedida_actividad").val(),
        descripcionunidadmedida_actividad: $("#descripcionunidadmedida_actividad").val(),
        ejecerciciofisca_actividad: $("#ejecerciciofisca_actividad").val(),
        lineabase_actividad1: $("#lineabase_actividad1").val(),
        lineabaseV1_actividad: $("#lineabaseV1_actividad").val(),
        lineabaseV2_actividad: $("#lineabaseV2_actividad").val(),
        metaanual_actividad: $("#metaanual_actividad").val(),
        selectfrecuencia_actividad: $("#selectfrecuencia_actividad").val(),
        metasemestral1_actividad: ($("#metasemestral1_actividad").val() == null ? 0 : $("#metasemestral1_actividad").val()),
        metasemestral2_actividad: ($("#metasemestral2_actividad").val() == null ? 0 : $("#metasemestral2_actividad").val()),
        metatrimestral1_actividad: $("#metatrimestral1_actividad").val(),
        metatrimestral2_actividad: $("#metatrimestral2_actividad").val(),
        metatrimestral3_actividad: $("#metatrimestral3_actividad").val(),
        metatrimestral4_actividad: $("#metatrimestral4_actividad").val(),
        variableV1_actividad: $("#variableV1_actividad").val(),
        metasemestral1V1D_actividad: ($("#metasemestral1V1D_actividad").val() == null ? 0 : $("#metasemestral1V1D_actividad").val()),
        metasemestral1V1A_actividad: ($("#metasemestral1V1A_actividad").val() == null ? 0 : $("#metasemestral1V1A_actividad").val()),
        metasemestral2V1D_actividad: ($("#metasemestral2V1D_actividad").val() == null ? 0 : $("#metasemestral2V1D_actividad").val()),
        metasemestral2V1A_actividad: ($("#metasemestral2V1A_actividad").val() == null ? 0 : $("#metasemestral2V1A_actividad").val()),
        metatrimestral1V1D_actividad: $("#metatrimestral1V1D_actividad").val(),
        metatrimestral1V1A_actividad: $("#metatrimestral1V1A_actividad").val(),
        metatrimestral2V1D_actividad: $("#metatrimestral2V1D_actividad").val(),
        metatrimestral2V1A_actividad: $("#metatrimestral2V1A_actividad").val(),
        metatrimestral3V1D_actividad: $("#metatrimestral3V1D_actividad").val(),
        metatrimestral3V1A_actividad: $("#metatrimestral3V1A_actividad").val(),
        metatrimestral4V1D_actividad: $("#metatrimestral4V1D_actividad").val(),
        metatrimestral4V1A_actividad: $("#metatrimestral4V1A_actividad").val(),
        variableV2_actividad: $("#variableV2_actividad").val(),
        metasemestral1V2D_actividad: ($("#metasemestral1V2D_actividad").val() == null ? 0 : $("#metasemestral1V2D_actividad").val()),
        metasemestral1V2A_actividad: ($("#metasemestral1V2A_actividad").val() == null ? 0 : $("#metasemestral1V2A_actividad").val()),
        metasemestral2V2D_actividad: ($("#metasemestral2V2D_actividad").val() == null ? 0 : $("#metasemestral2V2D_actividad").val()),
        metasemestral2V2A_actividad: ($("#metasemestral2V2A_actividad").val() == null ? 0 : $("#metasemestral2V2A_actividad").val()),
        metatrimestral1V2D_actividad: $("#metatrimestral1V2D_actividad").val(),
        metatrimestral1V2A_actividad: $("#metatrimestral1V2A_actividad").val(),
        metatrimestral2V2D_actividad: $("#metatrimestral2V2D_actividad").val(),
        metatrimestral2V2A_actividad: $("#metatrimestral2V2A_actividad").val(),
        metatrimestral3V2D_actividad: $("#metatrimestral3V2D_actividad").val(),
        metatrimestral3V2A_actividad: $("#metatrimestral3V2A_actividad").val(),
        metatrimestral4V2D_actividad: $("#metatrimestral4V2D_actividad").val(),
        metatrimestral4V2A_actividad: $("#metatrimestral4V2A_actividad").val(),
        mediosverificacion_actividad: $("#mediosverificacion_actividad").val(),
        fuentesinformacion_actividad: $("#fuentesinformacion_actividad").val(),
        supuestos_actividad: $("#supuestos_actividad").val(),
        select_sentidoindicador_actividad: $("#select_sentidoindicador_actividad").val(),
        select_tipoindicador_actividad: $("#select_tipoindicador_actividad").val(),
        select_dimensionindicador_actividad: $("#select_dimensionindicador_actividad").val(),
        claridad_actividad: $('input[name=claridad_actividad]:checked').val(),
        relevancia_actividad: $('input[name=relevancia_actividad]:checked').val(),
        economia_actividad: $('input[name=economia_actividad]:checked').val(),
        monitoreable_actividad: $('input[name=monitoreable_actividad]:checked').val(),
        adecuado_actividad: $('input[name=adecuado_actividad]:checked').val(),
        aportemarginal_actividad: $('input[name=aportemarginal_actividad]:checked').val(),
        select_unidadresponsablereportar_actividad: $("#select_unidadresponsablereportar_actividad").val(),
        descripcionindicador_actividad: $("#descripcionindicador_actividad").val(),
        descripcionnumerador_actividad: $("#descripcionnumerador_actividad").val(),
        descripciondenominador_actividad: $("#descripciondenominador_actividad").val()
    }

    return request_actividad;
}