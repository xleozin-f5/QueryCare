<?php
include('assets/inc/config.php'); // incluir arquivo de configuração
session_start(); // Iniciar sessão

if(isset($_POST['admin_login'])) {
    $ad_email = $_POST['ad_email'];
    $ad_pwd = sha1(md5($_POST['ad_pwd'])); // criptografar a senha

    // Debug: Verificar se as variáveis estão recebendo os valores corretamente
    echo "Email: " . htmlspecialchars($ad_email) . "<br>";
    echo "Senha Criptografada: " . htmlspecialchars($ad_pwd) . "<br>";

    // Preparar e executar a consulta SQL
    $stmt = $mysqli->prepare("SELECT ad_id FROM his_admin WHERE ad_email=? AND ad_pwd=?");
    if ($stmt) {
        $stmt->bind_param('ss', $ad_email, $ad_pwd);
        $stmt->execute();
        $stmt->bind_result($ad_id);
        $rs = $stmt->fetch();

        // Debug: Verificar se a consulta retornou resultados
        if($rs) {
            echo "Login bem-sucedido! ID: " . htmlspecialchars($ad_id) . "<br>";
            $_SESSION['ad_id'] = $ad_id;
            header("location: qc_admin_dashboard.php");
            exit; // Encerrar o script após redirecionar
        } else {
            $err = "Acesso negado. Verifique suas credenciais";
        }

        $stmt->close();
    } else {
        $err = "Erro na preparação da consulta SQL.";
    }
}

// Exibir mensagem de erro, se houver
if(isset($err)) {
    echo "<script>alert('$err');</script>";
}
?>
<!--End Login-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>QueryCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/images/logo.png" />
    <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/images/logo.png" />
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!--Load Sweet Alert Javascript-->

    <script src="assets/js/swal.js"></script>
    <!--Inject SWAL-->
    <?php if(isset($success)) {?>
    <!--This code for injecting an alert-->
    <script>
    setTimeout(function() {
            swal("Sucesso", "<?php echo htmlspecialchars($success);?>", "Sucesso");
        },
        100);
    </script>

    <?php } ?>

    <?php if(isset($err)) {?>
    <!--This code for injecting an alert-->
    <script>
    setTimeout(function() {
            swal("Erro, tente novamente", "<?php echo htmlspecialchars($err);?>", "Erro");
        },
        100);
    </script>

    <?php } ?>
</head>

<body class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                        <a href="/QueryCare/public/login.html" class="logo">
                                    <img src="./assets/images/querycareblc.png" alt="QueryCare Logo" style="height: 60px;">
                                </a>
                                <p class="text-muted mb-4 mt-3">Introduza o seu email e senha para aceder ao seu painel de admin.</p>
                            </div>

                            <form method='post'>

                                <div class="form-group mb-3">
                                    <label for="emailaddress">Endereço de email</label>
                                    <input class="form-control" name="ad_email" type="email" id="emailaddress" required="" placeholder="Digite seu e-mail">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Palavra-Passe</label>
                                    <input class="form-control" name="ad_pwd" type="password" required="" id="password" placeholder="Coloque sua Palavra-Passe">
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" name="admin_login" type="submit"> Entrar </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <?php include ("assets/inc/footer1.php");?>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>
</html>
