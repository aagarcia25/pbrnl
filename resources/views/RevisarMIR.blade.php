@php
   $view = "Revisar MIR";
   $img = "icono_revisar_MIR.svg";
   $esEnlacePbr = $tipoUsuario != 1;
   $disabled = $esEnlacePbr == 1 ? "disabled" : "";
@endphp

 @include('includes._partialHeader')

<link rel="stylesheet" type="text/css" href="css/EstilosPbR.css" />

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />

<style>
    .input-background-white {
        background-color: white;
    }
</style>

<div class="Margin-Top">
    @include('includes._partialBreadcrumbMir')
<script type="text/javascript">var tu = {{$tipoUsuario}};</script>

    <section class="container section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-transparent border border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <label for="select_ef" class="form-label">Ejercicio Fiscal</label>
                                <select id="select_ef" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="select_Secretaria" class="form-label">Id Secretaría</label>
                                <select id="select_Secretaria" class="selectpicker show-tick form-control select_border" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                    
                                </select>
                            </div>
                            <div class="col-5">
                                <label for="select_UnidadAdministrativa" class="form-label">Id Unidad Administrativa</label>
                                <select id="select_UnidadAdministrativa" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                    
                                </select>
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        <div class="d-flex flex-row-reverse bd-highlight mt-4">
                            <div class="p-2 bd-highlight">
                                <button type="button" id="BtnEditarMir" class="btn button-crud"><i class="bi bi-trash"></i> Editar</button>
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
                                        <th scope="col" width="5%">CONAC</th>
                                        <th scope="col" width="5%">Consecutivo</th>
                                        <th scope="col" width="45%">Descripción Programa</th>
                                        <th scope="col" width="5%">Tipo Programa</th>
                                        <th scope="col" width="20%">Tipo de Beneficiario</th>
                                        
                                        <th scope="col" width="20%">Estatus</th>
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

    <form id="frmModal" novalidate>
        <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-xl modal-center">
                <div class="modal-content">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header">
                        <h5 class="modal-title">Editar MIR <span id="modal_accion"></span></h5>
                    </div>
                    <div class="modal-body">
                        <nav>
                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                <button class="nav-link tab-modal-caratula active BotonesTab" id="tab-caratula" data-bs-toggle="tab" data-bs-target="#nav-caratula" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Carátula</button>
                                <button class="nav-link tab-modal-caratula BotonesTab" id="tab-fin" data-bs-toggle="tab" data-bs-target="#nav-fin" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Fin</button>
                                <button class="nav-link tab-modal-caratula BotonesTab" id="tab-proposito" data-bs-toggle="tab" data-bs-target="#nav-proposito" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Propósito</button>
                                <button class="nav-link tab-modal-caratula BotonesTab" id="tab-componentes" data-bs-toggle="tab" data-bs-target="#nav-componentes" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Componentes</button>
                                <button class="nav-link tab-modal-caratula BotonesTab" id="tab-actividades" data-bs-toggle="tab" data-bs-target="#nav-actividades" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Actividades</button>
                                <!-- <button class="nav-link tab-modal-caratula BotonesTab" id="tab-auditoriacarga" onclick="GetMirAutoriaCarga();" data-bs-toggle="tab" data-bs-target="#nav-auditoriacarga" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Auditoría de carga</button>
                                <button class="nav-link tab-modal-caratula BotonesTab" id="tab-auditoriaformulas" onclick="GetMirAutoriaFormulas();" data-bs-toggle="tab" data-bs-target="#nav-auditoriaformulas" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Auditoría de fórmulas</button> -->
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-caratula" role="tabpanel" aria-labelledby="tab-caratula" tabindex="0">
                                <div class="row">
                                    <input type="hidden" id="consecutivo_caratula">
                                    <input type="hidden" id="conac_caratula">
                                    <div class="col-6 mb-1 FormUsr FontMsg">
                                        <label for="select_entepublido" class="form-labelUsr3">Ente Público</label>
                                        <select disabled id="select_entepublido" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required Height="40px">
                                        </select>
                                    </div>
                                    <div class="col-6 mb-1 FormUsr FontMsg">
                                        <label for="select_uaresponsable" class="form-labelUsr3">Unidad Administrativa Responsable</label>
                                        <select disabled id="select_uaresponsable" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required >
                                        </select>
                                    </div>
                                    <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                        <label for="nombre_pp" class="form-labelUsr4">Nombre del PP</label>
                                        <input type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center text-uppercase" id="nombre_pp" readonly>
                                    </div>
                                    <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                        <label for="clave_programatica" class="form-labelUsr4">Clave Programática</label>
                                        <input type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center" id="clave_programatica" readonly>
                                    </div>
                                    <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                        <label for="ejercicio_fiscal" class="form-labelUsr4">Ejercicio Fiscal</label>
                                        <input type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center" id="ejercicio_fiscal" readonly>
                                    </div>
                                    <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                        <label for="select_ejeped" class="form-labelUsr3">Eje del PED</label>
                                        <select disabled id="select_ejeped" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                        <label for="select_temaped" class="form-labelUsr3">Tema del PED</label>
                                        <select disabled id="select_temaped" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                        <label for="select_objetivo" class="form-labelUsr3">Id Objetivo</label>
                                        <select disabled id="select_objetivo" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                        <label for="select_estrategia" class="form-labelUsr3">Id Estrategia</label>
                                        <select {{ $disabled }} id="select_estrategia" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                        <label  for="select_lineaaccion1" class="form-labelUsr3">Id Línea Acción 1</label>
                                        <select {{ $disabled }} id="select_lineaaccion1" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                        <label for="select_lineaaccion2" class="form-labelUsr3">Id Línea Acción 2</label>
                                        <select {{ $disabled }} id="select_lineaaccion2" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                        <label for="programa_sectorial" class="form-labelUsr4">Programa Sectorial, Regional, Especial o Institucional</label>
                                        <input type="text" class="TextBoxUsr w-100 H-50" id="programa_sectorial">
                                    </div>
                                    <div class="col-4 align-self-center FormUsr FontMsg mt-3">
                                        <label for="select_tipobeneficiario" class="form-labelUsr3">Tipo de Beneficiario</label>
                                        <select {{ $disabled }} id="select_tipobeneficiario" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                                <label for="select_descripcionampliabeneficiario1" class="form-labelUsr3">Descripción Amplia del Beneficiario 1 (Población o Area de Enfoque Objetivo)</label>
                                                <select {{$disabled}} id="select_descripcionampliabeneficiario1" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                </select>
                                            </div>
                                            <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                                <label for="select_descripcionampliabeneficiario2" class="form-labelUsr3">Descripción Amplia del Beneficiario 2 (Población o Area de Enfoque Objetivo)</label>
                                                <select {{$disabled}} id="select_descripcionampliabeneficiario2" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-fin" role="tabpanel" aria-labelledby="tab-fin" tabindex="0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <div class="p-2 flex-grow-1">
                                                <img id="fin-izq" src="img/icono izq.svg" 
                                                    class="tabs-internas cursor-pointer" 
                                                    onmouseover="img_over('fin-izq', 'img/icono izq activo.svg')" 
                                                    onmouseout="img_out('fin-izq', 'img/icono izq.svg')" 
                                                    data-superior="fin" data-seccion="findos" 
                                                    data-actual="finuno" 
                                                    onclick='flechas_click(event, "fin")' 
                                                    data-texto="1/2" width="30" height="30">
                                            </div>
                                            <div class="p-2">
                                                <b class="m-3 money-tabs-fin">1/2</b>
                                                <img id="fin-der" 
                                                    src="img/icono der.svg" 
                                                    class="tabs-internas cursor-pointer" 
                                                    onmouseover="img_over('fin-der', 'img/icono der activo.svg')" 
                                                    onmouseout="img_out('fin-der', 'img/icono der.svg')" 
                                                    data-superior="fin" 
                                                    data-seccion="finuno" 
                                                    data-actual="findos" 
                                                    onclick='flechas_click(event, "fin")' 
                                                    data-texto="2/2" width="30" height="30">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="finuno">
                                    <input type="hidden" id="claseprogramatica_fin">
                                    <div class="row">
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="fin_fin" class="form-labelUsr4">Fin</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="fin_fin" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-2 mb-1 FormUsr FontMsg mt-3">
                                            <label for="claveindicador_fin" class="form-labelUsr4">Clave Indicador</label>
                                            <input type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center" disabled=""  id="claveindicador_fin" readonly>
                                        </div>
                                        <div class="col-10 mb-1 FormUsr FontMsg mt-3">
                                            <label for="nombreindicar_fin" class="form-labelUsr4">Nombre del Indicador</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50 contador-letras" id="nombreindicar_fin" required data-maxlength="200" rows="2"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblContIndicadorFin" class="LabelContador me-4">0/30</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="descripcionformula_fin" class="form-labelUsr4">Descripción del método de cálculo</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="descripcionformula_fin" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3 Rows4">
                                            <label for="variable1_fin" class="form-labelUsr4">Variable 1 (V1)</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable1_fin" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable2_fin" class="form-labelUsr4">Variable 2 (V2)</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable2_fin" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable3_fin" class="form-labelUsr4">Método de cálculo</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable3_fin" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="select_unidadmedida_fin" class="form-labelUsr3">Unidad de Medida</label>
                                                    <select {{ $disabled }} id="select_unidadmedida_fin" class="TextBoxUsr unidad-medida select-mir w-100" data-tipo="fin" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                        <option value="-">-</option>
                                                        <option value="PORCENTAJE">PORCENTAJE</option>
                                                        <option value="ABSOLUTO">ABSOLUTO</option>
                                                    </select>
                                                </div>
                                                <div id="d-descripcionunidadmedida_fin" class="col-12 d-none FormUsr FontMsg mt-3">
                                                    <label for="descripcionunidadmedida_fin" class="form-labelUsr4">Descripción</label>
                                                    <input type="text" class="form-control TextBoxUsr w-100 H-50" id="descripcionunidadmedida_fin">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="selectfrecuencia_fin" class="form-labelUsr3">Frecuencia</label>
                                            <select {{ $disabled }} id="selectfrecuencia_fin" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ANUAL">ANUAL</option>
                                                <option value="BIENAL">BIENAL</option>
                                            </select>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3 H-60">
                                            <label for="metaanual_fin" class="form-labelUsr4">Meta Anual</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" id="metaanual_fin" disabled="" >
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3 border border-1 border-black rounded">
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label for="ejecerciciofisca_fin" class="form-label">Ejercicio Fiscal:</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select {{ $disabled }} id="ejecerciciofisca_fin" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                                <option value="-">-</option>
                                                                <option value="2020">2020</option>
                                                                <option value="2021">2021</option>
                                                            </select>               
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label for="lineabase_fin1" class="form-label">Línea Base</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" class="form-control" id="lineabase_fin1" disabled >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable1numerador_fin" class="form-labelUsr4">Variable 1 (Numerador)</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50 money" id="variable1numerador_fin">
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable2numerador_fin" class="form-labelUsr4">Variable 2 (Denominador)</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50 money" id="variable2numerador_fin">
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="lineabaseV1_fin" class="form-labelUsr4">V1</label>
                                            <input  type="text" class="TextBoxUsr w-100 H-50 money" id="lineabaseV1_fin">
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="lineabaseV2_fin" class="form-labelUsr4">V2</label>
                                            <input  type="text" class="TextBoxUsr w-100 H-50 money" id="lineabaseV2_fin">
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="mediosverificacion_fin" class="form-labelUsr4">Medios de Verificación</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsr w-100 H-50" id="mediosverificacion_fin">
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="fuentesinformacion_fin" class="form-labelUsr4">Fuentes de Información</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsr w-100 H-50" id="fuentesinformacion_fin">
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="supuestos_fin" class="form-labelUsr4">Supuestos</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="supuestos_fin" required maxlength="300" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="findos" class="d-none">
                                    <div class="row">
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_sentidoindicador_fin" class="form-labelUsr3">Sentido del Indicador</label>
                                            <select {{ $disabled }} id="select_sentidoindicador_fin" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ASCENDENTE">ASCENDENTE</option>
                                                <option value="DESCENDENTE">DESCENDENTE</option>
                                                <option value="NORMAL">NORMAL</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_tipoindicador_fin" class="form-labelUsr3">Tipo de indicador</label>
                                            <select {{ $disabled }} id="select_tipoindicador_fin" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ESTRATÉGICO">ESTRATÉGICO</option>
                                                <option value="GESTIÓN">GESTIÓN</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_dimensionindicador_fin" class="form-labelUsr3">Dimensión del indicador</label>
                                            <select {{ $disabled }} id="select_dimensionindicador_fin" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="CALIDAD">CALIDAD</option>
                                                <option value="ECONOMÍA">ECONOMÍA</option>
                                                <option value="EFICACIA">EFICACIA</option>
                                                <option value="EFICIENCIA">EFICIENCIA</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="FontMsg col-12 text-center">
                                            ANÁLISIS CREMAA
                                        </div>
                                        <div class="row w-100">
                                            <div class="col-1 ms-3"></div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Claridad</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="claridad_fin" id="claridad_finSi" value="S">
                                                    <label class="form-check-label ms-4" for="claridad_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="claridad_fin" id="claridad_finNo" value="N">
                                                    <label class="form-check-label ms-4" for="claridad_finNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Relevancia</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="relevancia_fin" id="relevancia_finSi" value="S">
                                                    <label class="form-check-label ms-4" for="relevancia_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="relevancia_fin" id="relevancia_finNo" value="N">
                                                    <label class="form-check-label ms-4" for="relevancia_finNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Economía</label>
                                                <div class="form-check">
                                                    <input class="form-check-input ms-5" type="radio" name="economia_fin" id="economia_finSi" value="S">
                                                    <label class="form-check-label ms-4" for="economia_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="economia_fin" id="economia_finNo" value="N">
                                                    <label class="form-check-label ms-4" for="economia_finNo">No</label>
                                                </div>
                                            </div>    
                                            <div class="col-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1 ms-3"></div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Monitoreable</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="monitoreable_fin" id="monitoreable_finSi" value="S">
                                                    <label class="form-check-label ms-4" for="monitoreable_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="monitoreable_fin" id="monitoreable_finNo" value="N">
                                                    <label class="form-check-label ms-4" for="monitoreable_finNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Adecuado</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="adecuado_fin" id="adecuado_finSi" value="S">
                                                    <label class="form-check-label ms-4" for="adecuado_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="adecuado_fin" id="adecuado_finNo" value="N">
                                                    <label class="form-check-label ms-4" for="adecuado_finNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Aporte marginal</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="aportemarginal_fin" id="aportemarginal_finSi" value="S">
                                                    <label class="form-check-label ms-4" for="aportemarginal_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="aportemarginal_fin" id="aportemarginal_finNo" value="N">
                                                    <label class="form-check-label ms-4" for="aportemarginal_finNo">No</label>
                                                </div>
                                            </div>    
                                            <div class="col-1"></div>
                                        </div>
                                        <hr>
                                        <div class="col-12 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_unidadresponsablereportar_fin" class="form-labelUsr3">Unidad responsable de reportar el indicador</label>
                                            <select disabled id="select_unidadresponsablereportar_fin" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionindicador_fin" class="form-labelUsr4">Descripción Indicador</label>
                                            <textarea class="form-control TextBoxUsr w-100 contador-letras" id="descripcionindicador_fin" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblIndicaFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionnumerador_fin" class="form-labelUsr4">Descripción Numerador</label>
                                            <textarea class="form-control TextBoxUsr w-100 contador-letras" id="descripcionnumerador_fin" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblContDescNumFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripciondenominador_fin" class="form-labelUsr4">Descripción Denominador</label>
                                            <textarea class="form-control TextBoxUsr w-100 contador-letras" id="descripciondenominador_fin" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblContDescDenomFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-proposito" role="tabpanel" aria-labelledby="tab-proposito" tabindex="0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <div class="p-2 flex-grow-1">
                                                <img id="proposito-izq" 
                                                    src="img/icono izq.svg" 
                                                    class="tabs-internas cursor-pointer" 
                                                    onmouseover="img_over('proposito-izq', 'img/icono izq activo.svg')" 
                                                    onmouseout="img_out('proposito-izq', 'img/icono izq.svg')" 
                                                    data-superior="proposito" 
                                                    data-seccion="propositodos" 
                                                    data-actual="propositouno" 
                                                    onclick='flechas_click(event, "proposito")' 
                                                    data-texto="1/2" width="30" height="30">
                                            </div>
                                            <div class="p-2">
                                                <b class="m-3 money-tabs-proposito">1/2</b>
                                                <img id="proposito-der" 
                                                    src="img/icono der.svg" 
                                                    class="tabs-internas cursor-pointer" 
                                                    onmouseover="img_over('proposito-der', 'img/icono der activo.svg')" 
                                                    onmouseout="img_out('proposito-der', 'img/icono der.svg')" 
                                                    data-superior="proposito" 
                                                    data-seccion="propositouno" 
                                                    data-actual="propositodos" 
                                                    onclick='flechas_click(event, "proposito")' 
                                                    data-texto="2/2" width="30" height="30">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="propositouno">
                                    <input type="hidden" id="claseprogramatica_proposito">
                                    <div class="row">
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="proposito_proposito" class="form-labelUsr4">Proposito</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="proposito_proposito" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-2 mb-1 FormUsr FontMsg mt-3">
                                            <label for="claveindicador_proposito" class="form-labelUsr4">Clave indicador</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center" id="claveindicador_proposito"  disabled="" >
                                        </div>
                                        <div class="col-10 mb-1 FormUsr FontMsg mt-3">
                                            <label for="nombreindicar_proposito" class="form-labelUsr4">Nombre del indicador</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50 contador-letras" id="nombreindicar_proposito" data-maxlength="200" required rows="2"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblContIndicadorProp" class="LabelContador me-4">0/30</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="descripcionformula_proposito" class="form-labelUsr4">Descripción de la fórmula</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="descripcionformula_proposito" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable1_proposito" class="form-labelUsr4">Variable 1 (V1)</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable1_proposito" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable2_proposito" class="form-labelUsr4">Variable 2 (V2)</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable2_proposito" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable3_proposito" class="form-labelUsr4">Método de cálculo</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable3_proposito" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="select_unidadmedida_proposito" class="form-labelUsr3">Unidad de medida</label>
                                                    <select {{ $disabled }} id="select_unidadmedida_proposito" class="TextBoxUsr unidad-medida select-mir w-100" data-tipo="proposito" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                        <option value="-">-</option>
                                                        <option value="PORCENTAJE">PORCENTAJE</option>
                                                        <option value="ABSOLUTO">ABSOLUTO</option>
                                                    </select>
                                                </div>
                                                <div id="d-descripcionunidadmedida_proposito" class="col-12 d-none FormUsr FontMsg mt-3">
                                                    <label for="descripcionunidadmedida_proposito" class="form-labelUsr4">Descripción</label>
                                                    <input {{ $disabled }} type="text" class="form-control TextBoxUsr w-100 H-50" id="descripcionunidadmedida_proposito">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="selectfrecuencia_proposito" class="form-labelUsr3">Frecuencia</label>
                                            <select {{ $disabled }} id="selectfrecuencia_proposito" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ANUAL">ANUAL</option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="metaanual_proposito" class="form-labelUsr4">Meta anual</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" id="metaanual_proposito" disabled="" >
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3 border border-1 border-black rounded">
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label for="ejecerciciofisca_proposito" class="form-label">Ejercicio fiscal:</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select {{ $disabled }} id="ejecerciciofisca_proposito" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                                <option value="-">-</option>
                                                                <option value="2020">2020</option>
                                                                <option value="2021">2021</option>
                                                            </select>                
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label for="lineabase_proposito1" class="form-label">Línea base</label>
                                                        </div>
                                                        <div {{ $disabled }} class="col-6">
                                                            <input type="text" class="form-control" id="lineabase_proposito1" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable1numerador_proposito" class="form-labelUsr4">Variable 1 (Numerador)</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="variable1numerador_proposito">
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable2numerador_proposito" class="form-labelUsr4">Variable 2 (Denominador)</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="variable2numerador_proposito">
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="lineabaseV1_proposito" class="form-labelUsr4">V1</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50 money" id="lineabaseV1_proposito">
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="lineabaseV2_proposito" class="form-labelUsr4">V2</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50 money" id="lineabaseV2_proposito">
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="mediosverificacion_proposito" class="form-labelUsr4">Medios de Verificación</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsr w-100 H-50" id="mediosverificacion_proposito">
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="fuentesinformacion_proposito" class="form-labelUsr4">Fuentes de Información</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsr w-100 H-50" id="fuentesinformacion_proposito">
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="supuestos_proposito" class="form-labelUsr4">Supuestos</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="supuestos_proposito" required maxlength="300" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="propositodos" class="d-none">
                                    <div class="row">
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_sentidoindicador_proposito" class="form-labelUsr3">Sentido del indicador</label>
                                            <select {{ $disabled }} id="select_sentidoindicador_proposito" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ASCENDENTE">ASCENDENTE</option>
                                                <option value="DESCENDENTE">DESCENDENTE</option>
                                                <option value="NORMAL">NORMAL</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_tipoindicador_proposito" class="form-labelUsr3">Tipo de indicador</label>
                                            <select {{ $disabled }} id="select_tipoindicador_proposito" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ESTRATÉGICO">ESTRATÉGICO</option>
                                                <option value="GESTIÓN">GESTIÓN</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_dimensionindicador_proposito" class="form-labelUsr3">Dimensión del indicador</label>
                                            <select {{ $disabled }} id="select_dimensionindicador_proposito" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="CALIDAD">CALIDAD</option>
                                                <option value="ECONOMÍA">ECONOMÍA</option>
                                                <option value="EFICACIA">EFICACIA</option>
                                                <option value="EFICIENCIA">EFICIENCIA</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="col-12 text-center">
                                            ANÁLISIS CREMAA
                                        </div>
                                        <div class="row w-100">
                                            <div class="col-1 ms-3"></div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Claridad</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="claridad_proposito" id="claridad_propositoSi" value="S">
                                                    <label class="form-check-label ms-4" for="claridad_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="claridad_proposito" id="claridad_propositoNo" value="N">
                                                    <label class="form-check-label ms-4" for="claridad_propositoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Relevancia</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="relevancia_proposito" id="relevancia_propositoSi" value="S">
                                                    <label class="form-check-label ms-4" for="relevancia_propositoSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="relevancia_proposito" id="relevancia_propositoNo" value="N">
                                                    <label class="form-check-label ms-4" for="relevancia_propositoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Economía</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="economia_proposito" id="economia_propositoSi" value="S">
                                                    <label class="form-check-label ms-4" for="economia_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="economia_proposito" id="economia_propositoNo" value="N">
                                                    <label class="form-check-label ms-4" for="economia_propositoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-1 ms-3"></div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Monitoreable</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="monitoreable_proposito" id="monitoreable_propositoSi" value="S">
                                                    <label class="form-check-label ms-4" for="monitoreable_propositoSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="monitoreable_proposito" id="monitoreable_propositoNo" value="N">
                                                    <label class="form-check-label ms-4" for="monitoreable_propositoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Adecuado</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="adecuado_proposito" id="adecuado_propositoSi" value="S">
                                                    <label class="form-check-label ms-4" for="adecuado_propositoSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="adecuado_proposito" id="adecuado_propositoNo" value="N">
                                                    <label class="form-check-label ms-4" for="adecuado_propositoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Aporte marginal</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="aportemarginal_proposito" id="aportemarginal_propositoSi" value="S">
                                                    <label class="form-check-label ms-4" for="aportemarginal_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="aportemarginal_proposito" id="aportemarginal_propositoNo" value="N">
                                                    <label class="form-check-label ms-5" for="aportemarginal_propositoNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-1"></div>
                                        </div>
                                        <hr>
                                        <div class="col-12 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_unidadresponsablereportar_proposito" class="form-labelUsr3">Unidad responsable de reportar el indicador</label>
                                            <select disabled id="select_unidadresponsablereportar_proposito" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionindicador_proposito" class="form-labelUsr4">Descripción Indicador</label>
                                            <textarea class="form-control TextBoxUsr w-100 contador-letras" id="descripcionindicador_proposito" data-maxlength="300" required maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label ID="lbContlIndicaProp" class="LabelContador me-4" >0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionnumerador_proposito" class="form-labelUsr4">Descripción Numerador</label>
                                            <textarea class="form-control TextBoxUsr w-100 contador-letras" id="descripcionnumerador_proposito" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label ID="lblContDescNumProp" class="LabelContador me-4" >0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripciondenominador_proposito" class="form-labelUsr4">Descripción Denominador</label>
                                            <textarea  class="form-control TextBoxUsr w-100 contador-letras" id="descripciondenominador_proposito" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label ID="lblContDescDenomProp" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-componentes" role="tabpanel" aria-labelledby="tab-componentes" tabindex="0">
                                <div class="row">
                                    <input type="hidden" id="claseprogramatica_componente">
                                    <div class="col-1">
                                        <div class="d-flex">
                                            <div class="p-2 flex-grow-1">
                                                <img id="componente-anterior" class="tabs-select-componente cursor-pointer" data-tipo="-1" src="img/icono anterior.svg" onmouseover="img_over('componente-anterior', 'img/icono anterior activo.svg')" onmouseout="img_out('componente-anterior', 'img/icono anterior.svg')" width="30" height="30">
                                            </div>
                                            <div class="p-2">
                                                <img id="componente-siguiente" class="tabs-select-componente cursor-pointer" data-tipo="+1" src="img/icono siguiente.svg" onmouseover="img_over('componente-siguiente', 'img/icono siguiente activo.svg')" onmouseout="img_out('componente-siguiente', 'img/icono siguiente.svg')" width="30" height="30">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 mb-1 FormUsr FontMsg mt-3">
                                        <label for="id_componente" class="form-labelUsr4">Id Componente</label>
                                        <input type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center" id="id_componente"  disabled="" >
                                    </div>
                                    <div class="col-9 mb-1 FormUsr FontMsg mt-3">
                                        <label for="nombre_componente" class="form-labelUsr4">Componente</label>
                                        <input disabled type="text" class="TextBoxUsr w-100 H-50" id="nombre_componente">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <div class="p-2 flex-grow-1">
                                                <img id="componente-izq" 
                                                    src="img/icono izq.svg" 
                                                    src="img/icono izq activo.svg" 
                                                    onmouseover="img_over('componente-izq', 'img/icono izq activo.svg')" 
                                                    onmouseout="img_out('componente-izq', 'img/icono izq.svg')" 
                                                    class="tabs-internas cursor-pointer" 
                                                    data-superior="componentes" 
                                                    data-seccion="componentesdos" 
                                                    data-actual="componentesuno" 
                                                    data-texto="1/2" 
                                                    onclick='flechas_click(event, "componentes")' 
                                                    width="30" height="30">
                                            </div>
                                            <div class="p-2">
                                                <b class="m-3 money-tabs-componentes">1/2</b>
                                                <img id="componente-der" src="img/icono der.svg" src="img/icono der activo.svg" onmouseover="img_over('componente-der', 'img/icono der activo.svg')" onmouseout="img_out('componente-der', 'img/icono der.svg')" class="tabs-internas cursor-pointer" data-superior="componentes" data-seccion="componentesuno" data-actual="componentesdos" data-texto="2/2" 
                                                onclick='flechas_click(event, "componentes")'  width="30" height="30">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="componentesuno">
                                    <div class="row">
                                        <div class="col-2 mb-1 FormUsr FontMsg mt-3">
                                            <label for="claveindicador_componente" class="form-labelUsr4">Clave Indicador</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="claveindicador_componente" disabled="" >
                                        </div>
                                        <div class="col-10 mb-1 FormUsr FontMsg mt-3">
                                            <label for="nombreindicar_componente" class="form-labelUsr4">Nombre del Indicador</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50 contador-letras" id="nombreindicar_componente" required data-maxlength="200" rows="2"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblContIndicadorComp" class="LabelContador me-4">0/30</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="descripcionformula_componente" class="form-labelUsr4">Descripción de la Fórmula</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="descripcionformula_componente" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable1_componente" class="form-labelUsr4">Variable 1 (V1)</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable1_componente" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable2_componente" class="form-labelUsr4">Variable 2 (V2)</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable2_componente" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable3_componente" class="form-labelUsr4">Método de cálculo</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable3_componente" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="select_unidadmedida_componente" class="form-labelUsr3">Unidad de Medida</label>
                                                    <select {{ $disabled }} id="select_unidadmedida_componente" class="TextBoxUsr unidad-medida select-mir w-100" data-tipo="componente" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                        <option value="-">-</option>
                                                        <option value="PORCENTAJE">PORCENTAJE</option>
                                                        <option value="ABSOLUTO">ABSOLUTO</option>
                                                    </select>
                                                </div>
                                                <div id="d-descripcionunidadmedida_componente" class="col-12 d-none FormUsr FontMsg mt-3">
                                                    <label for="descripcionunidadmedida_componente" class="form-labelUsr4">Descripción</label>
                                                    <input {{ $disabled }} type="text" class="form-control TextBoxUsr w-100 H-50" id="descripcionunidadmedida_componente">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3 border border-1 border-black rounded H-60">
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label for="ejecerciciofisca_componente" class="form-label">Ejercicio Fiscal:</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <select {{ $disabled }} id="ejecerciciofisca_componente" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                                <option value="-">-</option>
                                                                <option value="2020">2020</option>
                                                                <option value="2021">2021</option>
                                                            </select>                
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2">
                                                            <label for="lineabase_componente1" class="form-label">Línea Base</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input disabled type="text" class="form-control" id="lineabase_componente1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5 mb-1 FormUsr FontMsg ms-5 mt-3 border border-1 border-black rounded H-60">
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-3 mt-2">
                                                            <label for="lineabaseV1_componente" class="form-label">V1</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control money" id="lineabaseV1_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-3 mt-2">
                                                            <label for="lineabaseV2_componente" class="form-label">V2</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control money" id="lineabaseV2_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-8 LetretosFont fw-bold">
                                            <b>El Usuario deberá capturar los datos de las variables de cada semestre o trimestre. El interfaz calculará los datos acumulados a la frecuencia capturada.</b>
                                        </div>
                                        <div class="col-4 LetretosFont fw-bold">
                                            <b>D: Dato del Semestre/Trimestre.</b><br>
                                            <b>A: Acumulado. Cálculo que hace el Interfaz.</b>
                                        </div>    
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 FormUsr FontMsg mt-3">
                                            <label for="metaanual_componente" class="form-labelUsr4">Meta Anual</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" disabled=""  id="metaanual_componente">
                                        </div>
                                        <div class="col-2 FormUsr FontMsg mt-3">
                                            <label for="selectfrecuencia_componente" class="form-labelUsr3">Frecuencia</label>
                                            <select id="selectfrecuencia_componente" class="TextBoxUsr select-frecuencia select-mir w-100" data-tipo="componente" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="TRIMESTRAL">TRIMESTRAL</option>
                                                <option value="SEMESTRAL">SEMESTRAL</option>
                                            </select>
                                        </div>
                                        <div class="col-4 d-none d-metasemestral-componente FormUsr FontMsg mt-3">
                                            <label for="metasemestral1_componente" class="form-labelUsr4">Meta Semestre I</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" disabled=""  id="metasemestral1_componente">
                                        </div>
                                        <div class="col-4 d-none d-metasemestral-componente FormUsr FontMsg mt-3">
                                            <label for="metasemestral2_componente" class="form-labelUsr4">Meta Semestre II</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" disabled=""  id="metasemestral2_componente">
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente FormUsr FontMsg mt-3">
                                            <label for="metatrimestral1_componente" class="form-labelUsr4">Meta Trimestre I</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" disabled=""  id="metatrimestral1_componente">
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente FormUsr FontMsg mt-3">
                                            <label for="metatrimestral2_componente" class="form-labelUsr4">Meta Trimestre II</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" disabled=""  id="metatrimestral2_componente">
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente FormUsr FontMsg mt-3">
                                            <label for="metatrimestral3_componente" class="form-labelUsr4">Meta Trimestre III</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" disabled=""  id="metatrimestral3_componente">
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente FormUsr FontMsg mt-3">
                                            <label for="metatrimestral4_componente" class="form-labelUsr4">Meta Trimestre IV</label>
                                            <input type="text" class="TextBoxUsr w-100 H-60" disabled=""  id="metatrimestral4_componente">
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 FormUsr FontMsg mt-3">
                                            <label for="variableV1_componente" class="form-labelUsr4">V1</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="variableV1_componente" disabled="" >
                                        </div>
                                        <div class="col-2">
                                            
                                        </div>
                                        <div class="col-4 d-none d-metasemestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V1D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral1V1D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V1A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" disabled=""  id="metasemestral1V1A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 d-none d-metasemestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V1D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral2V1D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V1A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" disabled=""  id="metasemestral2V1A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V1D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral1V1D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V1A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled="" onchange="MetaS1V1A_Componente();"  id="metatrimestral1V1A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V1D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral2V1D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V1A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled=""  id="metatrimestral2V1A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V1D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral3V1D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V1A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled=""  id="metatrimestral3V1A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V1D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral4V1D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V1A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled=""  id="metatrimestral4V1A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-2 FormUsr FontMsg mt-3">
                                            <label for="variableV2_componente" class="form-labelUsr4">V2</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="variableV2_componente" disabled="" >
                                        </div>
                                        <div class="col-2">
                                            <div class="row d-flex align-items-center justify-content-center">
                                                <input type="button" id="checkDenominadorFijo_componente" class="DenominadorFijoInactivo denominadorfijo ms-2" data-tipo="componente">
                                            </div>
                                            <div class="row">
                                                <p class="LetretosFont text-center">Activar en caso de que el denominador sea una constante.</p>
                                                <input type="hidden" id="clicDenominador_componente" value="0" >
                                            </div>
                                        </div>
                                        <div class="col-4 d-none d-metasemestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V2D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral1V2D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V2A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" disabled=""  id="metasemestral1V2A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 d-none d-metasemestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V2D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral2V2D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V2A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" disabled=""  id="metasemestral2V2A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V2D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral1V2D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V2A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled=""  id="metatrimestral1V2A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V2D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral2V2D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V2A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled=""  id="metatrimestral2V2A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V2D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral3V2D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V2A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled=""  id="metatrimestral3V2A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-componente">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V2D_componente" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral4V2D_componente" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V2A_componente" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" disabled=""  id="metatrimestral4V2A_componente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="componentesdos" class="d-none">
                                    <div class="row">
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="mediosverificacion_componente" class="form-labelUsr4">Medios de Verificación</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsr w-100 H-50" id="mediosverificacion_componente">
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="fuentesinformacion_componente" class="form-labelUsr4">Fuentes de Información</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsr w-100 H-50" id="fuentesinformacion_componente">
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="supuestos_componente" class="form-labelUsr4">Supuestos</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="supuestos_componente" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_sentidoindicador_componente" class="form-labelUsr3">Sentido del indicador</label>
                                            <select {{ $disabled }} id="select_sentidoindicador_componente" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ASCENDENTE">ASCENDENTE</option>
                                                <option value="DESCENDENTE">DESCENDENTE</option>
                                                <option value="NORMAL">NORMAL</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_tipoindicador_componente" class="form-labelUsr3">Tipo de indicador</label>
                                            <select {{ $disabled }} id="select_tipoindicador_componente" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ESTRATÉGICO">ESTRATÉGICO</option>
                                                <option value="GESTIÓN">GESTIÓN</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_dimensionindicador_componente" class="form-labelUsr3">Dimensión del indicador</label>
                                            <select {{ $disabled }} id="select_dimensionindicador_componente" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="CALIDAD">CALIDAD</option>
                                                <option value="ECONOMÍA">ECONOMÍA</option>
                                                <option value="EFICACIA">EFICACIA</option>
                                                <option value="EFICIENCIA">EFICIENCIA</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="FontMsg col-12 text-center">
                                            ANÁLISIS CREMAA
                                        </div>
                                        <div class="row w-100">
                                            <div class="col-1 ms-3"></div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Claridad</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="claridad_componente" id="claridad_componenteSi" value="S">
                                                    <label class="form-check-label ms-4" for="claridad_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="claridad_componente" id="claridad_componenteNo" value="N">
                                                    <label class="form-check-label ms-4" for="claridad_componenteNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Relevancia</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="relevancia_componente" id="relevancia_componenteSi" value="S">
                                                    <label class="form-check-label ms-4" for="relevancia_componenteSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="relevancia_componente" id="relevancia_componenteNo" value="N">
                                                    <label class="form-check-label ms-4" for="relevancia_componenteNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Economía</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="economia_componente" id="economia_componenteSi" value="S">
                                                    <label class="form-check-label ms-4" for="economia_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="economia_componente" id="economia_componenteNo" value="N">
                                                    <label class="form-check-label ms-4" for="economia_componenteNo">No</label>
                                                </div>
                                            </div>
                                                <div class="col-1"></div>
                                        </div>
                                        <div class="row w-100">
                                            <div class="col-1 ms-3"></div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Monitoreable</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="monitoreable_componente" id="monitoreable_componenteSi" value="S">
                                                    <label class="form-check-label ms-4" for="monitoreable_componenteSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="monitoreable_componente" id="monitoreable_componenteNo" value="N">
                                                    <label class="form-check-label ms-4" for="monitoreable_componenteNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Adecuado</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="adecuado_componente" id="adecuado_componenteSi" value="S">
                                                    <label class="form-check-label ms-4" for="adecuado_componenteSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="adecuado_componente" id="adecuado_componenteNo" value="N">
                                                    <label class="form-check-label ms-4" for="adecuado_componenteNo">No</label>
                                                </div>
                                            </div>
                                            <div class="col-3 mb-3 border border-2 rounded ms-4">
                                                <label class="form-label">Aporte marginal</label>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="aportemarginal_componente" id="aportemarginal_componenteSi" value="S">
                                                    <label class="form-check-label ms-4" for="aportemarginal_finSi">Si</label>
                                                </div>
                                                <div class="form-check">
                                                    <input {{ $disabled }} class="form-check-input ms-5" type="radio" name="aportemarginal_componente" id="aportemarginal_componenteNo" value="N">
                                                    <label class="form-check-label ms-4" for="aportemarginal_componenteNo">No</label>
                                                </div>
                                            </div>
                                                <div class="col-1"></div>
                                        </div>
                                        <hr>
                                        <div class="col-12 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_unidadresponsablereportar_componente" class="form-labelUsr3">Unidad responsable de reportar el indicador</label>
                                            <select disabled id="select_unidadresponsablereportar_componente" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionindicador_componente" class="form-labelUsr4">Descripción Indicador</label>
                                            <textarea class="form-control contador-letras" id="descripcionindicador_componente" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblIndicaFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionnumerador_componente" class="form-labelUsr4">Descripción Numerador</label>
                                            <textarea  class="form-control contador-letras" id="descripcionnumerador_componente" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblIndicaFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripciondenominador_componente" class="form-labelUsr4">Descripción Denominador</label>
                                            <textarea  class="form-control contador-letras" id="descripciondenominador_componente" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblIndicaFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-actividades" role="tabpanel" aria-labelledby="tab-actividades" tabindex="0">
                                <div class="row">
                                    <input type="hidden" id="claseprogramatica_actividad">
                                    <input type="hidden" id="idcomponente_actividad">
                                    <div class="col-1">
                                        <div class="d-flex">
                                            <div class="p-2 flex-grow-1">
                                                <img id="componenteactividad-anterior" class="cursor-pointer tabs-select-componente" data-tipo="-1" src="img/icono anterior.svg" onmouseover="img_over('componenteactividad-anterior', 'img/icono anterior activo.svg')" onmouseout="img_out('componenteactividad-anterior', 'img/icono anterior.svg')" width="30" height="30">
                                            </div>
                                            <div class="p-2">
                                                <img id="componenteactividad-siguiente" class="cursor-pointer tabs-select-componente" data-tipo="+1" src="img/icono siguiente.svg" onmouseover="img_over('componenteactividad-siguiente', 'img/icono siguiente activo.svg')" onmouseout="img_out('componenteactividad-siguiente', 'img/icono siguiente.svg')" width="30" height="30">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                        <label for="id_componenteactividad" class="form-labelUsr4">Id componente</label>
                                        <input type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center" id="id_componenteactividad"  disabled="" >
                                    </div>
                                    <div class="col-8 mb-1 FormUsr FontMsg mt-3">
                                        <label for="nombre_componenteactividad" class="form-labelUsr4">Componente</label>
                                        <input disabled type="text" class="TextBoxUsr w-100 H-50" id="nombre_componenteactividad">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <div class="p-2 flex-grow-1">
                                                <img id="actividad-izq" src="img/icono izq.svg" src="img/icono izq activo.svg" onmouseover="img_over('actividad-izq', 'img/icono izq activo.svg')" onmouseout="img_out('actividad-izq', 'img/icono izq.svg')" class="tabs-internas cursor-pointer" data-superior="actividades" data-seccion="actividadesdos" data-actual="actividadesuno" 
                                                data-texto="1/2" 
                                                onclick='flechas_click(event, "actividades")' 
                                                width="30" height="30">
                                            </div>
                                            <div class="p-2">
                                                <b class="m-3 money-tabs-actividades">1/2</b>
                                                <img id="componente-der" 
                                                    src="img/icono der.svg" 
                                                    src="img/icono der activo.svg" onmouseover="img_over('actividad-der', 'img/icono der activo.svg')" onmouseout="img_out('actividad-der', 'img/icono der.svg')" class="tabs-internas cursor-pointer" data-superior="actividades" data-seccion="actividadesuno" data-actual="actividadesdos" 
                                                    onclick='flechas_click(event, "actividades")' 
                                                data-texto="2/2" width="30" height="30">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="actividadesuno">
                                    <div class="row">
                                        <div class="col-1">
                                            <div class="d-flex">
                                                <div class="p-2 flex-grow-1">
                                                    <img id="actividad-anterior" class="cursor-pointer tabs-select-actividad" data-tipo="-1" src="img/icono anterior.svg" onmouseover="img_over('actividad-anterior', 'img/icono anterior activo.svg')" onmouseout="img_out('actividad-anterior', 'img/icono anterior.svg')" width="30" height="30">
                                                </div>
                                                <div class="p-2">
                                                    <img id="actividad-siguiente" class="cursor-pointer tabs-select-actividad" data-tipo="+1" src="img/icono siguiente.svg" onmouseover="img_over('actividad-siguiente', 'img/icono siguiente activo.svg')" onmouseout="img_out('actividad-siguiente', 'img/icono siguiente.svg')" width="30" height="30">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="id_actividad" class="form-labelUsr4">Id actividad</label>
                                            <input type="text" class="TextBoxUsrReadOnly w-100 H-50 text-center" id="id_actividad" disabled="" >
                                        </div>
                                        <div class="col-8 mb-1 FormUsr FontMsg mt-3">
                                            <label for="nombre_actividad" class="form-labelUsr4">Actividad</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="nombre_actividad" >
                                        </div>
                                        <div class="col-2 mb-1 FormUsr FontMsg mt-3">
                                            <label for="claveindicador_actividad" class="form-labelUsr4">Clave indicador</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="claveindicador_actividad" disabled="" >
                                        </div>
                                        <div class="col-10 mb-1 FormUsr FontMsg mt-3">
                                            <label for="nombreindicar_actividad" class="form-labelUsr4">Nombre del indicador</label>
                                            <textarea {{ $disabled }}  class="TextBoxUsr w-100 H-50 contador-letras" id="nombreindicar_actividad" required data-maxlength="200" rows="2"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblContIndicadorAct" class="LabelContador me-4">0/30</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="descripcionformula_actividad" class="form-labelUsr4">Descripción de la fórmula</label>
                                            <textarea {{ $disabled }}  class="TextBoxUsr w-100 H-50" id="descripcionformula_actividad" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable1_actividad" class="form-labelUsr4">Variable 1 (V1)</label>
                                            <textarea {{ $disabled }}  class="TextBoxUsr w-100" id="variable1_actividad" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable2_actividad" class="form-labelUsr4">Variable 2 (V2)</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable2_actividad" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1 FormUsr FontMsg mt-3">
                                            <label for="variable3_actividad" class="form-labelUsr4">Método de cálculo</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100" id="variable3_actividad" required maxlength="300" rows="5"></textarea>
                                        </div>
                                        <div class="col-3 mb-1">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="select_unidadmedida_actividad" class="form-label">Unidad de medida</label>
                                                    <select {{ $disabled }} id="select_unidadmedida_actividad" class="selectpicker unidad-medida show-tick form-control" data-tipo="actividad" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                        <option value="-">-</option>
                                                        <option value="PORCENTAJE">PORCENTAJE</option>
                                                        <option value="ABSOLUTO">ABSOLUTO</option>
                                                    </select>
                                                </div>
                                                <div id="d-descripcionunidadmedida_actividad" class="col-12 d-none">
                                                    <label for="descripcionunidadmedida_actividad" class="form-label">Descripción</label>
                                                    <input {{ $disabled }} type="text" class="form-control" id="descripcionunidadmedida_actividad">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 mb-1">
                                            <label for="ejecerciciofisca_actividad" class="form-label">Ejercicio fiscal:</label>
                                            <select  id="ejecerciciofisca_actividad" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                            </select>
                                        </div>
                                        <div class="col-3 mb-1">
                                            <label for="lineabase_actividad1" class="form-label">Línea base</label>
                                            <input type="text" disabled class="form-control" id="lineabase_actividad1">
                                        </div>
                                        <div class="col-3 mb-1">
                                            <label for="lineabaseV1_actividad" class="form-label">V1</label>
                                            <input type="text" class="form-control money" id="lineabaseV1_actividad">
                                        </div>
                                        <div class="col-3 mb-1">
                                            <label for="lineabaseV2_actividad" class="form-label">V2</label>
                                            <input type="text" class="form-control money" id="lineabaseV2_actividad">
                                        </div>
                                        <div class="col-2 mb-1 FormUsr FontMsg mt-3">
                                            <label for="metaanual_actividad" class="form-labelUsr4">Meta anual</label>
                                            <input type="text" class="form-control" id="metaanual_actividad" disabled="" >
                                        </div>
                                        <div class="col-2 mb-1">
                                            <label for="selectfrecuencia_actividad" class="form-label">Frecuencia</label>
                                            <select id="selectfrecuencia_actividad" class="selectpicker select-frecuencia show-tick form-control" data-tipo="actividad" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="TRIMESTRAL">TRIMESTRAL</option>
                                            </select>
                                        </div>
                                        <!--div class="col-4 d-none d-metasemestral-actividad FormUsr FontMsg mt-3">
                                            <label for="metasemestral1_actividad" class="form-labelUsr4">Meta semestral I</label>
                                            <input type="text" class="form-control" id="metasemestral1_actividad">
                                        </!--div>
                                        <div-- class="col-4 d-none d-metasemestral-actividad FormUsr FontMsg mt-3">
                                            <label for="metasemestral2_actividad" class="form-labelUsr4">Meta semestral II</label>
                                            <input type="text" class="form-control" id="metasemestral2_actividad" disabled="" >
                                        </div-->
                                        <div class="col-2 d-none d-trimestral-actividad FormUsr FontMsg mt-3">
                                            <label for="metatrimestral1_actividad" class="form-labelUsr4">Meta trimestral I</label>
                                            <input type="text" class="form-control" id="metatrimestral1_actividad" disabled="" >
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad FormUsr FontMsg mt-3">
                                            <label for="metatrimestral2_actividad" class="form-labelUsr4">Meta trimestral II</label>
                                            <input type="text" class="form-control" id="metatrimestral2_actividad" disabled="" >
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad FormUsr FontMsg mt-3">
                                            <label for="metatrimestral3_actividad" class="form-labelUsr4">Meta trimestral III</label>
                                            <input type="text" class="form-control" id="metatrimestral3_actividad" disabled="" >
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad FormUsr FontMsg mt-3">
                                            <label for="metatrimestral4_actividad" class="form-labelUsr4">Meta trimestral IV</label>
                                            <input type="text" class="form-control" id="metatrimestral4_actividad" disabled="" >
                                        </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2 FormUsr FontMsg mt-3">
                                                <label for="variableV1_actividad" class="form-labelUsr4">V1</label>
                                                <input type="text" class="TextBoxUsr w-100 H-50" id="variableV1_actividad" disabled="" >
                                            </div>
                                        <div class="col-2">
                                            
                                        </div>
                                        <!--div class="col-4 d-none d-metasemestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V1D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral1V1D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V1A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" id="metasemestral1V1A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </!--div>
                                        <div-- class="col-4 d-none d-metasemestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V1D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral2V1D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V1A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" id="metasemestral2V1A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div-->
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V1D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral1V1D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V1A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral1V1A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V1D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral2V1D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V1A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral2V1A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V1D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral3V1D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V1A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral3V1A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V1D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral4V1D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V1A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral4V1A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row mb-1">
                                        <div class="col-2 FormUsr FontMsg mt-3">
                                            <label for="variableV2_actividad" class="form-labelUsr4">V2</label>
                                            <input type="text" class="TextBoxUsr w-100 H-50" id="variableV2_actividad" disabled="" >
                                        </div>
                                        <div class="col-2">
                                            <div class="row d-flex align-items-center justify-content-center">
                                                <input type="button" id="checkDenominadorFijo_actividad" class="DenominadorFijoInactivo denominadorfijo ms-2" data-tipo="actividad">
                                            </div>
                                            <div class="row">
                                                <p class="LetretosFont text-center">Activar en caso de que el denominador sea una constante.</p>
                                                <input type="hidden" id="clicDenominador_actividad" value="0" >
                                            </div>
                                        </div>
                                        <!--div class="col-4 d-none d-metasemestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V2D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral1V2D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral1V2A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" id="metasemestral1V2A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </!--div>
                                        <div-- class="col-4 d-none d-metasemestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V2D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control money" id="metasemestral2V2D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <label for="metasemestral2V2A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-11">
                                                            <input type="text" class="form-control" id="metasemestral2V2A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div-->
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V2D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral1V2D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral1V2A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral1V2A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V2D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral2V2D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral2V2A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral2V2A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V2D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral3V2D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral3V2A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral3V2A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 d-none d-trimestral-actividad">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V2D_actividad" class="form-label">D:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control money" id="metatrimestral4V2D_actividad" onkeypress="return justNumbers(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <label for="metatrimestral4V2A_actividad" class="form-label" >A:</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" class="form-control" id="metatrimestral4V2A_actividad" disabled="" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                                <div id="actividadesdos" class="d-none">
                                    <div class="row">
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="mediosverificacion_actividad" class="form-labelUsr4">Medios de Verificación</label>
                                            <input {{ $disabled }}  type="text" class="TextBoxUsr w-100 H-50" id="mediosverificacion_actividad">
                                        </div>
                                        <div class="col-6 mb-1 FormUsr FontMsg mt-3">
                                            <label for="fuentesinformacion_actividad" class="form-labelUsr4">Fuentes de Información</label>
                                            <input {{ $disabled }} type="text" class="TextBoxUsr w-100 H-50" id="fuentesinformacion_actividad">
                                        </div>
                                        <div class="col-12 mb-1 FormUsr FontMsg mt-3">
                                            <label for="supuestos_actividad" class="form-labelUsr4">Supuestos</label>
                                            <textarea {{ $disabled }} class="TextBoxUsr w-100 H-50" id="supuestos_actividad" required maxlength="300" rows="2"></textarea>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_sentidoindicador_actividad" class="form-labelUsr3">Sentido del indicador</label>
                                            <select {{ $disabled }} id="select_sentidoindicador_actividad" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ASCENDENTE">ASCENDENTE</option>
                                                <option value="DESCENDENTE">DESCENDENTE</option>
                                                <option value="NORMAL">NORMAL</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_tipoindicador_actividad" class="form-labelUsr3">Tipo de indicador</label>
                                            <select {{ $disabled }} id="select_tipoindicador_actividad" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="ESTRATÉGICO">ESTRATÉGICO</option>
                                                <option value="GESTIÓN">GESTIÓN</option>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="select_dimensionindicador_actividad" class="form-labelUsr3">Dimensión del indicador</label>
                                            <select {{ $disabled }} id="select_dimensionindicador_actividad" class="TextBoxUsr select-mir w-100" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                                <option value="-">-</option>
                                                <option value="CALIDAD">CALIDAD</option>
                                                <option value="ECONOMÍA">ECONOMÍA</option>
                                                <option value="EFICACIA">EFICACIA</option>
                                                <option value="EFICIENCIA">EFICIENCIA</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="col-12 text-center">
                                            ANÁLISIS CREMAA
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label">Claridad</label>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="claridad_actividad" id="claridad_actividadSi" value="S">
                                                <label class="form-check-label" for="claridad_finSi">Si</label>
                                            </div>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="claridad_actividad" id="claridad_actividadNo" value="N">
                                                <label class="form-check-label" for="claridad_actividadNo">No</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label">Relevancia</label>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="relevancia_actividad" id="relevancia_actividadSi" value="S">
                                                <label class="form-check-label" for="relevancia_actividadSi">Si</label>
                                            </div>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="relevancia_actividad" id="relevancia_actividadNo" value="N">
                                                <label class="form-check-label" for="relevancia_actividadNo">No</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label">Economía</label>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="economia_actividad" id="economia_actividadSi" value="S">
                                                <label class="form-check-label" for="economia_finSi">Si</label>
                                            </div>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="economia_actividad" id="economia_actividadNo" value="N">
                                                <label class="form-check-label" for="economia_actividadNo">No</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label">Monitoreable</label>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="monitoreable_actividad" id="monitoreable_actividadSi" value="S">
                                                <label class="form-check-label" for="monitoreable_actividadSi">Si</label>
                                            </div>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="monitoreable_actividad" id="monitoreable_actividadNo" value="N">
                                                <label class="form-check-label" for="monitoreable_actividadNo">No</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label">Adecuado</label>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="adecuado_actividad" id="adecuado_actividadSi" value="S">
                                                <label class="form-check-label" for="adecuado_actividadSi">Si</label>
                                            </div>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="adecuado_actividad" id="adecuado_actividadNo" value="N">
                                                <label class="form-check-label" for="adecuado_actividadNo">No</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label">Aporte marginal</label>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="aportemarginal_actividad" id="aportemarginal_actividadSi" value="S">
                                                <label class="form-check-label" for="aportemarginal_finSi">Si</label>
                                            </div>
                                            <div class="form-check">
                                                <input {{ $disabled }} class="form-check-input" type="radio" name="aportemarginal_actividad" id="aportemarginal_actividadNo" value="N">
                                                <label class="form-check-label" for="aportemarginal_actividadNo">No</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-12 mb-3">
                                            <label for="select_unidadresponsablereportar_actividad" class="form-label">Unidad responsable de reportar el indicador</label>
                                            <select disabled id="select_unidadresponsablereportar_actividad" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionindicador_actividad" class="form-labelUsr4">Descripción Indicador</label>
                                            <textarea  class="TextBoxUsr w-100  contador-letras" id="descripcionindicador_actividad" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblIndicaFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripcionnumerador_actividad" class="form-labelUsr4">Descripción Numerador</label>
                                            <textarea  class="TextBoxUsr w-100  contador-letras" id="descripcionnumerador_actividad" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblIndicaFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3 FormUsr FontMsg mt-3">
                                            <label for="descripciondenominador_actividad" class="form-labelUsr4">Descripción Denominador</label>
                                            <textarea  class="TextBoxUsr w-100  contador-letras" id="descripciondenominador_actividad" required data-maxlength="300" rows="6"></textarea>
                                            <div class="position-absolute bottom-0 end-0">
                                                <label id="lblIndicaFin" class="LabelContador me-4">0/240</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-auditoriacarga" role="tabpanel" aria-labelledby="tab-auditoriacarga" tabindex="0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="table-auditoriacarga" class="table table-striped table-hover">
                                                <thead>
                                                    <tr class="table-header text-center">
                                                        <th>Objetivo MIR</th>
                                                        <th>Elemento</th>
                                                        <th>Observación</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-auditoriaformulas" role="tabpanel" aria-labelledby="tab-auditoriaformulas" tabindex="0">
                                <div class="row">
                                    <div class="col-12 text-end my-3">
                                        <button id="BtnEliminarLogFormula" class="BotonesGrid2">Eliminar Observación</button>  {{-- btn btn-outline-danger d-none --}}
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="table-auditoriaformulas" class="table table-striped table-hover">
                                                <thead>
                                                    <tr class="table-header text-center">
                                                        <th width="5%"></th>
                                                        <th width="15%">Objetivo MIR</th>
                                                        <th width="20%">Elemento</th>
                                                        <th width="20%">Observación</th>
                                                        <th width="20%">Valor Original</th>
                                                        <th width="20%">Valor Modificado</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="modal-footer">
                        <div class="row" style="width: 100%">
                                <div class="col">
                                    <button 
                                        type="button" 
                                        class="btn btn-info"
                                        id="BtnEnviar">
                                        Enviar a revisión
                                    </button>

                                    <button 
                                        type="button" 
                                        class="btn btn-success"
                                        id="BtnEnviar">
                                        Registrar
                                    </button>

                                    <button 
                                        type="button" 
                                        class="btn btn-danger"
                                        id="BtnEnviar">
                                        Rechazar
                                    </button>
                                </div>
                                <div class="col">
                                    <div class="alert alert-warning" id="lbl-errores" >
                                        Algunos campos contienen errores, por favor verifique la información capturada e intente nuevamente
                                    </span>
                                </div>
                                <div class="col" style="display:flex;justify-content:flex-end">
                                    <input type="button" id="BtnValidar" 
                                        class="buttonOutlineSucces150 text-capitalize" 
                                        value="Validar Fórmulas" style="display:none">

                                    <button 
                                        type="button" 
                                        class="btn btn-primary"
                                        id="BtnGuardar">
                                        Guardar
                                    </button>
                                    <!-- 
                                    <button 
                                        type="button" 
                                        class="buttonOutlineSucces150"
                                        id="BtnEnviar">
                                        @if ($tipoUsuario <> 1) 
                                            <span id="lblBotonEnviar">Enviar a registro</span>
                                        @else
                                            <span id="lblBotonEnviar">Registrar</span>
                                        @endif
                                    </button> -->

                                    <button type="button" 
                                        class="btn btn-light" 
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@include('includes._partialFooter')

<script src="js/Repository.js"></script>
<script src="js/MirLlamadas.js"></script>
<script src="js/MirMetas.js"></script>
<script src="js/MirResponse.js"></script>
<script src="js/MirGuardar.js"></script>
<script src="js/Mir.js"></script>


</body>

</html>