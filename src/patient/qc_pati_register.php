<?php
session_start();
include('assets/inc/config.php'); // Arquivo de configuração

if(isset($_POST['patient_register'])) {
    $pat_fname = $_POST['pat_fname'];
    $pat_lname = $_POST['pat_lname'];
    $pat_dob = $_POST['pat_dob'];
    $pat_age = $_POST['pat_age'];
    $pat_number = $_POST['pat_number'];
    $pat_addr = $_POST['pat_addr'];
    $pat_phone = $_POST['pat_phone'];
    $pat_type = $_POST['pat_type'];
    $pat_ailment = $_POST['pat_ailment'];
    $pat_pwd = sha1(md5($_POST['pat_pwd'])); // Dupla criptografia para aumentar a segurança

    // Inserir novo paciente na base de dados
    $stmt = $mysqli->prepare("INSERT INTO his_patients (pat_fname, pat_lname, pat_dob, pat_age, pat_number, pat_addr, pat_phone, pat_type, pat_ailment, pat_pwd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssissssss', $pat_fname, $pat_lname, $pat_dob, $pat_age, $pat_number, $pat_addr, $pat_phone, $pat_type, $pat_ailment, $pat_pwd);

    if($stmt->execute()) {
        $success = "Registro bem-sucedido. Faça login agora.";
    } else {
        $err = "Ocorreu um erro. Tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>QueryCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                                <a href="index.php">
                                    <span style="font-size: 32px;">QueryCare</span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Preencha o formulário para se registrar.</p>
                            </div>
                            <form method='post'>
                                <div class="form-group mb-3">
                                    <label for="pat_fname">Primeiro Nome</label>
                                    <input class="form-control" name="pat_fname" type="text" id="pat_fname" required="" placeholder="Digite seu primeiro nome">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_lname">Último Nome</label>
                                    <input class="form-control" name="pat_lname" type="text" id="pat_lname" required="" placeholder="Digite seu último nome">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_dob">Data de Nascimento</label>
                                    <input class="form-control" name="pat_dob" type="date" id="pat_dob" required="" placeholder="Digite sua data de nascimento">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_number">N SnS</label>
                                    <input class="form-control" name="pat_number" type="text" id="pat_number" required="" placeholder="Crie seu ID de paciente">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_addr">Morada</label>
                                    <input class="form-control" name="pat_addr" type="text" id="pat_addr" required="" placeholder="Digite seu endereço">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_phone">Telefone</label>
                                    <input class="form-control" name="pat_phone" type="text" id="pat_phone" required="" placeholder="Digite seu telefone">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_type">Tipo de Paciente</label>
                                    <select class="form-control" name="pat_type" id="pat_type" required="">
                                        <option value="InPatient">Interno</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pat_pwd">Senha</label>
                                    <input class="form-control" name="pat_pwd" type="password" required="" id="pat_pwd" placeholder="Crie uma senha">
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" name="patient_register" type="submit"> Registrar </button>
                                </div>
                                <div class="text-center mt-4">
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
