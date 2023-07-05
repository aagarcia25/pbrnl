@php
$view = "Roles y usuarios";
@endphp

@include('includes._partialHeader')

<div class="container">
    <div class="pagetitle">
        <nav class="mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a hrefs="Menu">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Roles y usuarios</li>
            </ol>
        </nav>
    </div>
    <div class="row my-5">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-center text-center mb-3">
                <h1><b>Roles y usuarios</b></h1>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <img src="img/icono admin usuarios.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
            </div>
        </div>
        <div class="col">
            <a href="Usuarios" class="d-flex align-items-center justify-content-center">
                <img class="bd-placeholder-img rounded-circle round-section cursor-pointer" src="img/boton admin usuarios.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
            </a>
            <div class="d-flex align-items-center justify-content-center text-center">
                <h4><b>Administración de Usuarios</b></h4>
            </div>
        </div>
        <div class="col">
            <a href="Roles" class="d-flex align-items-center justify-content-center">
                <img class="bd-placeholder-img rounded-circle round-section cursor-pointer" src="img/boton rol de usuario.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
            </a>
            <div class="d-flex align-items-center justify-content-center text-center">
                <h4><b>Administración de Roles</b></h4>
            </div>
        </div>
    </div>
</div>

<?php

?>
@include('includes._partialFooter')
<script src="js/Administracion.js"></script>

</body>

</html>