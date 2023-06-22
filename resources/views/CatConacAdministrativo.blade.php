@php
   $view = "CONAC Administrativo";
   $img = "icono administrativa.svg";
@endphp

@include('includes._partialHeader')

<link rel="stylesheet" type="text/css" href="/css/EstilosPbR.css" />

<style>
    .input-background-white {
        background-color: white;
    }
</style>

<div class="Margin-Top">
    @include('includes._partialBreadcrumbCatalogos')

    <section class="container section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <div class="table-response mb-4">
                            <table id="table" class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-header text-center">
                                        <th scope="col" width="20%">Id conac</th>
                                        <th scope="col" width="80%">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
    
            </div>
        </div>
    </section>
</div>

@include('includes._partialFooter')

<script src="/js/Repository.js"></script>
<script src="/js/ConacAdministrativo.js"></script>

</body>

</html>