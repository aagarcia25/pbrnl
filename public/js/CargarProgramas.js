(function(){
    const app = angular.module("pbrApp");

    var controller = function(cargarProgramasFactory) {
        const vm = this;

        vm.cargarProgramas = () => {
            var f = document.getElementById("fuArchivo").files[0];
            var formData = new FormData();
            formData.append("archivo", f);
            cargarProgramasFactory.cargarProgramas(formData)
                .then(result=>{
                    alert("Datos cargados");
                });

            /*var reader = new FileReader();
            reader.onloadend  = (e) => {
                var data = e.target.result;
                var formData = new FormData();
                formData.append("archivo", data);
                cargarProgramasFactory.cargarProgramas(formData)
                .then(result=>{
    
                });
            }
            reader.readAsArrayBuffer(f);*/
        }
    }

    var factory = function(http) {
        return {
            cargarProgramas : (data) => {
                //return http.post("CargarProgramas", data);

                return http({
                    url: 'CargarProgramas',
                    headers: {"Content-Type": undefined },
                    data: data,
                    method: "POST"
                });
            }
        }
    }

    factory.$inject = ["$http"];
    controller.$inject = ["cargarProgramasFactory"];

    app
        .controller("cargarProgramas", controller)
        .factory("cargarProgramasFactory",factory);
}());
