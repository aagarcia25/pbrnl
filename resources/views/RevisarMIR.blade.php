@php
   $view = "Revisar MIR";
   $img = "icono beneficiarios.svg";
@endphp

 @include('includes._partialHeader')

<link rel="stylesheet" type="text/css" href="/css/EstilosPbR.css" />

<style>
    .input-background-white {
        background-color: white;
    }
</style>

<div id="MenuLeft" class="mt-5 ms-5">
    <div class="row">
        <div class="col-md-1">
            <div class="card bg-transparent border border-0">
                <a href="/MenuMIR">
                    <img class="IconoRegresar ms-2" alt="" src="img/icono regresar.svg" style="width: 30%" />
                </a>                    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="card bg-transparent border border-0">
                <label class="FontNavega fw-bold">Regresar</label>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- @include('includes._partialBreadcrumbCatalogos') -->
    <section class="section">
        <div class="row">
            <div class="col-md-1">
                <img class="LogoForm" alt="" src="img/icono_revisar_MIR.svg" />
            </div>
            <div class="col-md-10 align-items-start justify-content-start TituloCatalogo">
                <h2 class="TituloCatalogo">Revisar MIR</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-transparent border border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="select_Secretaria" class="form-label">Id Secretaría</label>
                                <select id="select_Secretaria" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="select_UnidadAdministrativa" class="form-label">Id Unidad Administrativa</label>
                                <select id="select_UnidadAdministrativa" class="selectpicker show-tick form-control" title="Seleccione..." data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="7" data-live-search="true" data-actions-box="true" required>
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
                            <!-- @include('includes._partialBotonesAccion') -->
                        <!-- Botones de accion -->
                        <div class="table-response mt-1">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="10%">CONAC</th>
                                        <th scope="col" width="10%">Consecutivo</th>
                                        <th scope="col" width="35%">Descripción Programa</th>
                                        <th scope="col" width="15%">Tipo Programa</th>
                                        <th scope="col" width="20%">Tipo de Beneficiario</th>
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
                                <label for="id_TipoBeneficiario" class="form-label">Id conac administrativo</label>
                                <input type="text" class="form-control" id="id_TipoBeneficiario" disabled style="background: white;">
                            </div>
                            <div class="col-md-4">
                                <label for="id_Beneficiario" class="form-label">Id secretaría</label>
                                <input type="text" class="form-control" id="id_Beneficiario" disabled style="background: white;">
                            </div>
                            <div class="col-md-12">
                                <label for="Poblacion" class="form-label">Descripción</label>
                                <textarea class="form-control input-bold" id="Poblacion" required maxlength="200" rows="3"></textarea>
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

<script src="/js/Repository.js"></script>
<script src="/js/CatBeneficiarios.js"></script>

</body>
<!-- @include('includes._partialFooter') -->

</html>