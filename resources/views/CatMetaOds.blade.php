@php
   $view = "Meta ODS";
   $img = "meta ODS.svg";
@endphp

@include('includes._partialHeader')

<link rel="stylesheet" type="text/css" href="/css/EstilosPbR.css" />

<style>
    .input-background-white {
        background-color: white;
    }
</style>

<div class="mt-3">
    @include('includes._partialBreadcrumbCatalogos')

    <section class="container-fluid section">
        <div class="row ms-5">
        <div class="col-2">
                <div class="row mt-1">
                    <div class="col-md-1">
                        <a href="/Catalogos" class="d-flex align-items-center justify-content-center">
                            <img id="icon-regresarPlan" onmouseover="img_over('icon-regresarPlan', '/img/icono regresar activo.svg')" onmouseout="img_out('icon-regresarPlan', '/img/icono regresar.svg')" src="img/icono regresar.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Regresar</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-1">
                        <a href="/Eje" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-eje" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-eje', '/img/icono eje.svg')" onmouseout="img_out('icon-cat-eje', 'img/icono eje off.svg')" src="img/icono eje off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Eje</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="/Tema" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-tema" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-tema', '/img/icono tema.svg')" onmouseout="img_out('icon-cat-tema', 'img/icono tema off.svg')" src="img/icono tema off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Tema</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="/Objetivo" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-objetivo" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-objetivo', '/img/icono objetivo.svg')" onmouseout="img_out('icon-cat-objetivo', 'img/icono objetivo off.svg')" src="img/icono objetivo off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Objetivo</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="/Estrategia" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-estrategia" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-estrategia', '/img/icono estrategias.svg')" onmouseout="img_out('icon-cat-estrategia', 'img/icono estrategia off.svg')" src="img/icono estrategia off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Estrategia</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="/Catalogos" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-lineas-accion" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-lineas-accion', '/img/icono lineas de accion.svg')" onmouseout="img_out('icon-cat-lineas-accion', 'img/icono lineas de accion off.svg')" src="img/icono lineas de accion off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Líneas de acción</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="/Ods" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-ods" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-ods', '/img/icono ODS.svg')" onmouseout="img_out('icon-cat-ods', 'img/icono ODS off.svg')" src="img/icono ODS off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>ODS</b></h6>
                        </div>
                    </div>
                </div>
            </div>  <!-- ***END COL-2 -->

            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="select_ods" class="form-label">ODS</label>
                                <select id="select_ods" class="selectpicker show-tick form-control border" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        @include('includes._partialBotonesAccion')
                        <!-- Botones de accion -->
                        <div class="table-response mt-4">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="10%">Id ODS</th>
                                        <th scope="col" width="10%">Id meta ODS</th>
                                        <th scope="col" width="80%">Id conac funcional</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>    
            </div>
            <div class="col-2"></div>
        </div>
    </section>

    <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="form_modal" autocomplete="off" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_accion"></span> meta ODS</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="id_ods" class="form-label">Id ODS</label>
                                <input type="text" class="form-control" id="id_ods" disabled style="background: white;">
                            </div>
                            <div class="col-md-6">
                                <label for="id_metaods" class="form-label">Id meta ODS</label>
                                <input type="text" class="form-control" id="id_metaods" maxlength="2" required>
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control input-bold" id="descripcion" required maxlength="200" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" id="BtnGuardarSecretaria" class="btn btn-primary" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes._partialFooter')
<script src="/js/Repository.js"></script>
<script src="/js/MetaOds.js"></script>

</body>

</html>