@php
   $view = "Revisar MIR";
   $img = "icono_revisar_MIR.svg";
@endphp

 @include('includes._partialHeader')

<link rel="stylesheet" type="text/css" href="/css/EstilosPbR.css" />

<style>
    .input-background-white {
        background-color: white;
    }
</style>

<div class="Margin-Top">
    @include('includes._partialBreadcrumbCatalogos')
    
    <section class="container section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-transparent border border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="select_Secretaria" class="form-label">Id Secretaría</label>
                                <select id="select_Secretaria" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                    <option value="0">-</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="select_UnidadAdministrativa" class="form-label">Id Unidad Administrativa</label>
                                <select id="select_UnidadAdministrativa" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                    <option value="0">-</option>
                                </select>
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        <div class="d-flex flex-row-reverse bd-highlight mt-4">
                            <div class="p-2 bd-highlight">
                                <button type="button" id="BtnEditarMIR" class="btn button-crud"><i class="bi bi-trash"></i> Editar</button>
                            </div>
                            <div class="p-2 bd-highlight">
                                <button type="button" id="BtnCargarExcel" class="btn button-crud"><i class="ri-edit-2-fill"></i>Cargar</button>
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        <div class="table-response mt-1">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="10%">CONAC</th>
                                        <th scope="col" width="10%">Consecutivo</th>
                                        <th scope="col" width="35%">Descripción programa</th>
                                        <th scope="col" width="15%">Tipo programa</th>
                                        <th scope="col" width="20%">Tipo de beneficiario</th>
                                        <th scope="col" width="10%">Ejercicio</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
    
            </div>
        </div>
    </section>

    <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl modal-center">
            <div class="modal-content">
                <form id="form_modal" autocomplete="off" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_accion"></span> MIR</h5>
                    </div>
                    <div class="modal-body">
                        <nav>
                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="tab-caratula" data-bs-toggle="tab" data-bs-target="#nav-caratula" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Carátula</button>
                                <button class="nav-link" id="tab-fin" data-bs-toggle="tab" data-bs-target="#nav-fin" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Fin</button>
                                <button class="nav-link" id="tab-proposito" data-bs-toggle="tab" data-bs-target="#nav-proposito" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Propósito</button>
                                <button class="nav-link" id="tab-componentes" data-bs-toggle="tab" data-bs-target="#nav-componentes" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Componentes</button>
                                <button class="nav-link" id="tab-actividades" data-bs-toggle="tab" data-bs-target="#nav-actividades" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Actividades</button>
                                <button class="nav-link" id="tab-auditoriacarga" data-bs-toggle="tab" data-bs-target="#nav-auditoriacarga" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Autoría de carga</button>
                                <button class="nav-link" id="tab-auditoriaformulas" data-bs-toggle="tab" data-bs-target="#nav-auditoriaformulas" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Autoría de fórmulas</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-caratula" role="tabpanel" aria-labelledby="tab-caratula" tabindex="0">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="select_entepublido" class="form-label">Ente público</label>
                                        <select id="select_entepublido" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="select_uaresponsable" class="form-label">Unidad administrativa responsable</label>
                                        <select id="select_uaresponsable" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="nombre_pp" class="form-label">Nombre del PP</label>
                                        <input type="text" class="form-control" id="nombre_pp">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="clave_programatica" class="form-label">Clave programática</label>
                                        <input type="text" class="form-control" id="clave_programatica">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="ejercicio_fiscal" class="form-label">Ejercicio fiscal</label>
                                        <input type="text" class="form-control" id="ejercicio_fiscal">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="eje_ped" class="form-label">Eje del PED</label>
                                        <input type="text" class="form-control" id="eje_ped">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="tema_ped" class="form-label">Tema del PED</label>
                                        <input type="text" class="form-control" id="tema_ped">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_objetivo" class="form-label">Id objetivo</label>
                                        <select id="select_objetivo" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_estrategia" class="form-label">Id estrategia</label>
                                        <select id="select_estrategia" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_lineaaccion1" class="form-label">Id línea acción 1</label>
                                        <select id="select_lineaaccion1" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_lineaaccion2" class="form-label">Id línea acción 2</label>
                                        <select id="select_lineaaccion2" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="programa_sectorial" class="form-label">Programa sectorial, regional, especial o institucional</label>
                                        <input type="text" class="form-control" id="programa_sectorial">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_tipobeneficiario" class="form-label">Tipo de beneficiario</label>
                                        <select id="select_tipobeneficiario" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_descripcionampliabeneficiario1" class="form-label">Descripción amplia del beneficiario 1 (población o área de enfoque objetivo)</label>
                                        <select id="select_descripcionampliabeneficiario1" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_descripcionampliabeneficiario2" class="form-label">Descripción amplia del beneficiario 2 (población o área de enfoque objetivo)</label>
                                        <select id="select_descripcionampliabeneficiario2" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-fin" role="tabpanel" aria-labelledby="tab-fin" tabindex="0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <div class="p-2 flex-grow-1">
                                                <img src="/img/icono izq activo.svg" class="tabs-internas" data-superior="fin" data-seccion="findos" data-actual="finuno" data-texto="1/2" width="30" height="30">
                                            </div>
                                            <div class="p-2">
                                                <b class="m-3 number-tabs-fin">1/2</b><img src="/img/icono der activo.svg" data-superior="fin" class="tabs-internas" data-seccion="finuno" data-actual="findos" data-texto="2/2" width="30" height="30">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="finuno" class="row">
                                    <div class="col-12 mb-3">
                                        <label for="fin_fin" class="form-label">Ente público</label>
                                        <textarea class="form-control input-bold" id="fin_fin" required maxlength="300" rows="3"></textarea>
                                    </div>
                                    <div class="col-2 mb-3">
                                        <label for="claveindicador_fin" class="form-label">Clave indicador</label>
                                        <input type="text" class="form-control" id="claveindicador_fin">
                                    </div>
                                    <div class="col-10 mb-3">
                                        <label for="nombreindicar_fin" class="form-label">Nombre del indicador</label>
                                        <input type="text" class="form-control" id="nombreindicar_fin">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="descripcionformula_fin" class="form-label">Descripción de la fórmula</label>
                                        <input type="text" class="form-control" id="descripcionformula_fin">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="variable1_fin" class="form-label">Variable 1 (V1)</label>
                                        <textarea class="form-control" id="variable1_fin" required maxlength="300" rows="3"></textarea>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="variable2_fin" class="form-label">Variable 2 (V2)</label>
                                        <textarea class="form-control" id="variable2_fin" required maxlength="300" rows="3"></textarea>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="variable3_fin" class="form-label">Variable 3 (V3)</label>
                                        <textarea class="form-control" id="variable3_fin" required maxlength="300" rows="3"></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="select_unidadmedida" class="form-label">Unidad de medida</label>
                                        <select id="select_unidadmedida" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="frecuencia_fin" class="form-label">Frecuencia</label>
                                        <input type="text" class="form-control" id="frecuencia_fin">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="metaanual_fin" class="form-label">Meta anual</label>
                                        <input type="text" class="form-control" id="metaanual_fin">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="lineabase_fin1" class="form-label">Línea base</label>
                                        <input type="text" class="form-control" id="lineabase_fin1">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="variable1numerador_fin" class="form-label">Variable 1 (Numerador)</label>
                                        <input type="text" class="form-control" id="variable1numerador_fin">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="variable2numerador_fin" class="form-label">Meta anual</label>
                                        <input type="text" class="form-control" id="variable2numerador_fin">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="lineabase_fin2" class="form-label">Línea base</label>
                                        <input type="text" class="form-control" id="lineabase_fin2">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="mediosverificacion_fin" class="form-label">Medios de Verificación</label>
                                        <input type="text" class="form-control" id="mediosverificacion_fin">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="fuentesinformacion_fin" class="form-label">Fuentes de Información</label>
                                        <input type="text" class="form-control" id="fuentesinformacion_fin">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="supuestos_fin" class="form-label">Supuestos</label>
                                        <input type="text" class="form-control" id="supuestos_fin">
                                    </div>
                                </div>
                                <div id="findos" class="row">
                                    <div class="col-4 mb-3">
                                        <label for="select_sentidoindicador" class="form-label">Sentido del indicador</label>
                                        <select id="select_sentidoindicador" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_tipoindicador" class="form-label">Tipo de indicador</label>
                                        <select id="select_tipoindicador" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_dimensionindicador" class="form-label">Dimensión del indicador</label>
                                        <select id="select_dimensionindicador" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="col-12 text-center">
                                        ANÁLSIS CREMAA
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_dimensionindicador" class="form-label">Claridad</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="claridad_fin" id="claridad_finSi">
                                            <label class="form-check-label" for="claridad_finSi">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="claridad_fin" id="claridad_finNo" checked>
                                            <label class="form-check-label" for="claridad_finNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_dimensionindicador" class="form-label">Relevancia</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="relevancia_fin" id="relevancia_finSi">
                                            <label class="form-check-label" for="relevancia_finSi">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="relevancia_fin" id="relevancia_finNo" checked>
                                            <label class="form-check-label" for="relevancia_finNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_dimensionindicador" class="form-label">Economía</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="economia_fin" id="economia_finSi">
                                            <label class="form-check-label" for="economia_finSi">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="economia_fin" id="economia_finNo" checked>
                                            <label class="form-check-label" for="economia_finNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_dimensionindicador" class="form-label">Monitoreable</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="monitoreable_fin" id="monitoreable_finSi">
                                            <label class="form-check-label" for="monitoreable_finSi">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="monitoreable_fin" id="monitoreable_finNo" checked>
                                            <label class="form-check-label" for="monitoreable_finNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_dimensionindicador" class="form-label">Adecuado</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="adecuado_fin" id="adecuado_finSi">
                                            <label class="form-check-label" for="adecuado_finSi">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="adecuado_fin" id="adecuado_finNo" checked>
                                            <label class="form-check-label" for="adecuado_finNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="select_dimensionindicador" class="form-label">Aporte marginal</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="aportemarginal_fin" id="aportemarginal_finSi">
                                            <label class="form-check-label" for="aportemarginal_finSi">Si</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="aportemarginal_fin" id="aportemarginal_finNo" checked>
                                            <label class="form-check-label" for="aportemarginal_finNo">No</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-4 mb-3">
                                        <label for="select_unidadresponsablereportar" class="form-label">Unidad responsable de reportar el indicador</label>
                                        <select id="select_unidadresponsablereportar" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="descripcionindicador_fin" class="form-label">Descripción Indicador</label>
                                        <textarea class="form-control" id="descripcionindicador_fin" required maxlength="300" rows="3"></textarea>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="descripcionnumerador_fin" class="form-label">Descripción Numerador</label>
                                        <textarea class="form-control" id="descripcionnumerador_fin" required maxlength="300" rows="3"></textarea>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="descripciondenominador_fin" class="form-label">Descripción Denominador</label>
                                        <textarea class="form-control" id="descripciondenominador_fin" required maxlength="300" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-proposito" role="tabpanel" aria-labelledby="tab-proposito" tabindex="0">
                                proposito
                            </div>
                            <div class="tab-pane fade" id="nav-componentes" role="tabpanel" aria-labelledby="tab-componentes" tabindex="0">
                                componentes
                            </div>
                            <div class="tab-pane fade" id="nav-actividades" role="tabpanel" aria-labelledby="tab-actividades" tabindex="0">
                                actividades
                            </div>
                            <div class="tab-pane fade" id="nav-auditoriacarga" role="tabpanel" aria-labelledby="tab-auditoriacarga" tabindex="0">
                                auditoriacarga
                            </div>
                            <div class="tab-pane fade" id="nav-auditoriaformulas" role="tabpanel" aria-labelledby="tab-auditoriaformulas" tabindex="0">
                                auditoriaformulas
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" id="BtnGuardarBeneficiario" class="btn btn-primary" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes._partialFooter')
<script src="/js/Repository.js"></script>
<script src="/js/RevisarMir.js"></script>

</body>

</html>