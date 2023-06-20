    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <!--div-- class="container-fluid footer">
        <footer class="row row-cols-3 py-3">
            <div class="col-md-4 col-12 d-flex align-items-center justify-content-center">
                <img src="img/escudo Nuevo Leon Bco.svg" width="100" alt="Escudo del Nuevo León">
            </div>

            <div class="col-md-4 col-12">
                <div class="row row-cols-2">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <a href="https://www.nl.gob.mx/tesoreria" target="_blank">
                            <img class="text-white" src="img/nl_gob_mx_Bco.svg" width="150" alt="Logo de Nuevo León">
                        </a>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center my-3 text-white text-center">
                        <h6 class="mx-3 my-1">Dirección de Presupuesto y Control Presupuestal Subsecretaría de Egresos Secretaría de Finanzas y Tesorería General del Estado</h6>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center text-white text-center">
                        <h6>Edificio Víctor Gómez Garza, Gral. Mariano Escobedo 333 Zona Centro, Monterrey, Nuevo León, CP 64000</h6>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="row row-cols-2 text-white">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <a href="https://www.nl.gob.mx/tesoreria" target="_blank">
                            <img src="img/tesoreria_NL_Bco.svg" width="150" alt="Logo de tesorería de Nuevo León">
                        </a>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center my-3">
                        <i class="bi bi-telephone-fill"></i>
                        <p class="mx-3 my-1"><b>(81) 2020 1300</b></p>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <a class="text-white" href="https://www.facebook.com/SeFiyteNL" target="_blank">
                            <h4><i class="bi bi-facebook"></i></h4>
                        </a>
                    </div>
                </div>
            </div>

        </footer>
    </!--div-->
    <!-- End Footer -->

    <script src="/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/vendor/toast/jquery.toast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/fc-4.2.1/fh-3.3.1/sp-2.1.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="/js/Generales.js"></script>
    <script src="/js/TimeOut.js"></script>
    <script>
        $(document).ready(function ($) {

        function start_timer() { }

        $.jq_easy_session_timeout(
            {
                inactivityDialogDuration: 1800, //3600
                maxInactivitySeconds: 1800, //3600
                inactivityLogoutUrl: '/Logout',
                inactivityLogoutUrl1: function () {
                    console.log('log out code goes here');
                },
            });

        $(document).on('click', '.btn_start_timer', function (event) {
            event.preventDefault();
            start_timer();
        });

        });
    </script>

    

