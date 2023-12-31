function ResponseGetMirComponentes(response) {
    if (!response.error) {
        info_componentes = response.data;
        if(response.data != null && response.data.length > 0) {
            var componente = response.data[index_componente];
            setComponente(componente);
        }
        GetMirActividades();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseGetMirActividades(response) {
    if (!response.error) {
        if(response.data != null && response.data.length > 0)
        {
            info_actividades = response.data.reduce((acumulador, item) => {
                const idComponente = item.idComponente;
                if (!acumulador[idComponente]) {
                    acumulador[idComponente] = {
                        componente: idComponente,
                        items: []
                    };
                }
                acumulador[idComponente].items.push(item);
                return acumulador;
            }, {});
            
            let id_componente = $("#id_componente").val();
            if(id_componente && id_componente.length > 0)
            {
                var actividad = info_actividades[id_componente]['items'][index_actividad];
                setActividad(actividad);
            }
        }
        else
            info_actividades = [];
        $(".contador-letras").trigger("keyup");
        $(".money").trigger("change").trigger("blur");
        $("#lbl-errores").hide();

        swal.close();
        $("#Modal").modal("show");

        var mir = getSelectedPrograma();
        if(mir.StatusId == 2) {
            $("#BtnEnviar").hide();
            if(tu == 1){
                $("#BtnRegistrar").show();
                $("#BtnRechazar").show();
                $(".modal select, .modal input, .modal textarea").removeAttr("readonly");
            }
            else{
                $("#BtnRegistrar").hide();
                $("#BtnRechazar").hide();
                $("#BtnGuardar").hide();
                $(".Modal select, .modal input, .modal textarea").attr("readonly","");
            }
        }
        else if (mir.StatusId == 1) {
            if(tu != 1)     //enlace pbr
                $("#BtnEnviar").show();
            else{
                $("#BtnEnviar").hide();
                $("#BtnRegistrar").hide();
                $("#BtnRechazar").hide();
            }
        }
        else {

            //ya está revisada, ocultar todo
            $("#BtnEnviar").hide();
            $("#BtnRegistrar").hide();
            $("#BtnRechazar").hide();
            $("#BtnGuardar").hide();
        }
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function setActividad(actividad) {
    $("#clicDenominador_actividad").val("1");
    $("#checkDenominadorFijo_actividad").trigger("click");

    $("#claseprogramatica_actividad").val(actividad['ClasProgramatica']);
    $("#idcomponente_actividad").val(actividad['idComponente']);
    $("#id_actividad").val(actividad['idActividad']);
    $("#nombre_actividad").val(actividad['Actividad']);
    $("#claveindicador_actividad").val(actividad['ClaveIndicador']);
    $("#nombreindicar_actividad").val(actividad['Indicador']);

    $("#descripcionformula_actividad").val(actividad['Formula']);
    $("#variable1_actividad").val(actividad['V1']);
    $("#variable2_actividad").val(actividad['V2']);
    $("#variable3_actividad").val(actividad['FormulaV1V2']);

    $("#select_unidadmedida_actividad").selectpicker("val", actividad['UnidadMedida']);
    if (actividad['UnidadMedida'] == "ABSOLUTO"){
        $("#d-descripcionunidadmedida_actividad").removeClass("d-none");
        $("#descripcionunidadmedida_actividad").val(actividad['DescripAbsoluto']);
    }else{
        $("#d-descripcionunidadmedida_actividad").addClass("d-none");
        $("#descripcionunidadmedida_actividad").val("");
    }

    $("#selectfrecuencia_actividad").selectpicker("val", actividad['Frecuencia']);
    if (actividad['Frecuencia'] == "SEMESTRAL"){
        $(".d-trimestral-actividad").addClass("d-none");
        $(".d-metasemestral-actividad").removeClass("d-none");
    }else if (actividad['Frecuencia'] == "TRIMESTRAL"){
        $(".d-metasemestral-actividad").addClass("d-none");
        $(".d-trimestral-actividad").removeClass("d-none");
    }

    $("#metaanual_actividad").val(actividad['MetaAnual']);
    $("#lineabase_actividad1").val(actividad['LineaBase']);
    $("#ejecerciciofisca_actividad").selectpicker("val", "2021");

    $("#variableV1_actividad").val(actividad['ValorNumerador']);
    $("#variableV2_actividad").val(actividad['ValorDenominador']);

    // Trimestral
    $("#metatrimestral1_actividad").val(actividad['MetaTrimestre1']);
    $("#metatrimestral2_actividad").val(actividad['MetaTrimestre2']);
    $("#metatrimestral3_actividad").val(actividad['MetaTrimestre3']);
    $("#metatrimestral4_actividad").val(actividad['MetaTrimestre4']);
    $("#metatrimestral1V1D_actividad").val(actividad['Trimestre1V1']);
    $("#metatrimestral1V1A_actividad").val(actividad['']);
    $("#metatrimestral1V2D_actividad").val(actividad['Trimestre1V2']);
    $("#metatrimestral1V2A_actividad").val(actividad['']);

    $("#metatrimestral2V1D_actividad").val(actividad['Trimestre2V1']);
    $("#metatrimestral2V1A_actividad").val(actividad['']);
    $("#metatrimestral2V2D_actividad").val(actividad['Trimestre2V2']);
    $("#metatrimestral2V2A_actividad").val(actividad['']);

    $("#metatrimestral3V1D_actividad").val(actividad['Trimestre3V1']);
    $("#metatrimestral3V1A_actividad").val(actividad['']);
    $("#metatrimestral3V2D_actividad").val(actividad['Trimestre3V2']);
    $("#metatrimestral3V2A_actividad").val(actividad['']);

    $("#metatrimestral4V1D_actividad").val(actividad['Trimestre4V1']);
    $("#metatrimestral4V1A_actividad").val(actividad['']);
    $("#metatrimestral4V2D_actividad").val(actividad['Trimestre4V2']);
    $("#metatrimestral4V2A_actividad").val(actividad['']);

    // Semestral
    $("#metasemestral1_actividad").val(actividad['MetaSemestre1']);
    $("#metasemestral2_actividad").val(actividad['MetaSemestre2']);
    $("#metasemestral1V1D_actividad").val(actividad['Semestre1V1']);
    $("#metasemestral1V1A_actividad").val(actividad['']);
    $("#metasemestral2V1D_actividad").val(actividad['Semestre2V1']);
    $("#metasemestral2V1A_actividad").val(actividad['']);
    $("#metasemestral1V2D_actividad").val(actividad['Semestre1V2']);
    $("#metasemestral1V2A_actividad").val(actividad['']);
    $("#metasemestral2V2D_actividad").val(actividad['Semestre2V2']);
    $("#metasemestral2V2A_actividad").val(actividad['']);

    $("#mediosverificacion_actividad").val(actividad['MediosVerificacion']);
    $("#fuentesinformacion_actividad").val(actividad['FuenteInformacion']);
    $("#supuestos_actividad").val(actividad['Supuestos']);

    $(`input[name=claridad_actividad][value="${actividad['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=relevancia_actividad][value="${actividad['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=economia_actividad][value="${actividad['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=monitoreable_actividad][value="${actividad['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=adecuado_actividad][value="${actividad['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=aportemarginal_actividad][value="${actividad['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);

    $("#select_sentidoindicador_actividad").selectpicker("val", actividad['SentidoIndicador']);
    $("#select_tipoindicador_actividad").selectpicker("val", actividad['TipoIndicador']);
    $("#select_dimensionindicador_actividad").selectpicker("val", actividad['DimensionIndicador']);

    var unidadResponsable = actividad['idUA'];
    if(unidadResponsable == null || unidadResponsable == "")
        $("#select_unidadresponsablereportar_actividad").selectpicker("val", $("#select_uaresponsable").val());
    else
        $("#select_unidadresponsablereportar_actividad").selectpicker("val",unidadResponsable);

    $("#descripcionindicador_actividad").val(actividad['DescripcionIndicador']);
    $("#descripcionnumerador_actividad").val(actividad['DescripcionNumerador']);
    $("#descripciondenominador_actividad").val(actividad['DescripcionDenominador']);

    var fijo = actividad.DenominadorFijo;
    $(`#checkDenominadorFijo_actividad`).attr("class","denominadorfijo ms-2");

    if(fijo == "1"){
        $(`#checkDenominadorFijo_actividad`).removeClass("DenominadorFijoInactivo");
        $(`#checkDenominadorFijo_actividad`).addClass("DenominadorFijoActivo");
    }
    else{
        $(`#checkDenominadorFijo_actividad`).addClass("DenominadorFijoInactivo");
        $(`checkDenominadorFijo_actividad`).removeClass("DenominadorFijoActivo");
    }

    $(`#clicDenominador_actividad`).val(fijo);

    if (actividad['Frecuencia'] == "SEMESTRAL"){
    }else if (actividad['Frecuencia'] == "TRIMESTRAL"){
        console.log("InicialTrimestral_Actividad")
        InicialTrimestral_Actividad();
    }
}
//cambiar de componente
function OnClic_TabsComponentes(){
    $(".tabs-select-componente").on("click", function(){
        var tipo = $(this).data("tipo");
        let index_actual_superior = index_componente;
        let index_actual = index_componente;
        let index_nuevo = null;
        
        if (tipo == "-1"){
            index_nuevo = index_actual - 1;
            
            if (index_nuevo <= (info_componentes.length-1) && index_nuevo >= 0 ){
                index_componente = index_nuevo;
            }else{
                index_nuevo = index_nuevo + 1;
            }
        }else{
            index_nuevo = index_actual + 1;

            if (index_nuevo <= (info_componentes.length-1)){
                index_componente = index_nuevo;
            }else{
                index_nuevo = index_nuevo - 1;
            }
        }
        
        if (index_actual_superior == index_nuevo){
        }else{
            index_actividad = 0;
            let componente = info_componentes[index_nuevo];
            let id_componente = componente['idComponente'];

            Func_Cargando();

            guardarMir();

            setComponente(componente);
            if(id_componente != null){
                var act_comp = info_actividades[id_componente];
                if(act_comp){
                    var actividad = act_comp['items'][index_actividad];
                    setActividad(actividad);
                }
            }

            $("#select_unidadresponsablereportar_componente").selectpicker("val", componente.idUA);
        }
    });
}

function setComponente(componente) {
    $("#claseprogramatica_componente").val(componente['ClasProgramatica']);
    $("#id_componente").val(componente['idComponente']);
    $("#nombre_componente").val(componente['Componente']);
    $("#id_componenteactividad").val(componente['idComponente']);
    $("#nombre_componenteactividad").val(componente['Componente']);
    $("#claveindicador_componente").val(componente['ClaveIndicador']);
    $("#nombreindicar_componente").val(componente['Indicador']);

    $("#descripcionformula_componente").val(componente['Formula']);
    $("#variable1_componente").val(componente['V1']);
    $("#variable2_componente").val(componente['V2']);
    $("#variable3_componente").val(componente['FormulaV1V2']);
    
    $("#select_unidadmedida_componente").selectpicker("val", componente['UnidadMedida']);
    if (componente['UnidadMedida'] == "ABSOLUTO"){
        $("#d-descripcionunidadmedida_componente").removeClass("d-none");
        $("#descripcionunidadmedida_componente").val(componente['DescripAbsoluto']);
    }else{
        $("#d-descripcionunidadmedida_componente").addClass("d-none");
        $("#descripcionunidadmedida_componente").val("");
    }

    $("#selectfrecuencia_componente").selectpicker("val", componente['Frecuencia']);
    if (componente['Frecuencia'] == "SEMESTRAL"){
        $(".d-trimestral-componente").addClass("d-none");
        $(".d-metasemestral-componente").removeClass("d-none");
    }else if (componente['Frecuencia'] == "TRIMESTRAL"){
        $(".d-metasemestral-componente").addClass("d-none");
        $(".d-trimestral-componente").removeClass("d-none");
    }

    $("#metaanual_componente").val(componente['MetaAnual']);
    $("#lineabase_componente1").val(componente['LineaBase']);
    $("#lineabaseV1_componente").val(componente['LineaBaseV1']);
    $("#lineabaseV2_componente").val(componente['LineaBaseV2']);
    $("#ejecerciciofisca_componente").selectpicker("val", "2021");

    $("#variableV1_componente").val(componente['ValorNumerador']);
    $("#variableV2_componente").val(componente['ValorDenominador']);
    
    // Trimestral
    $("#metatrimestral1_componente").val(componente['MetaTrimestre1']);
    $("#metatrimestral2_componente").val(componente['MetaTrimestre2']);
    $("#metatrimestral3_componente").val(componente['MetaTrimestre3']);
    $("#metatrimestral4_componente").val(componente['MetaTrimestre4']);
    $("#metatrimestral1V1D_componente").val(componente['Trimestre1V1']);
    $("#metatrimestral1V1A_componente").val(componente['']);
    $("#metatrimestral1V2D_componente").val(componente['Trimestre1V2']);
    $("#metatrimestral1V2A_componente").val(componente['']);

    $("#metatrimestral2V1D_componente").val(componente['Trimestre2V1']);
    $("#metatrimestral2V1A_componente").val(componente['']);
    $("#metatrimestral2V2D_componente").val(componente['Trimestre2V2']);
    $("#metatrimestral2V2A_componente").val(componente['']);

    $("#metatrimestral3V1D_componente").val(componente['Trimestre3V1']);
    $("#metatrimestral3V1A_componente").val(componente['']);
    $("#metatrimestral3V2D_componente").val(componente['Trimestre3V2']);
    $("#metatrimestral3V2A_componente").val(componente['']);

    $("#metatrimestral4V1D_componente").val(componente['Trimestre4V1']);
    $("#metatrimestral4V1A_componente").val(componente['']);
    $("#metatrimestral4V2D_componente").val(componente['Trimestre4V2']);
    $("#metatrimestral4V2A_componente").val(componente['']);

    // Semestral
    $("#metasemestral1_componente").val(componente['MetaSemestre1']);
    $("#metasemestral2_componente").val(componente['MetaSemestre2']);
    $("#metasemestral1V1D_componente").val(componente['Semestre1V1']);
    $("#metasemestral1V1A_componente").val(componente['']);
    $("#metasemestral2V1D_componente").val(componente['Semestre2V1']);
    $("#metasemestral2V1A_componente").val(componente['']);
    $("#metasemestral1V2D_componente").val(componente['Semestre1V2']);
    $("#metasemestral1V2A_componente").val(componente['']);
    $("#metasemestral2V2D_componente").val(componente['Semestre2V2']);
    $("#metasemestral2V2A_componente").val(componente['']);
    
    $("#mediosverificacion_componente").val(componente['MediosVerificacion']);
    $("#fuentesinformacion_componente").val(componente['FuenteInformacion']);
    $("#supuestos_componente").val(componente['Supuestos']);

    $(`input[name=claridad_componente][value="${componente['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=relevancia_componente][value="${componente['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=economia_componente][value="${componente['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=monitoreable_componente][value="${componente['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=adecuado_componente][value="${componente['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
    $(`input[name=aportemarginal_componente][value="${componente['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);

    $("#select_sentidoindicador_componente").selectpicker("val", componente['SentidoIndicador']);
    $("#select_tipoindicador_componente").selectpicker("val", componente['TipoIndicador']);
    $("#select_dimensionindicador_componente").selectpicker("val", componente['DimensionIndicador']);

    if(componente.UnidadResponsable == null || componente.UnidadResponsable == "")
        $("#select_unidadresponsablereportar_componente")
            .selectpicker("val", componente.idUA);
    else
        $("#select_unidadresponsablereportar_componente")
            .selectpicker("val", componente.UnidadResponsable);

    $("#descripcionindicador_componente").val(componente['DescripcionIndicador']);
    $("#descripcionnumerador_componente").val(componente['DescripcionNumerador']);
    $("#descripciondenominador_componente").val(componente['DescripcionDenominador']);

    var fijo = componente.DenominadorFijo;
    $(`#clicDenominador_componente`).val(fijo);
    $(`#checkDenominadorFijo_componente`).attr("class","denominadorfijo ms-2");

    if(fijo == "1"){
        $(`#checkDenominadorFijo_componente`).removeClass("DenominadorFijoInactivo");
        $(`#checkDenominadorFijo_componente`).addClass("DenominadorFijoActivo");
    }
    else{
        $(`#checkDenominadorFijo_componente`).addClass("DenominadorFijoInactivo");
        $(`checkDenominadorFijo_componente`).removeClass("DenominadorFijoActivo");
    }

    $(".money").trigger("change").trigger("blur");
}

function OnClic_TabsActividades(){
    $(".tabs-select-actividad").on("click", function(){
        var tipo = $(this).data("tipo");
        let index_actual_superior = index_actividad;
        let index_actual = index_actividad;
        let index_nuevo = null;
        let id_componente = $("#id_componente").val();
        
        if (tipo == "-1"){
            index_nuevo = index_actual - 1;
            
            if (index_nuevo <= (info_actividades[id_componente]['items'].length-1) && index_nuevo >= 0 ){
                index_actividad = index_nuevo;
            }else{
                index_nuevo = index_nuevo + 1;
            }
        }else{
            index_nuevo = index_actual + 1;

            if (index_nuevo <= (info_actividades[id_componente]['items'].length-1)){
                index_actividad = index_nuevo;
            }else{
                index_nuevo = index_nuevo - 1;
            }
        }

        if (index_actual_superior == index_nuevo){
        }else{
            Func_Cargando();
            var actividad = info_actividades[id_componente]['items'][index_actividad];
            setActividad(actividad);
            swal.close();
        }
    });
}

function ResponseGetMirCaratula(response) {
    if (!response.error) {
        $(".tab-modal-caratula").removeClass("active");
        $(".tab-pane").removeClass("active");
        $(".tab-pane").removeClass("show");
        $("#tab-caratula").addClass("active");
        $("#nav-caratula").addClass("active");
        $("#nav-caratula").addClass("show");
        $("#finuno").removeClass("d-none");
        $("#findos").addClass("d-none");
        $("#propositouno").removeClass("d-none");
        $("#propositodos").addClass("d-none");
        $("#componentesuno").removeClass("d-none");
        $("#componentesdos").addClass("d-none");
        $("#actividadesuno").removeClass("d-none");
        $("#actividadesdos").addClass("d-none");

        $("#consecutivo_caratula").val(response.data['Consecutivo']);
        $("#conac_caratula").val(response.data['CONAC']);
        $("#select_entepublido").selectpicker("val", response.data['idSecretaria']);
        $("#nombre_pp").val(`[${response.data['Consecutivo']}] ${response.data['DescripcionPrograma']}`);
        $("#clave_programatica").val(`${response.data['CONAC']}${response.data['Consecutivo']}`);
        $("#ejercicio_fiscal").val(response.data['EjercicioFiscal']);
        $("#select_ejeped").selectpicker("val", response.data['idEje']);
        
        FiltrarTemaPED($("#select_ejeped").val());
        $("#select_temaped").selectpicker("val", response.data['idTema']);
        
        FiltrarObjetivos($("#select_ejeped").val(), $("#select_temaped").val());
        $("#select_objetivo").selectpicker("val", response.data['idObjetivo']);

        $("#programa_sectorial").val(response.data['ProgramaSectorial']);
        $("#select_tipobeneficiario").selectpicker("val", response.data['idBeneficiario']);

        FiltrarEstrategias(response.data['idEje'], response.data['idTema'], response.data['idObjetivo']);

        FiltrarLineasAccion(
            response.data['idEje'], 
            response.data['idTema'],
            response.data['idObjetivo'],
            response.data['idEstrategia']);

        FiltrarBeneficiarios(response.data['idBeneficiario']);

        FiltrarUnidadesAdministrativas(response.data['idSecretaria']);

        $("#select_uaresponsable").selectpicker("val", response.data['idUA']);

        $("#select_estrategia").selectpicker("val", response.data['idEstrategia']);
        $("#select_lineaaccion1").selectpicker("val", response.data['idLineaAccion']);
        $("#select_lineaaccion2").selectpicker("val", response.data['idLineaAccion2']);
        $("#select_descripcionampliabeneficiario1").selectpicker("val", response.data['idCatBeneficiario']);
        $("#select_descripcionampliabeneficiario2").selectpicker("val", response.data['idCatBeneficiario2']);

        if(tu != 1)
        {
            //enlace pbr
            if(response.data.StatusId != 1) {
                //ya fue enviada a revisión
                $("#BtnGuardar").attr("disabled");
            }
        }
        else {
            if(response.data.StatusId == 1) {
                //ya fue enviada a revisión
                $("#BtnGuardar").attr("disabled");
            }
        }

        GetMirFin();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function FiltrarUnidadesAdministrativas(idSecretaria) {
    $("#select_uaresponsable").selectpicker("destroy");
    $("#select_unidadresponsablereportar").selectpicker("destroy");
    $("#select_unidadresponsablereportar_fin").selectpicker("destroy");
    $("#select_unidadresponsablereportar_proposito").selectpicker("destroy");
    $("#select_unidadresponsablereportar_componente").selectpicker("destroy");
    $("#select_unidadresponsablereportar_actividad").selectpicker("destroy");
    $("#select_uaresponsable").children().remove();
    $("#select_unidadresponsablereportar").children().remove();
    $("#select_unidadresponsablereportar_fin").children().remove();
    $("#select_unidadresponsablereportar_proposito").children().remove();
    $("#select_unidadresponsablereportar_componente").children().remove();
    $("#select_unidadresponsablereportar_actividad").children().remove();

    for (let i = 0; i < info_unidadadministrativa.length; i++) {
        const unidadadministrativa = info_unidadadministrativa[i];
        
        if (unidadadministrativa['idSecretaria'] == idSecretaria){
            $('#select_uaresponsable').append($('<option>', {
                value: unidadadministrativa.idUnidad,
                text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
            }));
            $('#select_unidadresponsablereportar').append($('<option>', {
                value: unidadadministrativa.idUnidad,
                text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
            }));
            $('#select_unidadresponsablereportar_fin').append($('<option>', {
                value: unidadadministrativa.idUnidad,
                text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
            }));
            $('#select_unidadresponsablereportar_proposito').append($('<option>', {
                value: unidadadministrativa.idUnidad,
                text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
            }));
            $('#select_unidadresponsablereportar_componente').append($('<option>', {
                value: unidadadministrativa.idUnidad,
                text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
            }));
            $('#select_unidadresponsablereportar_actividad').append($('<option>', {
                value: unidadadministrativa.idUnidad,
                text: ("[" + unidadadministrativa.idUnidad + "] " + unidadadministrativa.Descripcion)
            }));
        }
    }

    $("#select_uaresponsable").selectpicker();
    $("#select_unidadresponsablereportar").selectpicker();
    $("#select_unidadresponsablereportar_fin").selectpicker();
    $("#select_unidadresponsablereportar_proposito").selectpicker();
    $("#select_unidadresponsablereportar_componente").selectpicker();
    $("#select_unidadresponsablereportar_actividad").selectpicker();
}

function FiltrarTemaPED(idEje) {
    $('#select_temaped').selectpicker("destroy");
    $('#select_temaped').empty();

    for (var i = 0; i < info_temas.length; i++) {
        var tema = info_temas[i];
        if(tema.IdEje == idEje) {
            $('#select_temaped').append($('<option>', {
                value: tema.IdTema,
                text: ("[" + tema.IdTema + "] " + tema.Descripcion)
            }));
        }
    }
    $('#select_temaped').selectpicker();

    FiltrarObjetivos("","");
}

function FiltrarObjetivos(idEje,idTema) {
    $('#select_objetivo').selectpicker("destroy");
    $('#select_objetivo').empty();

    for (var i = 0; i < info_objetivos?.length; i++) {
        var obj = info_objetivos[i];

        if(obj.IdEje == idEje && obj.IdTema == idTema) {
            $('#select_objetivo').append($('<option>', {
                value: obj.IdObjetivo,
                text: ("[" + obj.IdObjetivo + "] " + obj.Descripcion)
            }));
        }
    }
    $('#select_objetivo').selectpicker();

    FiltrarEstrategias("","","");
}

function FiltrarEstrategias(idEje, idTema, idObjetivo){
    $('#select_estrategia').selectpicker("destroy");
    $('#select_estrategia').children().remove();
    for (let i = 0; i < info_estrategias?.length; i++) {
        const estrategias = info_estrategias[i];
        
        if (estrategias['IdEje'] == idEje 
            && estrategias['IdTema'] == idTema 
            && estrategias['IdObjetivo'] == idObjetivo) {
            $('#select_estrategia').append($('<option>', {
                value: estrategias.IdEstrategias,
                text: ("[" + estrategias.IdEstrategias + "] " + estrategias.Descripcion)
            }));
        }
    }
    $('#select_estrategia').selectpicker();

    FiltrarLineasAccion("","","","");
}

function FiltrarLineasAccion(idEje,idTema,idObjetivo,idEstrategia) {
    $('#select_lineaaccion1').selectpicker("destroy");
    $('#select_lineaaccion2').selectpicker("destroy");
    $('#select_lineaaccion1').children().remove();
    $('#select_lineaaccion2').children().remove();
    for (let j = 0; j < info_lineasaccion?.length; j++) {
        const lineaccion = info_lineasaccion[j];

        if (lineaccion['IdEje'] == idEje 
            && lineaccion['IdTema'] == idTema 
            && lineaccion['IdObjetivo'] == idObjetivo 
            && lineaccion['IdEstrategia'] == idEstrategia) {
            $('#select_lineaaccion1').append($('<option>', {
                value: lineaccion.IdLineaAccion,
                text: ("[" + lineaccion.IdLineaAccion + "] " + lineaccion.Descripcion)
            }));
            $('#select_lineaaccion2').append($('<option>', {
                value: lineaccion.IdLineaAccion,
                text: ("[" + lineaccion.IdLineaAccion + "] " + lineaccion.Descripcion)
            }));
        }
    }
    $('#select_lineaaccion1').selectpicker();
    $('#select_lineaaccion2').selectpicker();
}


function FiltrarBeneficiarios(idBeneficiario) {
    $('#select_descripcionampliabeneficiario1').selectpicker("destroy");
    $('#select_descripcionampliabeneficiario2').selectpicker("destroy");
    $('#select_descripcionampliabeneficiario1').children().remove();
    $('#select_descripcionampliabeneficiario2').children().remove();
    for (let k = 0; k < info_beneficiarios.length; k++) {
        const beneficiario = info_beneficiarios[k];
        
        if (beneficiario['idBeneficiario'] == idBeneficiario ){
            $('#select_descripcionampliabeneficiario1').append($('<option>', {
                value: beneficiario.idCatBeneficiario,
                text: ("[" + beneficiario.idCatBeneficiario + "] " + beneficiario.Poblacion)
            }));
            $('#select_descripcionampliabeneficiario2').append($('<option>', {
                value: beneficiario.idCatBeneficiario,
                text: ("[" + beneficiario.idCatBeneficiario + "] " + beneficiario.Poblacion)
            }));
        }
    }
    $('#select_descripcionampliabeneficiario1').selectpicker();
    $('#select_descripcionampliabeneficiario2').selectpicker();
}

function ResponseGetMirProposito(response) {
    if (!response.error) {
        if(response.data != null) {
            $("#claseprogramatica_proposito").val(response.data['ClasProgramatica']);
            $("#proposito_proposito").val(response.data['Proposito']);
            $("#claveindicador_proposito").val(response.data['ClaveIndicador']);
            $("#nombreindicar_proposito").val(response.data['Indicador']);

            $("#descripcionformula_proposito").val(response.data['Formula']);
            $("#variable1_proposito").val(response.data['V1']);
            $("#variable2_proposito").val(response.data['V2']);
            $("#variable3_proposito").val(response.data['FormulaV1V2']);

            $("#select_unidadmedida_proposito").selectpicker("val", response.data['UnidadMedida']);
            if (response.data['UnidadMedida'] == "ABSOLUTO"){
                $("#d-descripcionunidadmedida_proposito").removeClass("d-none");
                $("#descripcionunidadmedida_proposito").val(response.data['DescripAbsoluto']);
            }else{
                $("#d-descripcionunidadmedida_proposito").addClass("d-none");
                $("#descripcionunidadmedida_proposito").val("");
            }

            $("#selectfrecuencia_proposito").selectpicker("val", response.data['Frecuencia']);
            $("#metaanual_proposito").val(response.data['MetaAnual']);
            $("#lineabase_proposito1").val(response.data['LineaBase']);
            $("#ejecerciciofisca_proposito").selectpicker("val", "2021");
            $("#variable1numerador_proposito").val(Func_FormatoMoneda(response.data['ValorNumerador'],2));
            $("#variable2numerador_proposito").val(Func_FormatoMoneda(response.data['ValorDenominador'],2));
            $("#lineabaseV1_proposito").val(response.data['LineaBaseV1']);
            $("#lineabaseV2_proposito").val(response.data['LineaBaseV2']);
            $("#mediosverificacion_proposito").val(response.data['MediosVerificacion']);
            $("#fuentesinformacion_proposito").val(response.data['FuenteInformacion']);
            $("#supuestos_proposito").val(response.data['Supuestos']);

            $(`input[name=claridad_proposito][value="${response.data['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=relevancia_proposito][value="${response.data['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=economia_proposito][value="${response.data['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=monitoreable_proposito][value="${response.data['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=adecuado_proposito][value="${response.data['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=aportemarginal_proposito][value="${response.data['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);


            $("#select_sentidoindicador_proposito").selectpicker("val", response.data['SentidoIndicador']);
            $("#select_tipoindicador_proposito").selectpicker("val", response.data['TipoIndicador']);
            $("#select_dimensionindicador_proposito").selectpicker("val", response.data['DimensionIndicador']);

            var unidadResponsable = response.data['UnidadResponsable'];
            if(unidadResponsable == null || unidadResponsable == "")
                $("#select_unidadresponsablereportar_proposito").selectpicker("val", $("#select_uaresponsable").val());
            else
                $("#select_unidadresponsablereportar_proposito").selectpicker("val",unidadResponsable);
            
            $("#descripcionindicador_proposito").val(response.data['DescripcionIndicador']);
            $("#descripcionnumerador_proposito").val(response.data['DescripcionNumerador']);
            $("#descripciondenominador_proposito").val(response.data['DescripcionDenominador']);
        }
        GetMirComponentes();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}

function ResponseGetMirFin(response) {
    if (!response.error) {
        if(response.data != null) {
            $("#fin_fin").val(response.data['Fin']);
            $("#claseprogramatica_fin").val(response.data['ClasProgramatica']);
            $("#claveindicador_fin").val(response.data['ClaveIndicador']);
            $("#nombreindicar_fin").val(response.data['Indicador']);

            $("#descripcionformula_fin").val(response.data['Formula']);
            $("#variable1_fin").val(response.data['V1']);
            $("#variable2_fin").val(response.data['V2']);
            $("#variable3_fin").val(response.data['FormulaV1V2']);
            
            $("#select_unidadmedida_fin").selectpicker("val", response.data['UnidadMedida']);
            if (response.data['UnidadMedida'] == "ABSOLUTO"){
                $("#d-descripcionunidadmedida_fin").removeClass("d-none");
                $("#descripcionunidadmedida_fin").val(response.data['DescripAbsoluto']);
            }else{
                $("#d-descripcionunidadmedida_fin").addClass("d-none");
                $("#descripcionunidadmedida_fin").val("");
            }        

            $("#selectfrecuencia_fin").selectpicker("val", response.data['Frecuencia']);
            $("#metaanual_fin").val(response.data['MetaAnual']);
            $("#lineabase_fin1").val(response.data['LineaBase']);
            $("#ejecerciciofisca_fin").selectpicker("val", "2021");
            $("#variable1numerador_fin").val(Func_FormatoMoneda(response.data['ValorNumerador'],2));
            $("#variable2numerador_fin").val(Func_FormatoMoneda(response.data['ValorDenominador'],2));
            $("#lineabaseV1_fin").val(response.data['LineaBaseV1']);
            $("#lineabaseV2_fin").val(response.data['LineaBaseV2']);
            $("#mediosverificacion_fin").val(response.data['MediosVerificacion']);
            $("#fuentesinformacion_fin").val(response.data['FuenteInformacion']);
            $("#supuestos_fin").val(response.data['Supuestos']);

            $(`input[name=claridad_fin][value="${response.data['Claridad'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=relevancia_fin][value="${response.data['Relevancia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=economia_fin][value="${response.data['Economia'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=monitoreable_fin][value="${response.data['Monitoreable'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=adecuado_fin][value="${response.data['Adecuado'] == "S" ? "S" : "N"}"]`).prop("checked",true);
            $(`input[name=aportemarginal_fin][value="${response.data['AporteMarginal'] == "S" ? "S" : "N"}"]`).prop("checked",true);


            $("#select_sentidoindicador_fin").selectpicker("val", response.data['SentidoIndicador']);
            $("#select_tipoindicador_fin").selectpicker("val", response.data['TipoIndicador']);
            $("#select_dimensionindicador_fin").selectpicker("val", response.data['DimensionIndicador']);

            var unidadResponsable = response.data['UnidadResponsable'];
            if(unidadResponsable == null || unidadResponsable == "")
                $("#select_unidadresponsablereportar_fin").selectpicker("val", $("#select_uaresponsable").val());
            else
                $("#select_unidadresponsablereportar_fin").selectpicker("val",unidadResponsable);

            $("#descripcionindicador_fin").val(response.data['DescripcionIndicador']);
            $("#descripcionnumerador_fin").val(response.data['DescripcionNumerador']);
            $("#descripciondenominador_fin").val(response.data['DescripcionDenominador']);
        }
        GetMirProposito();
    } else {
        swal.close();
        console.log(response.result)
        Func_Aviso("Anomalía detectada", "Ha ocurrido una anomalía al obtener la información del módulo, favor de intentarlo nuevamente.", "error");
    }
}