<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('assets/inc/config.php'); // Arquivo de configuração

if(isset($_POST['patient_login'])) {
    $pat_number = $_POST['pat_number'];
    $pat_pwd = sha1(md5($_POST['pat_pwd'])); // Dupla criptografia para aumentar a segurança

    // Consulta SQL para verificar as credenciais do paciente
    $stmt = $mysqli->prepare("SELECT pat_id, pat_number FROM his_patients WHERE pat_number=? AND pat_pwd=?");
    $stmt->bind_param('ss', $pat_number, $pat_pwd);
    $stmt->execute();
    $stmt->bind_result($pat_id, $pat_number);
    $rs = $stmt->fetch();

    if($rs) {
        $_SESSION['pat_id'] = $pat_id;
        $_SESSION['pat_number'] = $pat_number;
        header("location:qc_pati_dashboard.php");
    } else {
        $err = "Acesso Negado. Verifique suas credenciais.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>QueryCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="MartDevelopers" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert -->
    <script src="assets/js/swal.js"></script>
    <?php if(isset($success)) {?>
    <script>
    setTimeout(function() {
            swal("Sucesso", "<?php echo $success;?>", "success");
        },
        100);
    </script>
    <?php } ?>
    <?php if(isset($err)) {?>
    <script>
    setTimeout(function() {
            swal("Falha", "<?php echo $err;?>", "error");
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
                                <a href="/QueryCare/public/login.html">
                                    <span style="font-size: 32px;">QueryCare</span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Introduza seu ID e senha para acessar seu painel de paciente.</p>
                            </div>
                            <form method='post'>
                                <div class="form-group mb-3">
                                    <label for="pat_number">ID do Paciente</label>
                                    <input class="form-control" name="pat_number" type="text" id="pat_number" required="" placeholder="Insira seu ID de paciente">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_pwd">Senha</label>
                                    <input class="form-control" name="pat_pwd" type="password" required="" id="pat_pwd" placeholder="Insira sua senha">
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" name="patient_login" type="submit"> Entrar </button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="text-muted">Não tem uma conta? <a href="qc_pati_register.php" class="text-primary">Registre-se</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Rodapé -->
    <?php include ("assets/inc/footer1.php");?>
    <!-- Scripts -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
