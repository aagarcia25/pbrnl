(function(){
    const app = angular.module("pbrApp");

    var controller = function(ejerciciosFactory) {
        const vm = this;
        vm.ejercicios = [];
        Func_Cargando();

        ejerciciosFactory.lista()
        .then((response)=>{
            vm.ejercicios = response.data.data;
            swal.close();
        });
    }

    var factory = function(http) {
        return {
            lista : () => {
                return http.get("GetEjerciciosFiscales")
            },
            nuevo : (e) => {
                return http.post("GuardadEjercicioFiscal", {
                    e
                });
            }
        }
    }

    factory.$inject = ["$http"];
    controller.$inject = ["ejerciciosFiscalesFactory"];

    app
        .controller("ejerciciosFiscalesController", controller)
        .factory("ejerciciosFiscalesFactory",factory);
}());
