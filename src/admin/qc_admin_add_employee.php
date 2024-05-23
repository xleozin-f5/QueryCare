<?php
    // Iniciar a sessão
    session_start();
    // Incluir o ficheiro de configuração
    include('assets/inc/config.php');

    // Adicionar um novo médico
    if(isset($_POST['add_doc'])) {
        $doc_fname = $_POST['doc_fname'];
        $doc_lname = $_POST['doc_lname'];
        $doc_number = $_POST['doc_number'];
        $doc_email = $_POST['doc_email'];
        $doc_pwd = sha1(md5($_POST['doc_pwd'])); // Dupla encriptação da palavra-passe

        // SQL para inserir os valores capturados
        $query = "INSERT INTO his_docs (doc_fname, doc_lname, doc_number, doc_email, doc_pwd) VALUES (?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sssss', $doc_fname, $doc_lname, $doc_number, $doc_email, $doc_pwd);
        $stmt->execute();

        // Verificar se a inserção foi bem-sucedida
        if($stmt) {
            $success = "Detalhes do Médico Adicionados";
        } else {
            $err = "Por favor, tente novamente mais tarde";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<!-- Cabeçalho -->
<?php include('assets/inc/head.php');?>

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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Médico</a></li>
                                        <li class="breadcrumb-item active">Adicionar Médico</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Adicionar Detalhes do Médico</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Fim do título da página -->

                    <!-- Formulário para adicionar médico -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Preencher todos os campos</h4>
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4" class="col-form-label">Primeiro Nome</label>
                                                <input type="text" required="required" name="doc_fname" class="form-control" id="inputEmail4">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4" class="col-form-label">Sobrenome</label>
                                                <input required="required" type="text" name="doc_lname" class="form-control" id="inputPassword4">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2" style="display:none">
                                            <?php 
                                                $length = 5;    
                                                $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                            ?>
                                            <label for="inputZip" class="col-form-label">Cédula</label>
                                            <input type="text" name="doc_number" value="<?php echo $patient_number;?>" class="form-control" id="inputZip">
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAddress" class="col-form-label">Email</label>
                                            <input required="required" type="email" class="form-control" name="doc_email" id="inputAddress">
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity" class="col-form-label">Password</label>
                                                <input required="required" type="password" name="doc_pwd" class="form-control" id="inputCity">
                                            </div>
                                        </div>

                                        <button type="submit" name="add_doc" class="ladda-button btn btn-success" data-style="expand-right">Adicionar Médico</button>
                                    </form>
                                </div> <!-- fim do card-body -->
                            </div> <!-- fim do card-->
                        </div> <!-- fim da coluna -->
                    </div>
                    <!-- fim do formulário para adicionar médico -->

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
