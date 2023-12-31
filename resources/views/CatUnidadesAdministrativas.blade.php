@php
   $view = "Unidades Administrativas";
   $img = "icono unidades admvas.svg";
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
                            <a href="Catalogos" class="d-flex align-items-center justify-content-center">
                                <img id="icon-regresar" onmouseover="img_over('icon-regresar', 'img/icono regresar activo.svg')" onmouseout="img_out('icon-regresar', 'img/icono regresar.svg')" src="img/icono regresar.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>Regresar</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                    <div class="col-md-1">
                            <a href="ConacAdministrativo" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-admin" onmouseover="img_over('icon-cat-admin', 'img/icono administrativa.svg')" onmouseout="img_out('icon-cat-admin', 'img/icono CONAC administrativa off.svg')" src="img/icono CONAC administrativa off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>CONAC Administrativo</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a href="Secretarias" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-secretaria" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-secretaria', 'img/LogoSecretarias.svg')" onmouseout="img_out('icon-cat-secretaria', 'img/icono Secretarias off.svg')" src="img/icono Secretarias off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>Secretarías</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a href="ConacFuncional" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-funcional" class="icon-cat-funcional" onmouseover="img_over('icon-cat-funcional', 'img/icono funcional.svg')" onmouseout="img_out('icon-cat-funcional', 'img/icono CONAC funcional off.svg')" src="img/icono CONAC funcional off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>CONAC Funcional</b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-1">
                            <a href="ConacTipologia" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-tipologia" class="icon-cat-tipologia" onmouseover="img_over('icon-cat-tipologia', 'img/icono tipologia.svg')" onmouseout="img_out('icon-cat-tipologia', 'img/icono CONAC tipologia off.svg')" src="img/icono CONAC tipologia off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>CONAC Tipología</b></h6>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>  <!-- ***END COL-2 -->

            <div class="col-8">
                <div class="container pagetitle mt-3">
                    <div class="row mb-3">
                        <div class="col-1">
                            <img id="icon-cat-ods" class="icon-cat-secretaria" src="img/@php echo $img; @endphp" width="80" height="80">
                        </div>
                        <div class="col-11 mt-4">
                            <h1 class="TituloCatalogo">@php echo $view; @endphp</h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row DDLFont">
                                    <label for="select_secretaria" class="col-1 col-form-label col-form-label-sm DDLFont WLabel">Secretaría</label>
                                    <select id="select_secretaria" class="col-11 selectpicker show-tick form-control W95" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        @include('includes._partialBotonesAccion')
                        <!-- Botones de accion -->
                        <div class="table-response mt-2">
                            <table id="table" class="table table-striped table-hover ">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="10%">Id CONAC</th>
                                        <th scope="col" width="10%">Id Secretaría</th>
                                        <th scope="col" width="10%">Id UA</th>
                                        <th scope="col" width="60%">Descripción</th>
                                        <th scope="col" width="10%">Id CONAC Funcional</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
            <div class="col-8"></div>
        </div> <!-- ***END ROW -->
    </section>

    <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <form id="form_modal" autocomplete="off" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_accion"></span> Unidad Administrativa</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="id_conacadmin" class="form-label">Id CONAC Administrativo</label>
                                <input type="text" class="form-control" id="id_conacadmin" disabled style="background: white;">
                            </div>
                            <div class="col-md-2">
                                <label for="id_secretaria" class="form-label mt-4">Id Secretaría</label>
                                <input type="text" class="form-control" id="id_secretaria" disabled style="background: white;">
                            </div>
                            <div class="col-md-2">
                                <label for="id_ua" class="form-label mt-4">Id UA</label>
                                <input type="text" class="form-control" id="id_ua" maxlength="7" required>
                            </div>
                            <div class="col-md-6">
                                <label for="id_conacfuncional" class="form-label mt-4">Id CONAC Funcional</label>
                                <select id="id_conacfuncional" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control input-bold text-uppercase" id="descripcion" required maxlength="200" rows="3"></textarea>
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
<script src="js/Repository.js"></script>
<script src="js/UnidadesAdministrativas.js"></script>

</body>

</html>