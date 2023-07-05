@php
   $view = "ODS";
   $img = "icono ODS.svg";
@endphp

@include('includes._partialHeader')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
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
                            <img id="icon-imgAdmin"src="img/icono Planeación.svg" alt="Logo de tesorería de Nuevo León" width="60" height="60">
                        </a>
                    </div>
                </div>    
                <div class="row mt-3">
                    <div class="col-md-1">
                        <a href="Catalogos" class="d-flex align-items-center justify-content-center">
                            <img id="icon-regresarPlan" onmouseover="img_over('icon-regresarPlan', '/img/icono regresar activo.svg')" onmouseout="img_out('icon-regresarPlan', '/img/icono regresar.svg')" src="img/icono regresar.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Regresar</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-1">
                        <a href="Eje" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-eje" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-eje', '/img/icono eje.svg')" onmouseout="img_out('icon-cat-eje', 'img/icono eje off.svg')" src="img/icono eje off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Eje</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="Tema" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-tema" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-tema', '/img/icono tema.svg')" onmouseout="img_out('icon-cat-tema', 'img/icono tema off.svg')" src="img/icono tema off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Tema</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="Objetivos" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-objetivo" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-objetivo', '/img/icono objetivo.svg')" onmouseout="img_out('icon-cat-objetivo', 'img/icono objetivo off.svg')" src="img/icono objetivo off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Objetivo</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="Estrategia" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-estrategia" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-estrategia', '/img/icono estrategias.svg')" onmouseout="img_out('icon-cat-estrategia', 'img/icono estrategia off.svg')" src="img/icono estrategia off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Estrategia</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="LineasAccion" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-lineas-accion" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-lineas-accion', '/img/icono lineas de accion.svg')" onmouseout="img_out('icon-cat-lineas-accion', 'img/icono lineas de accion off.svg')" src="img/icono lineas de accion off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Líneas de acción</b></h6>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">              
                    <div class="col-1">
                        <a href="MetaOds" class="d-flex align-items-center justify-content-center">
                            <img id="icon-cat-meta-ods" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-meta-ods', '/img/meta ODS.svg')" onmouseout="img_out('icon-cat-meta-ods', 'img/meta ODS off.svg')" src="img/meta ODS off.svg" width="50" height="50">
                        </a>
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <h6 class="FontNavega"><b>Meta ODS</b></h6>
                        </div>
                    </div>
                </div>
            </div>  <!-- ***END COL-2 -->
            <div class="col-8">
                <div class="container pagetitle mt-3">
                    <div class="row mb-3">
                        <div class="col-1">
                            <img id="icon-cat-ods" class="icon-cat-secretaria" src="/img/@php echo $img; @endphp" width="80" height="80">
                        </div>
                        <div class="col-11 mt-4">
                            <h1 class="TituloCatalogo">@php echo $view; @endphp</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Botones de accion -->
                        @include('includes._partialBotonesAccion')
                        <!-- Botones de accion -->
                        <div class="table-response">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="10%">Id ODS</th>
                                        <th scope="col" width="40%">Descripción corta</th>
                                        <th scope="col" width="50%">Descripción larga</th>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="form_modal" autocomplete="off" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_accion"></span> ODS</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="id_ods" class="form-label">Id ODS</label>
                                <input type="text" class="form-control" id="id_ods" required maxlength="3">
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion_corta" required maxlength="100">
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control input-bold" id="descripcion_larga" required maxlength="400" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="BtnGuardarOds" class="buttonOutlineSucces" value="Guardar">
                        <button type="button" class="buttonCloseModal" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes._partialFooter')
<script src="js/Repository.js"></script>
<script src="/js/Ods.js"></script>

</body>

</html>