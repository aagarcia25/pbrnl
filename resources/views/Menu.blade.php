@php
$view = "Menu de inicio";
@endphp

@include('includes._partialHeader')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/css/MenuInicio.css" />

<div class="container FontMenuInicio" style="margin-top: 7%">
    <div class="row my-5">
        <div class="col-lg-2"></div>
        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-center">
                <!-- <a href="/Administracion">  -->
                <a href="/MenuAdmin">        
                    <img class="BotonImagen3" src="img/boton admin usuarios.svg" alt="Logo de tesorería de Nuevo León" width="170" height="170">
                </a>
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <h2 class="FontMenuInicio">Usuarios y Roles</h2>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-center">
                <a href="/Catalogos" class="d-flex align-items-center justify-content-center">
                    <img class="BotonImagen1" src="img/Catalogos.svg" alt="Logo de tesorería de Nuevo León" width="170" height="170">
                </a>
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <h2 class="FontMenuInicio">Catálogos<br/>PbR</h2>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="row my-5">
        <div class="col-lg-2"></div>
        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-center">
                <img class="BotonImagen2" src="img/boton clasificacion programatica desactivado.svg" alt="Logo de tesorería de Nuevo León" width="170" height="170">
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <h2 class="FontMenuInicio">Generación de Clave<br/> Programática NL</h2>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-center">
                <a href="/MenuMIR" class="d-flex align-items-center justify-content-center">
                    <img class="BotonImagen4" src="img/BotonMIR.svg" alt="Logo de tesorería de Nuevo León" width="170" height="170">
                </a>
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <h2 class="FontMenuInicio">Administrar MIR</h2>
            </div>
        </div>
        <div class="col-lg-2"></div>
   </div>
</div>

<?php

?>


</body>

</html>