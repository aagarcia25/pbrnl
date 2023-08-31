@php
   $view = "Administrar Usuarios";
   $img = "AdminUsuariosInt.svg";
@endphp

@include('includes._partialHeader')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="css/EstilosPbR.css" />

    <div class="container body" ng-app="pbrApp" ng-controller="cargarProgramas as vm">
        <h1>Carga de programas presupuestarios</h1>

        <div>
            <label for="fuArchivo">Archivo de excel</label>
            <input type="file" id="fuArchivo" class="form-control">
        </div>
        <div>
            <button type="button" class="buttonOutlineSucces" ng-click="vm.cargarProgramas()">
                Cargar
            </button>
        </div>

    </div>
@include('includes._partialFooter')
<script src="js/Repository.js"></script>
<script src="js/CargarProgramas.js"></script>

</body>

</html>