@php
   $view = "Administrar Usuarios";
   $img = "AdminUsuariosInt.svg";
@endphp

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
@include('includes._partialHeader')
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/EstilosPbR.css') }}" />

<div id="MenuLeft" class="mt-5 ms-2">
    <div class="row">
        <div class="col-md-1">
            <div class="card bg-transparent border border-0 ms-4">
                <a href="/MenuAdmin">
                    <img class="IconoRegresar ms-4" alt="" src="img/icono regresar.svg" style="width: 35%" />
                </a>                    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="card bg-transparent border border-0 text-center">
                <label class="FontNavega fw-bold">Regresar</label>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-1">
            <div class="card bg-transparent border border-0 ms-4">
                <a href="/Roles">
                    <img class="IconoRolUsr ms-4" alt="" src="img/dummy.png"/>
                </a>                    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="card bg-transparent border border-0 text-center" >
                <label class="FontNavega fw-bold">Administrar</br>Roles</label>
            </div>
        </div>
    </div>
</div>

<div class="container Margin-TopUsrs">
    @include('includes._partialBreadcrumbAdministracion')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Botones de accion -->
                        @include('includes._partialBreadcrumbAccionesUsuarios')
                        <!-- Botones de accion -->
                        <div class="table-responsive-sm">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header">
                                        <th scope="col" width="10%" class="text-center">Id usuario</th>
                                        <th scope="col" width="25%" class="text-center">Nombre</th>
                                        <th scope="col" width="25%" class="text-center">Apellido paterno</th>
                                        <th scope="col" width="20%" class="text-center">Apellido materno</th>
                                        <th scope="col" width="10%" class="text-center">Activo</th>
                                        <th scope="col" width="10%" class="text-center">Notificado</th>
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
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <form id="form_modal" autocomplete="off" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id"></input>
                    <div class="modal-header TituloMsg">
                        <h5 class="modal-title TituloMsg"><span id="modal_accion"></span> usuario</h5>
                    </div>
                    <div class="modal-body FontMsg">
                        <div class="row mb-2 g-3 align-items-center">
                            <div class="col-md-2 FormUsrDis">
                                <input type="text" class="form-control TextBoxUsrDis text-uppercase" id="id_usuario" style="background: white;" readonly>
                                <label for="id_usuario" class="form-labelUsrDis">Id Usuario <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-2 FormUsr">
                                <input type="text" class="form-control TextBoxUsr text-uppercase calc_id" id="nombre_usuario" maxlength="45" required>
                                <label for="nombre_usuario" class="form-labelUsr">Nombre <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-3 FormUsr">
                                <input type="text" class="form-control TextBoxUsr text-uppercase calc_id" id="appaterno_usuario" maxlength="45" required>
                                <label for="appaterno_usuario" class="form-labelUsr">Apellido Paterno <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-3 FormUsr">
                                <input type="text" class="form-control TextBoxUsr text-uppercase calc_id" id="apmaterno_usuario" maxlength="45" required>
                                <label for="apmaterno_usuario" class="form-labelUsr">Apellido Materno <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-2 FontMsg ">
                                <label class="toggle ">
                                    <input id="check_Activo" class="toggle-checkbox" type="checkbox">
                                    <div class="toggle-switch "></div>
                                    <span class="toggle-label text-bold">Activo</span>
                                </label>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 align-items-center mt-3">
                            <div class="col-md-4 FormUsr">
                                <input type="text" class="form-control fecha TextBoxUsr calc_id" id="fechanacimiento_usuario">
                                <label for="fechanacimiento_usuario" class="form-labelUsr">Fecha de Nacimiento</label>
                            </div>
                            <div class="col-md-4 FormUsr">
                                <input type="text" class="form-control TextBoxUsr text-uppercase " id="rfc_usuario" maxlength="13" required>
                                <label for="rfc_usuario" class="form-labelUsr">RFC <span class="text-red">*</span></label>
                            </div>
                            <div class="col-md-4 FormUsr">
                                <input type="text" class="form-control TextBoxUsr" id="correo_usuario" maxlength="45" required>
                                <label for="correo_usuario" class="form-labelUsr">Correo Electrónico <span class="text-red">*</span></label>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 align-items-center mt-3">
                            <div class="col FormUsr">
                                <input type="text" class="form-control TextBoxUsr" id="telefono_usuario" maxlength="20">
                                <label for="telefono_usuario" class="form-labelUsr">Teléfono de Oficina o Contacto</label>
                            </div>
                            <div class="col FormUsr">
                                <input type="text" class="form-control TextBoxUsr" id="movil_usuario" maxlength="20">
                                <label for="movil_usuario" class="form-labelUsr">Teléfono Móvil</label>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 align-items-center mt-3">
                            <div class="col-md-2 FormUsrDis FontMsg">
                                <input type="text" class="form-control TextBoxUsrDis bg-white" id="secretaria_usuario" maxlength="3" disabled>
                                <label for="secretaria_usuario" class="form-labelUsrDis">Id Secretaría</label>
                            </div>
                            <div class="col-md-10 FormUsr FontMsg">
                                <label for="select_secretaria" class="form-labelUsr3">Descripción Secretaría</label>
                                <select id="select_secretaria" class="selectpicker show-tick form-control TextBoxUsr" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="5" data-live-search="true" data-actions-box="true">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 align-items-center mt-3">
                            <div class="col-md-2 FormUsrDis FontMsg">
                                <input type="text" class="form-control TextBoxUsrDis bg-white" id="ua_usuario" maxlength="7" disabled>
                                <label for="ua_usuario" class="form-labelUsrDis">Id UA</label>
                            </div>
                            <div class="col-md-10 FormUsr FontMsg">
                                <label for="select_ua" class="form-labelUsr3">Descripción Unidad Administrativa</label>
                                <select id="select_ua" class="selectpicker show-tick form-control TextBoxUsr" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="5" data-live-search="true" data-actions-box="true" data-window-padding="top">
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 align-items-center mt-3">
                            <div class="col FormUsr FontMsg">
                                <input type="text" class="form-control TextBoxUsr text-uppercase " id="puesto_usuario" maxlength="100" required>
                                <label for="puesto_usuario" class="form-labelUsr">Puesto</label>
                            </div>
                        </div>
                        <div class="row mt-2 mb-2 g-3 align-items-center">
                            <div class="col-3 FormUsr FontMsg">
                                <label for="select_roles" class="form-labelUsr3">Rol</label>
                                <select id="select_roles" class="selectpicker show-tick form-control TextBoxUsr" title="-" data-none-results-text="No se encontraron resultados de {0}" data-show-tick="true" data-size="5" data-live-search="true" data-actions-box="true">
                                </select>
                            </div>
                            <div class="col-2 ">
                                <label class="toggle">
                                    <input id="check_CatalogoPbR" class="toggle-checkbox" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label text-bold">Catálogo PbR</span>
                                </label>
                            </div>
                            <div class="col-4">
                                <label class="toggle">
                                    <input id="check_Clasificacion" class="toggle-checkbox" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label text-bold">Clasificación Programática NL</span>    
                                </label>
                            </div>
                            <div class="col-3">
                                <label class="toggle">
                                    <input id="check_Mir" class="toggle-checkbox" type="checkbox">
                                    <div class="toggle-switch"></div>
                                    <span class="toggle-label text-bold">Administrar MIR</span>
                                </label>
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
<script src="{{ asset('/js/Repository.js') }}"></script>
<script src="/js/Usuarios.js"></script>

</body>

</html>