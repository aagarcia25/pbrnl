@php
$view = "Menu de catálogos";
@endphp

@include('includes._partialHeader')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/MenuCatalogos.css" />

<div class="container">
    <div class="pagetitle">
        <nav class="mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Menu">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Catálogos</li>
            </ol>
        </nav>
    </div>
    <div class="row my-5">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-center text-center mb-3">
                <h1><b>Catálogos PbR</b></h1>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <img src="img/icono catalogo.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div onclick="ver_opciones('opcAdministrativo');" class="d-flex align-items-center justify-content-center">
                <img class="bd-placeholder-img rounded-circle round-section cursor-pointer" src="img/boton Admin.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
            </div>
            <div class="d-flex align-items-center justify-content-center text-center">
                <h4><b>Administrativo</b></h4>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div onclick="ver_opciones('opcProgramatico');" class="d-flex align-items-center justify-content-center">
                <img class="bd-placeholder-img rounded-circle round-section cursor-pointer" src="img/boton Programatico.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
            </div>
            <div class="d-flex align-items-center justify-content-center text-center">
                <h4><b>Programático</b></h4>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div onclick="ver_opciones('opcPlaneacion');" class="d-flex align-items-center justify-content-center">
                <img class="bd-placeholder-img rounded-circle round-section cursor-pointer" src="img/boton Planeacion.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
            </div>
            <div class="d-flex align-items-center justify-content-center text-center">
                <h4><b>Planeación</b></h4>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="d-flex align-items-center justify-content-center">
                <a href="Beneficiarios">
                    <img class="bd-placeholder-img rounded-circle round-section cursor-pointer" src="img/boton beneficiarios.svg" alt="Logo de tesorería de Nuevo León" width="140" height="140">
                </a>
            </div>
            <div class="d-flex align-items-center justify-content-center text-center">
                <h4><b>Beneficiarios</b></h4>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div id="opcAdministrativo" class="d-none grupo-catalogos">
        <div class="row my-5">
            <div class="col-md col-12">
                <a href="ConacAdministrativo" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-admin" onmouseover="img_over('icon-cat-admin', '/img/icono administrativa.svg')" onmouseout="img_out('icon-cat-admin', '/img/icono CONAC administrativa off.svg')" src="img/icono CONAC administrativa off.svg" alt="Logo de tesorería de Nuevo León" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>CONAC Administrativo</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="Secretarias" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-secretaria" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-secretaria', '/img/LogoSecretarias.svg')" onmouseout="img_out('icon-cat-secretaria', 'img/icono Secretarias off.svg')" src="img/icono Secretarias off.svg" alt="Logo de tesorería de Nuevo León" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Secretarías</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="UnidadesAdministrativas" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-unidades" class="icon-cat-administrativas" onmouseover="img_over('icon-cat-unidades', '/img/icono unidades admvas.svg')" onmouseout="img_out('icon-cat-unidades', '/img/icono unidades admvas off.svg')" src="img/icono unidades admvas off.svg" alt="Logo de tesorería de Nuevo León" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Unidades administrativas</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="ConacFuncional" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-funcional" class="icon-cat-funcional" onmouseover="img_over('icon-cat-funcional', '/img/icono funcional.svg')" onmouseout="img_out('icon-cat-funcional', '/img/icono CONAC funcional off.svg')" src="img/icono CONAC funcional off.svg" alt="Logo de tesorería de Nuevo León" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>CONAC funcional</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="ConacTipologia" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-tipologia" class="icon-cat-tipologia" onmouseover="img_over('icon-cat-tipologia', '/img/icono tipologia.svg')" onmouseout="img_out('icon-cat-tipologia', '/img/icono CONAC tipologia off.svg')" src="img/icono CONAC tipologia off.svg" alt="Logo de tesorería de Nuevo León" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>CONAC tipología</b></h6>
                </div>
            </div>
        </div>
    </div>
    <div id="opcProgramatico" class="d-none grupo-catalogos">
        <div class="row my-5">
            <div class="col-md col-12">
                <a href="ProgramasPresupuestable" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-program-presup" onmouseover="img_over('icon-cat-program-presup', '/img/icono programas presupuestarios.svg')" onmouseout="img_out('icon-cat-program-presup', '/img/icono programas presupuestarios off.svg')" src="img/icono programas presupuestarios off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Programas presupuestales</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="ActividadesInstitucionales" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-act-instituc" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-act-instituc', '/img/icono actividades institucionales.svg')" onmouseout="img_out('icon-cat-act-instituc', 'img/icono actividades institucionales off.svg')" src="img/icono actividades institucionales off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Actividades institucionales</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="ProgramasProyectosInversion" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-program-proyect" class="icon-cat-administrativas" onmouseover="img_over('icon-cat-program-proyect', '/img/icono proyectos de inversion.svg')" onmouseout="img_out('icon-cat-program-proyect', '/img/icono proyectos de inversion off.svg')" src="img/icono proyectos de inversion off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Programas y proyectos de inversión</b></h6>
                </div>
            </div>
        </div>
    </div>
    <div id="opcPlaneacion" class="d-none grupo-catalogos">
        <div class="row my-5">
            <div class="col-md col-12">
                <a href="Eje" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-eje" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-eje', '/img/icono eje.svg')" onmouseout="img_out('icon-cat-eje', 'img/icono eje off.svg')" src="img/icono eje off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Eje</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="Tema" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-tema" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-tema', '/img/icono tema.svg')" onmouseout="img_out('icon-cat-tema', 'img/icono tema off.svg')" src="img/icono tema off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Tema</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="Objetivos" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-objetivo" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-objetivo', '/img/icono objetivo.svg')" onmouseout="img_out('icon-cat-objetivo', 'img/icono objetivo off.svg')" src="img/icono objetivo off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Objetivo</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="Estrategia" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-estrategia" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-estrategia', '/img/icono estrategias.svg')" onmouseout="img_out('icon-cat-estrategia', 'img/icono estrategia off.svg')" src="img/icono estrategia off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Estrategia</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="LineasAccion" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-lineas-accion" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-lineas-accion', '/img/icono lineas de accion.svg')" onmouseout="img_out('icon-cat-lineas-accion', 'img/icono lineas de accion off.svg')" src="img/icono lineas de accion off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Líneas de acción</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="Ods" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-ods" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-ods', '/img/icono ODS.svg')" onmouseout="img_out('icon-cat-ods', 'img/icono ODS off.svg')" src="img/icono ODS off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>ODS</b></h6>
                </div>
            </div>
            <div class="col-md col-12">
                <a href="MetaOds" class="d-flex align-items-center justify-content-center">
                    <img id="icon-cat-meta-ods" class="icon-cat-secretaria" onmouseover="img_over('icon-cat-meta-ods', '/img/meta ODS.svg')" onmouseout="img_out('icon-cat-meta-ods', 'img/meta ODS off.svg')" src="img/meta ODS off.svg" width="80" height="80">
                </a>
                <div class="d-flex align-items-center justify-content-center text-center">
                    <h6><b>Meta ODS</b></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

?>
<!-- 
@include('includes._partialFooter')
 -->
 
 <script src="js/Catalogos.js"></script>

</body>

</html>