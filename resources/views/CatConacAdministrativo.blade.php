@php
   $view = "CONAC Administrativo";
   $img = "icono administrativa.svg";
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
        <div class="row">
            <div class="col-2 MenuLeft FontNavega ms-5">
                <div id="opcAdministrativo" class="grupo-catalogos">
                    <div class="row mt-1">
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
                            <a href="/Secretarias" class="d-flex align-items-center justify-content-center">
                                <img id="icon-cat-secretaria" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-secretaria', '/img/LogoSecretarias.svg')" onmouseout="img_out('icon-cat-secretaria', 'img/icono Secretarias off.svg')" src="img/icono Secretarias off.svg" alt="Logo de tesorería de Nuevo León" width="50" height="50">
                            </a>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <h6 class="FontNavega"><b>Secretarías</b></h6>
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
                </div>               
            </div>  <!-- ***END COL-2 -->


            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <div class="table-response mb-4">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="20%">Id conac</th>
                                        <th scope="col" width="80%">Descripción</th>
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
        </div>   <!-- END ROW -->
    </section>
</div>

@include('includes._partialFooter')

<script src="/js/Repository.js"></script>
<script src="/js/ConacAdministrativo.js"></script>
<script src="/js/CatConacAdm.js"></script>


</body>

</html>