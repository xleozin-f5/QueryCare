<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadados do documento -->
    <meta charset="utf-8" />
    <title>QueryCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Ícone da aplicação -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Estilos da aplicação -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <!-- Cartão de logout -->
                    <div class="card bg-pattern">
                        <div class="card-body p-4">
                            <!-- Logo da aplicação -->
                            <div class="text-center w-75 m-auto">
                                <a href="qc_admin_logout.php">
                                    <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                                </a>
                            </div>
                            <!-- Marcação de verificação de logout -->
                            <div class="text-center">
                                <div class="mt-4">
                                    <div class="logout-checkmark">
                                        <!-- SVG de verificação animado -->
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                            <circle class="path circle" fill="none" stroke="#4bd396" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                                            <polyline class="path check" fill="none" stroke="#4bd396" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                                        </svg>
                                    </div>
                                </div>
                                <!-- Mensagem de despedida -->
                                <h3>Vejo-te novamente!</h3>
                                <p class="text-muted font-13"> Você foi desconectado com sucesso. </p>
                            </div>
                            <!-- Autor -->
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                    <!-- Links para retornar à página de login ou à página inicial -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                        <p class="text-black">Voltar a<a href="index.php" class="text-bold ml-1"><b>Iniciar Sessão</b></a> OU<a href="../../public/login.html" class="text-bold ml-1"><b>Página Inicial</b></a></p>                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div> <!-- end account-pages -->

    <!-- Inclusão do rodapé -->
    <?php include('assets/inc/footer1.php');?>

    <!-- Scripts JavaScript -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

</html>
