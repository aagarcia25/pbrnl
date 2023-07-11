(function(){
    const app = angular.module("pbrApp");

    var controller = function(conacFactory) {
        const vm = this;

        conacFactory.lista()
        .then((response)=>{
            vm.tipologias = response.data.data;
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
