@php
$view = "Menu de inicio";
@endphp

@include('includes._partialHeader')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/EstilosPbR.css') }}" />

<div class="container FontMenuInicio Margin-Top mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-center">
                <img class="BotonImagenUsuarios" src="img/icono admin usuarios.svg" alt="Logo de tesorería de Nuevo León" width="350" height="350">
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-lg-3"></div>
        <div class="col-lg-3">
            <div class="d-flex align-items-center justify-content-center">
                <a href="/Usuarios" class="d-flex align-items-center justify-content-center">
                    <img class="BotonAdminUsuarios" src="img/boton admin usuarios.svg" alt="Logo de tesorería de Nuevo León" width="170" height="170">
                </a>
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <p>Administración de<br/> Usuarios</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex align-items-center justify-content-center">
                <a href="/Roles" class="d-flex align-items-center justify-content-center">
                    <img class="BotonAdminRoles" src="img/boton rol de usuario.svg" alt="Logo de tesorería de Nuevo León" width="170" height="170">
                </a>
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <p>Administración de<br/> Roles</p>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>

<?php

?>


</body>

</html>