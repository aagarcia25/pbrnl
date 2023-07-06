@php
   $view = "Programas Presupuestarios";
   $img = "icono programas presupuestarios.svg";
@endphp

@include('includes._partialHeader')

  <link rel="stylesheet" type="text/css" href="css/EstilosPbR.css" />

<style>
    .input-background-white {
        background-color: white;
    }
</style>

<div class="mt-3">
    {{-- @include('includes._partialBreadcrumbCatalogos') --}}

    <section class="container-fluid section">
        <div class="row">
            <div class="col-2 MenuLeft FontNavega ms-5">
                <div class="row mt-1">
                    <div class="col-md-1">
                        <a class="d-flex align-items-center justify-content-center">
                            <img id="icon-imgAdmin"src="img/icono Programático.svg" alt="Logo de tesorería de Nuevo León" width="60" height="60">
                        </a>
                    </div>
                </div>    
                <div class="row mt-3">
                    <div class="col-md-1">
                        <a href="Catalogos" class="d-flex align-items-center justify-content-center">
                            <img id="icon-regresarProg" onmouseover="img_over('icon-regresarProg', 'img/icono regresar activo.svg')" onmouseout="img_out('icon-regresarProg', 'img/icono regresar.svg')" src="img/icono regresar.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Regresar</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-1">
                        <a href="ActividadesInstitucionales" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-act-instituc" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-act-instituc', 'img/icono actividades institucionales.svg')" onmouseout="img_out('icon-cat-act-instituc', 'img/icono actividades institucionales off.svg')" src="img/icono actividades institucionales off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Actividades Institucionales Específicas</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-1">
                        <a href="ProgramasProyectosInversion" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-program-proyect" class="icon-cat-administrativas" onmouseover="img_over('icon-cat-program-proyect', 'img/icono proyectos de inversion.svg')" onmouseout="img_out('icon-cat-program-proyect', 'img/icono proyectos de inversion off.svg')" src="img/icono proyectos de inversion off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Programas y Proyectos de Inversión</b></h6>
                        </div>
                    </div>
                </div>
            </div>   <!-- ***END COL-2 -->
            <div class="col-8">
                <div class="container pagetitle mt-3">
                    <div class="row mb-3">
                        <div class="col-1">
                            <img id="icon-cat-ods" class="icon-cat-secretaria" src="img/@php echo $img; @endphp" width="80" height="80">
                        </div>
                        <div class="col-11">
                            <div class="row"">
                                <div class="col-12">
                                    <h1 class="TituloCatalogo mx-3">@php echo $view; @endphp</h1>
                                </div>
                                <div class="col-12">
                                    <h6 class="mx-3"><span id="contador_programas">0</span> PROGRAMAS - <span id="contador_componentes">0</span> COMPONENTES</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="select_secretaria" class="form-label">Secretaría</label>
                                <select id="select_secretaria" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        <div class="d-flex flex-row-reverse bd-highlight mt-4">
                            <div class="p-2 bd-highlight">
                                <button type="button" id="BtnActualizacionPP" class="btn button-crud"><i class="bi bi-trash"></i> Actualización PP</button>
                            </div>
                            <div class="p-2 bd-highlight">
                                <button type="button" id="BtnComponentes" class="btn button-crud"><i class="ri-edit-2-fill"></i> Componente</button>
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        <div class="table-response mt-4">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" class="d-none">Id Secretaria</th>
                                        <th scope="col" width="10%">Id Clasificación</th>
                                        <th scope="col" width="10%">Id Objetivo PED</th>
                                        <th scope="col" width="10%">Id Anticorrupción</th>
                                        <th scope="col" width="10%">Id Tipología</th>
                                        <th scope="col" width="10%">Consecutivo</th>
                                        <th scope="col" width="50%">Descripción del Programa</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id"></input>
                <div class="modal-header">
                    <h5 class="modal-title">Componentes del Programa Presupuetario</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="id_secretaria" class="form-label">Id Secretaría</label>
                            <input type="text" class="form-control" id="id_secretaria" disabled style="background: white;">
                        </div>
                        <div class="col-md-9">
                            <label for="descripcion_secretaria" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion_secretaria" disabled style="background: white;">
                        </div>
                        <div class="col-md-3">
                            <label for="id_clasificacion" class="form-label">Id Clasificación</label>
                            <input type="text" class="form-control" id="id_clasificacion" disabled style="background: white;">
                        </div>
                        <div class="col-md-7">
                            <input type="hidden" id="id_objetivo">
                            <label for="descripcion_objetivo" class="form-label">Id Objetivo PED</label>
                            <input type="text" class="form-control" id="descripcion_objetivo" disabled style="background: white;">
                        </div>
                        <div class="col-md-2">
                            <label for="id_anticorrupcion" class="form-label">Id Anticorrupción</label>
                            <input type="text" class="form-control" id="id_anticorrupcion" disabled style="background: white;">
                        </div>
                        <div class="col-md-5">
                            <label for="id_topologia" class="form-label">Id Tipología</label>
                            <input type="text" class="form-control" id="id_topologia" disabled style="background: white;">
                        </div>
                        <div class="col-md-2">
                            <label for="consecutivo" class="form-label">Consecutivo</label>
                            <input type="text" class="form-control" id="consecutivo" disabled style="background: white;">
                        </div>
                        <div class="col-md-5">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" disabled style="background: white;">
                        </div>
                        <div class="col-md-12 d-flex flex-row-reverse bd-highlight mt-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2 bd-highlight">
                                        <button type="button" id="BtnEditarComponente" class="btn button-crud"><i class="ri-edit-2-fill"></i> Editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-0">
                            <div class="table-response mt-4">
                                <table id="table_componentes" class="table table-striped table-hover">
                                    <thead>
                                        <tr class="table-header text-center">
                                            <th width="5%">Id UA</th>
                                            <th width="30%">Descripción UA</th>
                                            <th width="5%">Componentes</th>
                                            <th width="60%">Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div id="informacion_componente" class="col-md-12 d-none">
                            <hr>
                            <form id="form_componente" autocomplete="off" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="unidad_componente" class="form-label">Nueva unidad administrativa</label>
                                        <select id="unidad_componente" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="descripcion_componente" class="form-label">Nueva descripción</label>
                                        <input type="text" class="form-control" id="descripcion_componente" maxlength="300" required>
                                    </div>
                                    <input type="hidden" id="id_componente">
                                    <div class="col-12 mt-4 text-center">
                                        <input type="submit" class="buttonOutlineSucces" value="Guardar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="buttonCloseModal" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalActualizacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id"></input>
                <div class="modal-header">
                    <h5 class="modal-title">Actualización de programa presupuestario</h5>
                </div>
                <form id="form_pp" autocomplete="off">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="id_secretariapp" class="form-label">Id Secretaría</label>
                                <input type="text" class="form-control" id="id_secretariapp" disabled style="background: white;">
                            </div>
                            <div class="col-md-9">
                                <label for="select_secretariapp" class="form-label">Descripción</label>
                                <select id="select_secretariapp" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="id_clasificacionpp" class="form-label">Id Clasificación</label>
                                <input type="text" class="form-control" id="id_clasificacionpp" disabled style="background: white;">
                            </div>
                            <div class="col-md-7">
                                <label for="select_objetivopp" class="form-label">Id Objetivo PED</label>
                                <select id="select_objetivopp" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="id_anticorrupcionpp" class="form-label">Id Anticorrupción</label>
                                <select id="id_anticorrupcionpp" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                    <option value="S">S</option>
                                    <option value="N">N</option>    
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="select_topologiapp" class="form-label">Id Tipología</label>
                                <select id="select_topologiapp" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="consecutivopp" class="form-label">Consecutivo</label>
                                <input type="text" class="form-control" id="consecutivopp" disabled style="background: white;">
                            </div>
                            <div class="col-md-5">
                                <label for="descriptivopp" class="form-label">Consecutivo</label>
                                <input type="text" class="form-control" id="descriptivopp" disabled style="background: white;">
                            </div>
                            <div class="col-md-12">
                                <label for="descripcionpp" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcionpp" cols="6" required></textarea>
                            </div>
                            <input type="hidden" id="id_secretaria_real">
                            <input type="hidden" id="id_clasificacion_real">
                            <input type="hidden" id="select_objetivo_real">
                            <input type="hidden" id="id_anticorrupcion_real">
                            <input type="hidden" id="select_topologia_real">
                            <input type="hidden" id="consecutivo_real">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="buttonOutlineSucces">Guardar</button>
                        <button type="button" class="buttonCloseModal" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes._partialFooter')
<script src="js/Repository.js"></script>
<script src="js/ProgramasPresupuestales.js"></script>


</body>

</html>