<?php
ini_set('display_errors', 1); // Mostra erros no ambiente de desenvolvimento
error_reporting(E_ALL); // Reporta todos os tipos de erros

session_start();
include('assets/inc/config.php'); // Arquivo de configuração (verifique se está corretamente configurado)

// Função para sanitizar os dados de entrada
function sanitizeInput($data) {
    return !empty($data) ? htmlspecialchars(strip_tags(trim($data))) : null;
}

if(isset($_POST['patient_register'])) {
    // Sanitizando os inputs
    $pat_fname = sanitizeInput($_POST['pat_fname']);
    $pat_lname = sanitizeInput($_POST['pat_lname']);
    $pat_dob = sanitizeInput($_POST['pat_dob']);
    $pat_number = sanitizeInput($_POST['pat_number']);
    $pat_addr = sanitizeInput($_POST['pat_addr']);
    $pat_phone = sanitizeInput($_POST['pat_phone']);
    $pat_type = sanitizeInput($_POST['pat_type']);
    $pat_pwd = $_POST['pat_pwd']; // Obtendo a senha do formulário

  // Criptografando a senha
    $hashed_password = password_hash($pat_pwd, PASSWORD_DEFAULT);

    // Inserir novo paciente na base de dados
    $stmt = $mysqli->prepare("INSERT INTO his_patients (pat_fname, pat_lname, pat_dob, pat_number, pat_addr, pat_phone, pat_type, pat_pwd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('ssssssss', $pat_fname, $pat_lname, $pat_dob, $pat_number, $pat_addr, $pat_phone, $pat_type, $hashed_password);
        if($stmt->execute()) {
            $success = "Registro bem-sucedido. Faça login agora.";
        } else {
            $err = "Ocorreu um erro ao registrar o paciente. Tente novamente.";
        }
        $stmt->close();
    } else {
        $err = "Ocorreu um erro na preparação da consulta.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <title>QueryCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/images/logo.png" />

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
    <div class="account-pages mt-3 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <a href="index.php">
                                    <span style="font-size: 32px;">QueryCare</span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Preencha o formulário para se registrar.</p>
                            </div>
                            <form method='post'>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_fname">Primeiro Nome</label>
                                        <input class="form-control" name="pat_fname" type="text" id="pat_fname" required placeholder="Primeiro nome">
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_lname">Último Nome</label>
                                        <input class="form-control" name="pat_lname" type="text" id="pat_lname" required placeholder="Último nome">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_dob">Data de Nascimento</label>
                                        <input class="form-control" name="pat_dob" type="date" id="pat_dob" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_number">Nº. Utente de Saúde</label>
                                        <input class="form-control" name="pat_number" type="text" id="pat_number" required placeholder="Nº. Utente de Saúde">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_addr">Morada</label>
                                        <input class="form-control" name="pat_addr" type="text" id="pat_addr" required placeholder="Digite sua Morada">
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_phone">Telefone</label>
                                        <input class="form-control" name="pat_phone" type="text" id="pat_phone" required placeholder="Digite seu Telefone">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_type">Tipo de Paciente</label>
                                        <select class="form-control" name="pat_type" id="pat_type" required>
                                            <option value="InPatient">Ativo</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        <label for="pat_pwd">Senha</label>
                                        <input class="form-control" name="pat_pwd" type="password" required id="pat_pwd" placeholder="Crie uma Senha">
                                    </div>
                                </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" name="patient_register" type="submit">Registrar</button>
                                    </div>
                            <div class="text-center mt-2">
                                <p class="text-muted">Já tem uma conta? <a href="index.php" class="text-primary">Faça login</a></p>
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