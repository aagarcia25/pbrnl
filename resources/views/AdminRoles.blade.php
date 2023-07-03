@php
   $view = "Roles";
   $img = "icono rol usuario.svg";
@endphp

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
@include('includes._partialHeader')
<link rel="stylesheet" type="text/css" href="/css/EstilosPbR.css" />

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
                <a href="/Usuarios">
                    <img class="IconoAdminUsr ms-4" alt="" src="img/dummy.png"/>
                </a>                    
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="card bg-transparent border border-0 text-center" >
                <label class="FontNavega fw-bold">Administrar</br>Usuarios</label>
            </div>
        </div>
    </div>
</div>


<div class="container Margin-TopUsrs">
    @include('includes._partialBreadcrumbAdministracion')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-white CuadroAdminUser">
                    <div class="card-body">
                        <form id="form_roles" autocomplete="off">
                            <div class="row background rounded-1 mx-2 mt-3 CuadroBase01">
                                <div class="row my-3 mx-4 align-items-center BgRolWhite">
                                    <div class="col">
                                        <h6 class="text-bold">ADMINISTRACIÓN</h6>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_AdministracionAccesoTotal" class="toggle-checkbox RolChkBox" type="checkbox" style="width: 95%; height: 35px;">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Acceso total</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                                <div class="row my-3 mx-4 align-items-center BgRolWhite">
                                    <div class="col">
                                        <h6 class="text-bold">ENLACE PBR</h6>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_EnlaceEditar" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Editar</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_EnlaceEditarDatos" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Editar Datos</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row my-3 mx-4 align-items-center BgRolWhite">
                                    <div class="col">
                                        <h6 class="text-bold">CAPTURA</h6>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_CapturaAnadir" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Añadir</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_CapturaEditar" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Editar</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row my-3 mx-4 align-items-center BgRolWhite">
                                    <div class="col">
                                        <h6 class="text-bold">REVISIÓN</h6>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_RevisionAnadir" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Añadir</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_RevisionEditar" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Editar</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row my-3 mx-4 align-items-center BgRolWhite">
                                    <div class="col">
                                        <h6 class="text-bold">CAPTURA Y REVISIÓN</h6>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_CapturaRevisionAnadir" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Añadir</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_CapturaRevisionEditar" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Editar</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row my-3 mx-4 align-items-center BgRolWhite">
                                    <div class="col">
                                        <h6 class="text-bold">AUTORIZACIÓN</h6>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_AutorizacionAnadir" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Añadir</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="toggle">
                                            <input id="check_AutorizacionEditar" class="toggle-checkbox" type="checkbox">
                                            <div class="toggle-switch"></div>
                                            <span class="toggle-label text-bold">Editar</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mx-3 text-end">
                                <button type="submit" class="btn btn-guardar">Guardar</button>
                            </div>
                        </form>
                            
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('includes._partialFooter')
<script src="{{ asset('/js/Repository.js') }}"></script>
<script src="/js/Roles.js"></script>

</body>

</html>