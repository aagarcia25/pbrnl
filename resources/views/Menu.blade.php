@php
$view = "Menu de inicio";
@endphp

@include('includes._partialHeader')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('/css/MenuInicio.css') }}"  />
<input type="hidden" id="tipo_usuario" value="@php session('tipo_usuario'); @endphp">
<input type="hidden" id="admin_evalua" value="@php session('admin_evalua'); @endphp">
<input type="hidden" id="catalogos_pbr" value="@php session('catalogos_pbr'); @endphp">
<input type="hidden" id="programatica" value="@php session('programatica'); @endphp">
<input type="hidden" id="admin_mir" value="@php session('admin_mir'); @endphp">

<div class="container FontMenuInicio" style="margin-top: 7%">
    <div class="row my-5">
        <div class="col-lg-2"></div>
        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-center">
                <!-- <a href="/Administracion">  -->
                <a @if (session('admin_evalua') == 1) href="/public/MenuAdmin" @else href="#" @endif>        
                    <img class="BotonImagen3" 
                    @if (session('admin_evalua') == 1) 
                        src="img/boton admin usuarios.svg" 
                    @else 
                        src="img/AdminUsrDis.png" @endif alt="Logo de tesorería de Nuevo León" width="170" height="170">
                </a>
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <h2 class="FontMenuInicio">Usuarios y Roles</h2>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-center">
                <a @if (session('catalogos_pbr') == 1) href="/public/Catalogos" @else href="#" @endif class="d-flex align-items-center justify-content-center">
                    <img class="BotonImagen1" 
                    @if (session('catalogos_pbr') == 1) 
                        src="img/Catalogos.svg" 
                    @else
                        src="img/CatalogosDis.png" @endif alt="Logo de tesorería de Nuevo León" width="170" height="170">
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
                <a @if (session('admin_mir') == 1) href="/public/MenuMIR" @else href="#" @endif class="d-flex align-items-center justify-content-center">
                    <img class="BotonImagen4" 
                    @if (session('admin_mir') == 1)
                        src="img/BotonMIR.svg"
                    @else
                        src="img/MIRDis.png" @endif alt="Logo de tesorería de Nuevo León" width="170" height="170">
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