@php
$view = "Menu de inicio";
@endphp

@include('includes._partialHeader')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/EstilosPbR.css" />

<div class="container FontMenuInicio" style="margin-top: 1%">
    <div class="row text-center">
        <p class="TituloCatalogo2">Administrar MIR</p>
    </div>
    <div class="row RenglonArriba">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-center">
                <img class="BotonImagenMIR" src="img/iconoMIR.svg" alt="Logo de tesorería de Nuevo León" width="400" height="400">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-2">
            <a href="/RevisarMIR" class="d-flex align-items-center justify-content-center">
                <img class="BotonRevisarMIR" src="img/dummy.png" alt="Logo de tesorería de Nuevo León" width="170" height="170">
            </a>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <p class="FontMenuInicio">Revisar MIR</p>
            </div>
            <!-- <div class="d-flex align-items-center justify-content-center">
                <img class="BotonRevisarMIR" src="img/dummy.png" alt="Logo de tesorería de Nuevo León" width="170" height="170">
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <p class="FontMenuInicio">Revisar MIR</p>
            </div> -->
        </div>
        <div class="col-lg-2">
            <div class="d-flex align-items-center justify-content-center">
                <img class="BotonReportesMIR" src="img/dummy.png" alt="Logo de tesorería de Nuevo León" width="170" height="170">
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <p class="FontMenuInicio">Reportes MIR</p>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="d-flex align-items-center justify-content-center">
                <img class="BotonFichaTecnicaMIR" src="img/dummy.png" alt="Logo de tesorería de Nuevo León" width="170" height="170">
            </div>
            <div class="FontMenuInicio d-flex align-items-center justify-content-center text-center mt-3">
                <p class="FontMenuInicio">Ficha Técnica<br/>de Indicadores</p>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>

<?php

?>


</body>

</html>