<?php
	session_start(); // Inicia a sessão
	include('assets/inc/config.php'); // Inclui o ficheiro de configuração

	// Verifica se o formulário foi submetido
	if(isset($_POST['admin_sup']))
	{
		// Obtém os valores enviados pelo formulário
		$ad_fname=$_POST['ad_fname']; // Primeiro nome do administrador
		$ad_lname=$_POST['ad_lname']; // Apelido do administrador
		$ad_email=$_POST['ad_email']; // Email do administrador
		$ad_pwd=sha1(md5($_POST['ad_pwd'])); // Encripta a palavra-passe para aumentar a segurança

		// Query para inserir os valores capturados
		$query="insert into his_admin (ad_fname, ad_lname, ad_email, ad_pwd) values(?,?,?,?)";
		$stmt = $mysqli->prepare($query);
		$rc=$stmt->bind_param('ssss', $ad_fname, $ad_lname, $ad_email, $ad_pwd);
		$stmt->execute();
		
		// Verifica se a query foi executada com sucesso
		if($stmt)
		{
			$success = "Conta criada com sucesso. Por favor, proceda ao login.";
		}
		else {
			$err = "Por favor, tente novamente mais tarde.";
		}		
	}
?>
<!-- Fim do lado do servidor -->
<!-- Fim do login -->
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8" />
    <title>QueryCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Um tema de administração completo que pode ser usado para construir CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Ícone do aplicativo -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- CSS do aplicativo -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- Carregar Sweet Alert Javascript -->
    <script src="assets/js/swal.js"></script>
    <!-- Injetar SWAL -->
    <?php if(isset($success)) {?>
    <!-- Este código é para injetar um alerta -->
    <script>
    setTimeout(function() {
            swal("Sucesso", "<?php echo $success;?>", "success");
        },
        100);
    </script>

    <?php } ?>

    <?php if(isset($err)) {?>
    <!-- Este código é para injetar um alerta -->
    <script>
    setTimeout(function() {
            swal("Falhou", "<?php echo $err;?>", "Falhou");
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
                                <a href="qc_admin_register.php">
                                    <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Ainda não tem conta? Crie a sua conta, leva menos de um minuto.</p>
                            </div>

                            <form method='post'>

                                <div class="form-group">
                                    <label for="fullname">Nome</label>
                                    <input class="form-control" type="text" name="ad_fname" id="fullname" placeholder="Insira o seu nome" required>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Apelido</label>
                                    <input class="form-control" type="text" name="ad_lname" id="fullname" placeholder="Insira o seu apelido" required>
                                </div>
                                <div class="form-group">
                                    <label for="emailaddress">Endereço de Email</label>
                                    <input class="form-control" name="ad_email" type="email" id="emailaddress" required placeholder="Insira o seu email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Palavra-passe</label>
                                    <input class="form-control" name="ad_pwd" type="password" required id="password" placeholder="Insira a sua palavra-passe">
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" name="admin_sup" type="submit"> Registar </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Já tem uma conta? <a href="index.php" class="text-white ml-1"><b>Iniciar sessão</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Rodapé -->
    <?php include("assets/inc/footer1.php");?>
    <!-- Fim do rodapé -->

    <!-- JS do fornecedor -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- JS do aplicativo -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
