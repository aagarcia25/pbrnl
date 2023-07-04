<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Iniciar sesión - Interfaz Evalúa PbR Nuevo León</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Vendor CSS Files -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="/css/login.css" />
      <link rel="stylesheet" type="text/css" href="{{ asset('/css/EstilosPbR.css') }}" />
</head>
@php
if (Session::has('sesion')) {
@endphp
    <script>window.location = "/Menu";</script>
@php
}
@endphp
<body>
    <main>

 <div class="container-fluid w-100">
        <div class="row Cintilla">
            <div class="col">
                <div class="text-md-center py-2">
                    <img src="../img/logo-nl.svg" width="200" alt=""/>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <div class="row align-items-md-stretch ">
            <div class="col left LogosIzquierda"> 
                <div class="text-md-center">
                    <img src="../img/logo_tesoreriabco.png" width="240" alt=""/>
                </div>
                <div class="row bg py-4">
                    <img src="../img/leonblanco.svg" width="90" height="300" alt=""/>
                </div>
                <div class="row py-4 ">
                    <h2 class="TituloLeft fw-bold text-center align-items-end">Interfaz Evalúa PbR Nuevo León</h2>
                    <br/><br/><br/><br/><br/>
                </div>
            </div>
            <div class="col right w-50 h-100" style="background-color: #F2F2F2">
                <div class="row mt-5">    
                    <br/>       
                </div>
                <div class="row CuadroRight mt-5">                    
                    <div class="text-md-center mt-4 py-3 ">
                        <img src="../img/LogoEvalua.svg" width="200" alt=""/>
                    </div>
                    <h2 class="TituloRight text-center mt-0">Interfaz Evalúa PbR Nuevo León</h2>
                    <h6 class="text-center mt-0">Ingrese su nueva contraseña</h6>
                    <div class="FormaLogin mt-2">
                        <div class="mt-1">
                            <form id="form_login" autocomplete="off">
                                <div class="vh-5 row text-center align-items-center justify-content-center py-0">
                                    <div class="col-auto">
                                        <div class="mb-4">
                                            <img src="../img/LoginUser.png" width="50" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="mb-4" style="margin-left: -25px">
                                            <input type="text" id="id_usuario" class="form-control UserTextBox text-uppercase" name="id_usuario" placeholder="Usuario" value="@php echo $id_usuario; @endphp" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="vh-5 row m-0 text-center align-items-center justify-content-center py-0">
                                    <div class="col-auto">
                                        <div class="mb-4">
                                            <img src="../img/LoginPwd.png" width="50" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="mb-4" style="margin-left: -25px">
                                            <input type="password" id="password" class="form-control UserTextBox" name="password" placeholder="CONTRASEÑA" maxlength="10" />
                                        </div>
                                    </div>
                                </div>
                                <div class="vh-5 row m-0 text-center align-items-center justify-content-center py-0">
                                    <div class="col-auto">
                                        <button type="submit" class="btn button-login">Cambiar contraseña</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <h6 class="text-center mt-0">Debe ser de 8 a 10 caracteres de longitud, contener al menos una letra mayúscula, una letra minúscula y un caracter especial.</h6>


                        <div id="Mensaje" class="modal fade FondoTransparente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header TituloMsg">
                                        <asp:Label ID="Label10" CssClass="TituloMsg" runat="server" Text="Mensaje"></asp:Label>
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-start text-center">
                                            <div class="col w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="59" fill="currentColor" class="bi bi-exclamation-triangle text-danger" viewBox="0 0 16 16">
                                                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z" />
                                                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="row justify-content-start text-center">
                                            <asp:Label ID="lblMsg1" runat="server" Text="Mensaje"></asp:Label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="MensajeNotifica" class="modal fade FondoTransparente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="alert" data-delay="5000">
                            <div class="modal-dialog modal-sm ">
                                <div class="modal-content">
                                    <div class="modal-header TituloMsg">
                                        <asp:Label ID="Label5" CssClass="TituloMsg" runat="server" Text="Mensaje"></asp:Label>
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-start text-center">
                                            <div class="col w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-envelope text-success" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="row justify-content-start mt-5">
                                            <div class="col fw-bold text-center">
                                                <asp:Label ID="lblMsgNotifica" runat="server" Text="Mensaje"></asp:Label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="MensajeInactivo" class="modal fade FondoTransparente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="alert" data-delay="5000">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content">
                                    <div class="modal-header TituloMsg">
                                        <asp:Label ID="Label1" CssClass="TituloMsg" runat="server" Text="Mensaje"></asp:Label>
                                        <button type="button" class="close" data-dismiss="modal">
                                            &times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-start text-center">
                                            <div class="col w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="59" fill="currentColor" class="bi bi-exclamation-triangle text-danger" viewBox="0 0 16 16">
                                                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z" />
                                                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="row justify-content-start mt-5">
                                            <div class="col fw-bold text-center">
                                                <asp:Label ID="lblMsgInactivo" runat="server" Text="Mensaje"></asp:Label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <script type="text/javascript">
                            function ShowMensaje(title, body) {
                                $("#Mensaje").modal("show");
                            }

                            function ShowMensajeNotifica(title, body) {
                                $("#MensajeNotifica").modal("show");
                            }

                            function ShowMensajeInactivo(title, body) {
                                $("#MensajeInactivo").modal("show");
                            }

                        </script>
                        <br/><br/><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </main>

    <footer class="container-fluid text-center text-lg-start text-white py-5" style="background-color: #3e4551">
        <div class="container-fluid w-100 row ms-2">
            <div class="col-3 align-items-end d-flex justify-content-end" style="text-align: right">
                <div class="text-md-center py-5" style="text-align: right">
                    <img src="../img/escudo Nuevo Leon Bco.svg" width="100" alt=""/>
                </div>
            </div>
            <div class="col-6 text-center text-white TituloLeft">
                <div class="row pt-4">
                    <div class="col">
                        <a href="https://nl.gob.mx/" target="_blank" rel="noopener noreferrer"><img src="../img/nl_gob_mx_Bco.svg" width="200" alt=""/></a>
                    </div>
                </div>
                <p class="FooterDir1 mt-2">
                    Dirección de Presupuesto y Control Presupuestal <br />
                    Subsecretaría de Egresos <br />
                    Secretaría de Finanzas y Tesorería General del Estado
                </p>
                <div class="row d-flex justify-content-center">
                    <div class="col-8 text-center">
                        <p class="FooterDir2">
                            Edificio Víctor Gómez Garza, Gral. Mariano Escobedo 333<br />
                            Zona Centro, Monterrey, Nuevo León, CP 64000
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-3 text-white TituloLeft pt-5">
                <div class="row">
                    <div class="col">
                        <a href="https://www.nl.gob.mx/tesoreria" target="_blank" rel="noopener noreferrer"><img src="../img/tesoreria_NL_Bco.svg" width="150" alt=""/></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1 mt-3">
                        <img src="../img/icon_telefono.svg" width="20" alt=""/>
                    </div>
                    <div class="col-11 text-left mt-3">
                        <p class="FooterDir1">(81) 2020 1300</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1 mt-2">
                        <a href="https://www.facebook.com/SeFiyteNL" target="_blank" rel="noopener noreferrer"><img class="IconFB" src="../img/dummy.png" width="20" alt=""/></a>
                    </div>
                    <div class="col-11 text-left mt-4">
                    </div>
                </div>
            </div>
        </div>

    </footer>

    <script src="/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('/js/Generales.js') }}"></script>
    <script src="{{ asset('/js/Repository.js') }}"></script>
    <script src="{{ asset('/js/RecuperacionCredencial.js') }}"></script>

</body>

</html>