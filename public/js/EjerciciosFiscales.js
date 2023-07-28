(function(){
    const app = angular.module("pbrApp");

    var controller = function(ejerciciosFactory) {
        const vm = this;
        vm.seleccionado = null;
        vm.ejercicios = [];
        vm.ejercicio = {
            ejercicio_fiscal: new Date().getFullYear() + 1
        };

        Func_Cargando();

        ejerciciosFactory.lista()
        .then((response)=>{
            vm.ejercicios = response.data.data;
            swal.close();
        });

        vm.btnAgregarEF_click = function() {
            $("#ModalNuevoEjercicioFiscal").modal("show");
        }

        vm.guardarEF = () => {
            Func_Cargando();
            ejerciciosFactory.guardar(vm.ejercicio)
            .then((response)=>{
                swal.close();
                var data = response.data;
                if(data.error == true){
                    Func_Aviso("Error", "Error al abrir el ejercicio fiscal:" + response.result, "error");
                }
                else {
                    Func_Toast("success", "Datos guardados", "Se agreg&oacute; el ejercicio fiscal.");
                    vm.ejercicios.push(data.result);
                    $("#ModalNuevoEjercicioFiscal").modal("toggle");
                }
            })
            .catch((data)=> {
                swal.close();
                MostrarHttpError(data);
            })
            ;
        }

        vm.setStatus = () => {
            const accion = vm.seleccionado.Estatus == 'A' ? 'cerrar' : 'abrir';
            Func_DespliegaConfirmacion("Confirmar", "Seguro que quiere "+accion+" el Ejercicio Fiscal","","Aceptar","Cancelar", (response) => {
                if(!response)
                    return;

                const request = {
                    Id: vm.seleccionado.Id,
                    Estatus: vm.seleccionado.Estatus == 'A' ? 'I' : 'A'
                };
                ejerciciosFactory.setStatus(request)
                .then(response => {
                    vm.seleccionado.Estatus = request.Estatus;
                    Func_Toast("success", "Estado actualizado", "Se ha actualizado el estado del Ejercicio Fiscal");
                })
                .catch(err => {
                    MostrarHttpError(err);
                })
            });
        }
    }

    var factory = function(http) {
        return {
            lista : () => {
                return http.get("GetEjerciciosFiscales")
            },
            guardar : (e) => {
                return http.post("GuardarEjercicioFiscal", e);
            },
            setStatus: (e) => {
                return http.post("SetStatusEF", e);
            }
        }
    }

    factory.$inject = ["$http"];
    controller.$inject = ["ejerciciosFiscalesFactory"];

    app
        .controller("ejerciciosFiscalesController", controller)
        .factory("ejerciciosFiscalesFactory",factory);
}());
