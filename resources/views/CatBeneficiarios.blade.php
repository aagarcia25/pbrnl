@php
   $view = "Catálogo de Beneficiarios";
   $img = "icono beneficiarios.svg";
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
                                <label for="select_TipoBeneficiario" class="form-label">Tipo de Beneficiario</label>
                                <select id="select_TipoBeneficiario" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="d-flex align-items-start justify-content-start">
                                <div class="p-2 bd-highlight">
                                    <button type="button" id="BtnAgregarTipoBeneficiario" class="btn button-crud BotonesGrid2"><i class="bi bi-trash"></i>Agregar tipo beneficiario</button>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <button type="button" id="BtnEditarTipoBeneficiario" class="btn button-crud BotonesGrid2"><i class="ri-edit-2-fill"></i>Editar tipo beneficiario</button>
                                </div>
                            </div>                            
                        </div>
                        <!-- Botones de accion -->
                        @include('includes._partialBotonesAccion')
                        <!-- Botones de accion -->
                        <div class="table-response mt-2">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="10%">Id Beneficiario</th>
                                        <th scope="col" width="20%">Tipo Beneficiario</th>
                                        <th scope="col" width="70%">Población o Área de Enfoque</th>
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
                        <h5 class="modal-title"><span id="modal_accion"></span> beneficiario</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="select_TipoBeneficiarioModal" class="form-label">Tipo de beneficiario</label>
                                <select id="select_TipoBeneficiarioModal" class="selectpicker show-tick form-control" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="id_Beneficiario" class="form-label">Id beneficiario</label>
                                <input type="text" class="form-control" id="id_Beneficiario" disabled style="background: white;" disabled>
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control input-bold" id="descripcion" required maxlength="200" rows="3"></textarea>
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

    <div class="modal fade" id="Modal_TipoBeneficiario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="form_modaltipobeneficiario" autocomplete="off" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_acciontipobeneficiario"></span> tipo de beneficiario</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="id_tipobeneficiario" class="form-label">Tipo beneficiario</label>
                                <input type="text" class="form-control" id="id_tipobeneficiario" required maxlength="2">
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion_tipobeneficiario" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion_tipobeneficiario" required maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@include('includes._partialFooter')

<script src="/js/Repository.js"></script>
<script src="/js/Beneficiarios.js"></script>

</body>


</html>