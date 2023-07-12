(function(){
    const app = angular.module("pbrApp");

    var controller = function(conacFactory) {
        const vm = this;
        Func_Cargando();
        conacFactory.lista()
        .then((response)=>{
            vm.tipologias = response.data.data;
            swal.close();
        });
    }

    var factory = function(http) {
        return {
            lista : () => {
                return http.get("GetConacTipologia")
            }
        }
    }

    factory.$inject = ["$http"];
    controller.$inject = ["conacFactory"];

    app
        .controller("conacController", controller)
        .factory("conacFactory",factory);
}());
