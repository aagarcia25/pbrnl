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

<div class="Margin-Top">
    @include('includes._partialBreadcrumbCatalogos')

    <section class="container section">
        <div class="row">
            <div class="col-lg-12">
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