(function(){
    const app = angular.module("pbrApp");

    var controller = function(estructuraFactory) {
        const vm = this;
        vm.agregandoActividad = false;
        vm.filtros = {

        };
        
        estructuraFactory.ejercicios()
        .then((response)=>{
            vm.ejercicios = response.data.data;
            vm.programas = [];
            vm.componentes = [];
            vm.componenteMir = null;
        });


        vm.getProgramas = function () {
            estructuraFactory.programas(vm.filtros.ejercicio_fiscal)
            .then((response)=>{
                vm.programas = response.data.data;
                vm.actividades = [];
            });
        }

        vm.getComponentes = function () {
            estructuraFactory.componentes(vm.filtros.programaId)
            .then((response)=>{
                vm.componentes = response.data.data;
                vm.componenteMir = {};
                vm.actividades = [];
            });
        }

        vm.getComponenteMir = function() {
            vm.actividades = [];
            estructuraFactory.componenteMir(vm.filtros.componenteId)
            .then((response)=>{
                vm.componenteMir = response.data.data;

                if(vm.componenteMir != null) {
                    estructuraFactory.actividades(vm.componenteMir.Id)
                    .then((response2)=>{
                        vm.actividades = response2.data.data;
                    })
                }
            });
        }

        vm.guardarComponenteMir = function() {
            vm.componenteMir.ComponenteId = vm.filtros.componenteId;

            estructuraFactory.guardarComponenteMir(vm.componenteMir)
            .then((response)=> {
                vm.componenteMir.Id = response.data.result;
                alert("Datos guardados");
            })
        }

        vm.guardarActividadMir = function(a) {
            vm.actividad.ComponenteMirId = vm.componenteMir.Id;
            estructuraFactory.guardarActividadMir(vm.actividad)
            .then((response)=> {
                vm.actividad.Id = response.data.data;
                vm.actividades.push(vm.actividad);
                vm.actividad = {};
                vm.agregandoActividad = false;
                alert("Datos guardados");
            })
        }
    }

    var factory = function(http) {
        return {
            ejercicios : () => {
                return http.get("GetEjerciciosFiscales")
            },
            programas: (e) => {
                return http.get("GetAllProgramasPP", {
                    params:{
                    ejercicio_fiscal: e
                    }
                });
            },
            componentes: (id) => {
                return http.post("GetComponentesPP", {
                    id
                });
            },
            componenteMir: (id) => {
                return http.get("ComponenteMir", {
                    params:{
                        id
                    }
                });
            },
            actividades: (componenteMirId) => {
                return http.post("GetMirActividades", {
                    componenteMirId
                });
            },
            guardarComponenteMir: (cm) => {
                return http.post("GuardarComponenteMir", cm);
            },
            guardarActividadMir: (am) => {
                return http.post("GuardarActividadMir", am);
            },
        }
    }

    factory.$inject = ["$http"];
    controller.$inject = ["estructuraFactory"];

    app
        .controller("estructuraController", controller)
        .factory("estructuraFactory",factory);
}());
