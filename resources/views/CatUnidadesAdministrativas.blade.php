@php
   $view = "Unidades administrativas";
   $img = "icono unidades admvas.svg";
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
                        @include('includes._partialBotonesAccion')
                        <!-- Botones de accion -->
                        <div class="table-response mt-4">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="10%">Id conac</th>
                                        <th scope="col" width="10%">Id secretaría</th>
                                        <th scope="col" width="10%">Id UA</th>
                                        <th scope="col" width="60%">Descripción</th>
                                        <th scope="col" width="10%">Id conac funcional</th>
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
                        <h5 class="modal-title"><span id="modal_accion"></span> unidad administrativa</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="id_conacadmin" class="form-label">Id conac administrativo</label>
                                <input type="text" class="form-control" id="id_conacadmin" disabled style="background: white;">
                            </div>
                            <div class="col-md-4">
                                <label for="id_secretaria" class="form-label">Id secretaría</label>
                                <input type="text" class="form-control" id="id_secretaria" disabled style="background: white;">
                            </div>
                            <div class="col-md-4">
                                <label for="id_ua" class="form-label">Id UA</label>
                                <input type="text" class="form-control" id="id_ua" maxlength="45" required>
                            </div>
                            <div class="col-md-12">
                                <label for="id_conacfuncional" class="form-label">Id conac funcional</label>
                                <select id="id_conacfuncional" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
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
<script src="/js/UnidadesAdministrativas.js"></script>

</body>

</html>