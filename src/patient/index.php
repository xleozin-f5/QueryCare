<?php
ini_set('display_errors', 1); // Desativando a exibição de erros no ambiente de produção
error_reporting(1); // Ocultando todos os tipos de erros
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php'); // Arquivo de configuração

if(isset($_POST['patient_login'])) {
    $pat_number = $_POST['pat_number'];
    $pat_pwd = $_POST['pat_pwd']; // Senha não criptografada do formulário

    // Consulta SQL para verificar as credenciais do paciente
    $stmt = $mysqli->prepare("SELECT pat_id, pat_number, pat_fname, pat_lname, pat_pwd FROM his_patients WHERE pat_number=?");
    $stmt->bind_param('s', $pat_number);
    $stmt->execute();
    $stmt->store_result(); // Armazenando o resultado para verificar o número de linhas retornadas
    $num_rows = $stmt->num_rows;

    if($num_rows > 0) {
        $stmt->bind_result($pat_id, $pat_number, $pat_fname, $pat_lname, $hashed_password);
        $stmt->fetch();
        
        // Verificando a senha usando password_verify
        if (password_verify($pat_pwd, $hashed_password)) {
            $_SESSION['pat_id'] = $pat_id;
            $_SESSION['pat_number'] = $pat_number;
            $_SESSION['pat_name'] = $pat_fname . ' ' . $pat_lname; // Armazenando o nome completo do paciente na sessão
            header("location: qc_pati_dashboard.php");
            exit; // Termina o script após redirecionar o usuário
        } else {
            $err = "Acesso Negado. Verifique suas credenciais.";
        }
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
    <link rel="icon" type="image/x-icon" href="./assets/images/logo.png" />

    <!-- CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" /> <!-- Adicionando arquivo CSS personalizado -->
</head>
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="../../index.html"><img src="../../assets/img/querycareblack.png" alt="Logo" style="max-width: 100px;"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../../public/aboutus.html">Sobre Nós</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../public/login.html">Login</a>
            </li>
        </ul>
    </div>
  </nav>
<body 
class="authentication-bg authentication-bg-pattern">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <a href="/QueryCare/public/login.html" class="logo">
                                    <span style="font-size: 32px;">QueryCare</span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Introduza seu ID e senha para acessar seu painel de paciente.</p>
                            </div>
                            <form method="post">
                                <div class="mb-3">
                                    <label for="pat_number" class="form-label">Nº. Utente de Saúde</label>
                                    <input class="form-control" name="pat_number" type="text" id="pat_number" required placeholder="Insira seu Nº. Utente de Saúde">
                                </div>
                                <div class="mb-3">
                                    <label for="pat_pwd" class="form-label">Senha</label>
                                    <input class="form-control" name="pat_pwd" type="password" required id="pat_pwd" placeholder="Insira sua senha">
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-success btn-block" name="patient_login" type="submit"> Entrar </button>
                                </div>
                                <div class="text-center mt-3">
                                    <p class="text-muted">Não tem uma conta? <a href="qc_pati_register.php" class="text-primary">Registre-se</a></p>
                                </div>
                            </form>
                            <?php if(isset($err)) {?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <?php echo $err;?>
                                </div>
                            <?php } ?>
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
