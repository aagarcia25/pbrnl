@php
   $view = "Estructura de MIR";
@endphp

@include('includes._partialHeader')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="css/EstilosPbR.css" />

<div class="container" ng-app="pbrApp" ng-controller="estructuraController as vm">
    <h1>Estructura</h1>

    <div class="row">
        <div class="col">
            <label for="ejercicio">Ejercicio</label>
            <select name="ejercicio" id="ejercicio" 
            ng-model="vm.filtros.ejercicio_fiscal"
            ng-change="vm.getProgramas()"
            ng-options="e.Id as e.Id for e in vm.ejercicios"
            class="form-control"></select>
        </div>
        <div class="col">
            <label for="programa">Programa</label>
            <select name="programa" id="programa" 
            ng-model="vm.filtros.programaId"
            ng-options="e.Id as '['+e.Consecutivo+'] ' + e.DescripcionPrograma for e in vm.programas"
            ng-change="vm.getComponentes()"
            class="form-control"></select>
        </div>
        <div class="col">
            <label for="componente">Componente</label>
            <select name="componente" id="componente" 
            ng-model="vm.filtros.componenteId"
            ng-options="e.Id as e.DescripcionComponente for e in vm.componentes"
            ng-change="vm.getComponenteMir()"
            class="form-control"></select>
        </div>
    </div>

    <div ng-if="vm.filtros.componenteId != null">
        <h2>Datos en MIR</h2>
        <div class="alert alert-warning" ng-if="vm.componenteMir == null">
            Este componente no está en la MIR
        </div>
        <div class="row">
            <div class="col">
                <label for="indicador">Indicador</label>
                <textarea id="indicador" type="text" class="form-control" 
                    ng-model="vm.componenteMir.Indicador"></textarea>
            </div>
            <!-- <div class="col">
                <label for="formula">Fórmula</label>
                <textarea id="formula" type="text" class="form-control" 
                    ng-model="vm.componenteMir.Formula"></textarea>
            </div> -->
        </div>
        <div class="row">
            <div class="col-1">
                <button type="button" class="btn btn-primary" ng-click="vm.guardarComponenteMir()">
                    Guardar
                </button>
                
            </div>
        </div>

        <h2>Actividades</h2>
        <button type="button" class="btn btn-primary" ng-click="vm.agregandoActividad = !vm.agregandoActividad">
            Agregar
        </button>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-if="vm.agregandoActividad">
                    <td>
                        <input type="text" class="form-control" ng-model="vm.actividad.Actividad">
                    </td>
                    <td>
                        <a href="javascript:" class="btn btn-primary" ng-click="vm.guardarActividadMir()">Guardar</a>
                        <a href="javascript:" class="btn btn-warning" ng-click="vm.agregandoActividad = false; vm.actividad={}">Cancelar</a>
                    </td>
                </tr>
                <tr ng-repeat="a in vm.actividades">
                    <td><% a.Actividad %></td>
                    <td>
                        <!-- <a href="javascript:" class="btn btn-danger" ng-click="vm.eliminarActividad(a)">Eliminar</a> -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@include('includes._partialFooter')
<script src="js/estructura.js"></script>
</body>

</html>