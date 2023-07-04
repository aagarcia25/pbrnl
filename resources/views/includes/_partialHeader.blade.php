<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@php echo $view; @endphp - Interfaz Evalúa PbR Nuevo León</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    
    <!-- Css plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/vendor/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />

    <!-- Data tables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/fc-4.2.1/fh-3.3.1/sp-2.1.1/datatables.min.css"/>

    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/menu.css') }}"  />
    {{-- <link rel="stylesheet" type="text/css" href="Content/EstilosPbR.css" /> --}}

</head>
@php
if (!Session::has('sesion')) {
@endphp
    <script>window.location = "/";</script>
@php
}else{
    if (!Session::has('tiempo')) {
        session(['tiempo' => time()]);
    }else{
        if (time() - session('tiempo') > 1800) { //3600
            @endphp
                <script>window.location = "/interfaz/Logout";</script>
            @php
            die();
        }
    }
    session(['tiempo' => time()]);
}
@endphp
<body class="background">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white static-top">
        <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <a class="navbar-brand mx-5" href="/Menu">
                <img src="img/logo-tesoreria.svg" alt="Logo de tesorería de Nuevo León" width="200">
            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center MarginRight">
            <div class="navbar-brand">
                <img src="img/LogoEvalua.svg" width="200" alt="Logo evalua PbR NL">
            </div>
            <div class="dropdown_usuario">
                <img src="img/iconousuario2.svg" width="40" alt="Usuario" class="" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu mt-1 pt-3 UsuarioBG-0 border border-2" aria-labelledby="dropdownMenuButton">
                        <li class="dropdown-item UsuarioBG fw-bold text-uppercase">
                             @php echo session('id_usuario'); @endphp<br>@php echo session('nombre') . " " . session('ap_paterno'); @endphp
                        </li>
                        <li><a class="dropdown-item BtnLogout text-center" href="/interfaz/Logout">Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
<?php
?>
    <main id="main container-fluid">
    