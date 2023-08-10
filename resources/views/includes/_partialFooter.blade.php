</main>
<!-- End #main -->

<script src="js/jquery.js"></script>
<script src="js/angular.js"></script>
<script src="js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="vendor/toast/jquery.toast.min.js"></script>
<script src="vendor/js/jquery.maskMoney.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.es.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/fc-4.2.1/fh-3.3.1/sp-2.1.1/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
 <script src="js/Generales.js"></script>
<script src="js/TimeOut.js"></script>
<script>
    $(document).ready(function ($) {

    function start_timer() { }

    $.jq_easy_session_timeout(
        {
            inactivityDialogDuration: 1800, //3600
            maxInactivitySeconds: 1800, //3600
            inactivityLogoutUrl: 'Logout',
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



