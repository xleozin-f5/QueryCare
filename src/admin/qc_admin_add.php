<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Iniciar a sessão
session_start();

// Incluir o arquivo de configuração do banco de dados
include('assets/inc/config.php');

// Adicionar um novo administrador
if(isset($_POST['add_admin'])) {
    $ad_fname = $_POST['ad_fname'];
    $ad_lname = $_POST['ad_lname'];
    $ad_email = $_POST['ad_email'];
    $ad_pwd = sha1(md5($_POST['ad_pwd'])); // Dupla encriptação da palavra-passe

    // SQL para inserir os valores capturados
    $query = "INSERT INTO his_admin (ad_fname, ad_lname, ad_email, ad_pwd) VALUES (?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssss', $ad_fname, $ad_lname, $ad_email, $ad_pwd);
    $stmt->execute();

    // Verificar se a inserção foi bem-sucedida
    if($stmt) {
        $success = "Detalhes do Administrador Adicionados";
    } else {
        $err = "Por favor, tente novamente mais tarde";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Cabeçalho -->
    <?php include('assets/inc/head.php');?>
</head>

<body>
    <!-- Início da página -->
    <div id="wrapper">

        <!-- Início da barra superior -->
        <?php include("assets/inc/nav.php");?>
        <!-- Fim da barra superior -->

        <!-- Início da barra lateral esquerda -->
        <?php include("assets/inc/sidebar.php");?>
        <!-- Fim da barra lateral esquerda -->

        <!-- Início do conteúdo da página -->
        <div class="content-page">
            <div class="content">

                <!-- Início do conteúdo -->
                <div class="container-fluid">

                    <!-- Início do título da página -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="qc_admin_dashboard.php">Painel</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Administrador</a></li>
                                        <li class="breadcrumb-item active">Adicionar Administrador</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Adicionar Detalhes do Administrador</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Fim do título da página -->

                    <!-- Formulário para adicionar administrador -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Preencher todos os campos</h4>
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputFirstName" class="col-form-label">Primeiro Nome</label>
                                                <input type="text" required="required" name="ad_fname" class="form-control" id="inputFirstName">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputLastName" class="col-form-label">Sobrenome</label>
                                                <input required="required" type="text" name="ad_lname" class="form-control" id="inputLastName">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail" class="col-form-label">Email</label>
                                            <input required="required" type="email" class="form-control" name="ad_email" id="inputEmail">
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword" class="col-form-label">Password</label>
                                            <input required="required" type="password" name="ad_pwd" class="form-control" id="inputPassword">
                                        </div>

                                        <button type="submit" name="add_admin" class="ladda-button btn btn-success" data-style="expand-right">Adicionar Administrador</button>
                                    </form>
                                </div> <!-- fim do card-body -->
                            </div> <!-- fim do card-->
                        </div> <!-- fim da coluna -->
                    </div>
                    <!-- fim do formulário para adicionar administrador -->

                </div> <!-- fim do container -->
            </div> <!-- fim do conteúdo -->

            <!-- Início do rodapé -->
            <?php include('assets/inc/footer.php');?>
            <!-- Fim do rodapé -->
        </div>
        <!-- Fim do conteúdo da página -->

    </div>
    <!-- Fim do wrapper -->

    <!-- Overlay da barra direita -->
    <div class="rightbar-overlay"></div>

    <!-- Ficheiros JavaScript -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <!-- JavaScript para botões de carregamento -->
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>

    <!-- Inicialização dos botões -->
    <script src="assets/js/pages/loading-btn.init.js"></script>

</body>

</html>
