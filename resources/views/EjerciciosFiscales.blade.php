@php
   $view = "Ejercicios fiscales";
   $img = "icono programas presupuestarios.svg";
@endphp

@include('includes._partialHeader')

  <link rel="stylesheet" type="text/css" href="css/EstilosPbR.css" />


<div class="mt-3" ng-app="pbrApp" ng-controller="ejerciciosFiscalesController as vm">
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
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        
                        <!-- Botones de accion -->
                        <div class="d-flex flex-row-reverse bd-highlight mt-4">
                            <div class="p-2 bd-highlight">
                                <button type="button" 
                                    ng-click="vm.btnAgregarEF_click()"
                                    id="BtnAgregarEF" 
                                    class="btn button-crud"><i class="bi bi-trash"></i> Nuevo</button>
                            </div>
                            <div class="p-2 bd-highlight">
                                
                            </div>
                        </div>
                        <!-- Botones de accion -->
                        <div class="table-response mt-4">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="5em">Ejercicio</th>
                                        <th scope="col" >Contenido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="e in vm.ejercicios">
                                        <td>
                                            <% e.Id %>
                                        </td>
                                        <td>
                                            <% e.Contenido %>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
    
            </div>
        </div>
    </section>

    <div id="ModalNuevoEjercicioFiscal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id"></input>
                <div class="modal-header">
                    <h5 class="modal-title">Agregar ejercicio fiscal</h5>
                </div>
                <form id="form_ef" autocomplete="off" ng-submit="vm.guardarEF()">
                    <div class="modal-body">
                        <div class="row g-3">
                            <label for="txt_ejercicio" class="form-label">Ejercicio:</label>
                            <input id="txt_ejercicio" 
                                type="number" min="2000" max="2100" 
                                ng-model="vm.ejercicio.ejercicio_fiscal"
                                class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"  data-dismiss="modal" class="buttonOutlineSucces">Guardar</button>
                        <button type="button" class="buttonCloseModal" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('includes._partialFooter')
<script src="js/Repository.js"></script>
<script src="js/EjerciciosFiscales.js"></script>

</body>

</html>