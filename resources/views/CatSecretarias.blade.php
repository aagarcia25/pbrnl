@php
   $view = "Secretarias";
   $img = "LogoSecretarias.svg";
@endphp

@include('includes._partialHeader')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/css/EstilosPbR.css" />

<style>
    .input-background-white {
        background-color: white;
    }
</style>

<div class="mt-3">
    {{-- @include('includes._partialBreadcrumbCatalogos') --}}

    <section class="containerfluid section">
        <div class="row">
            <div class="col-2 MenuLeft FontNavega ms-5">
                <div id="opcAdministrativo" class="grupo-catalogos">
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a class="d-flex align-items-center justify-content-center">
                                <img id="icon-imgAdmin"src="img/icono Administrativo.svg" alt="Logo de tesorería de Nuevo León" width="60" height="60">
                            </a>
                        </div>
                    </div>    
                    <div class="row mt-3">
                        <div class="col-md-1">
                            <a href="/Catalogos" class="d-flex align-items-center justify-content-center">
                                <img id="icon-regresar" onmouseover="img_over('icon-regresar', '/img/icono regresar activo.svg')" onmouseout="img_out('icon-regresar', '/img/icono regresar.svg')" src="img/icono regresar.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>Regresar</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a href="/ConacAdministrativo" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-admin" onmouseover="img_over('icon-cat-admin', '/img/icono administrativa.svg')" onmouseout="img_out('icon-cat-admin', '/img/icono CONAC administrativa off.svg')" src="img/icono CONAC administrativa off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>CONAC Administrativo</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a href="/UnidadesAdministrativas" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-unidades" class="icon-cat-administrativas" onmouseover="img_over('icon-cat-unidades', '/img/icono unidades admvas.svg')" onmouseout="img_out('icon-cat-unidades', '/img/icono unidades admvas off.svg')" src="img/icono unidades admvas off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>Unidades Administrativas</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a href="/ConacFuncional" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-funcional" class="icon-cat-funcional" onmouseover="img_over('icon-cat-funcional', '/img/icono funcional.svg')" onmouseout="img_out('icon-cat-funcional', '/img/icono CONAC funcional off.svg')" src="img/icono CONAC funcional off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>CONAC Funcional</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a href="/ConacTipologia" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-tipologia" class="icon-cat-tipologia" onmouseover="img_over('icon-cat-tipologia', '/img/icono tipologia.svg')" onmouseout="img_out('icon-cat-tipologia', '/img/icono CONAC tipologia off.svg')" src="img/icono CONAC tipologia off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>CONAC Tipología</b></h6>
                            </div>
                        </div>
                    </div>
                </div>  <!--  ***END ADMTIVO -->
            </div>

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
                            <table id="tableSecretarias" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="20%">Id Secretaría</th>
                                        <th scope="col" width="25%">Id CONAC</th>
                                        <th scope="col" width="55%">Descripción</th>
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
        </div> <!-- ***END ROW -->
    </section>

    <div class="modal fade" id="ModalSecretaria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="form_secretaria" autocomplete="off" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_accion"></span> Secretaría</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="id_secretaria" class="form-label">Id Secretaría</label>
                                <input type="text" class="form-control" id="id_secretaria" required maxlength="3">
                            </div>
                            <div class="col-md-6">
                                <label for="id_conac" class="form-label">Id CONAC</label>
                                <select id="id_conac" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control text-uppercase" id="descripcion" required maxlength="80">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="BtnGuardarSecretaria" class="buttonOutlineSucces" value="Guardar">
                        <button type="button" class="buttonCloseModal" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes._partialFooter')
<script src="/js/Repository.js"></script>
<script src="/js/Secretarias.js"></script>

</body>

</html>