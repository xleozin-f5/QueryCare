<?php
    // Iniciar a sessão
    session_start();
    // Incluir o ficheiro de configuração
    include('assets/inc/config.php');

    // Atualizar o perfil
    if(isset($_POST['update_profile'])) {
        $ad_fname = $_POST['ad_fname'];
        $ad_lname = $_POST['ad_lname'];
        $ad_id = $_SESSION['ad_id'];
        $ad_email = $_POST['ad_email'];
        $ad_dpic = $_FILES["ad_dpic"]["name"];
        
        // Mover a imagem de perfil para a pasta de imagens de utilizadores
        move_uploaded_file($_FILES["ad_dpic"]["tmp_name"], "assets/images/users/" . $_FILES["ad_dpic"]["name"]);

        // SQL para atualizar os valores capturados
        $query = "UPDATE his_admin SET ad_fname=?, ad_lname=?, ad_email=?, ad_dpic=? WHERE ad_id=?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssssi', $ad_fname, $ad_lname, $ad_email, $ad_dpic, $ad_id);
        $stmt->execute();

        // Verificar se a atualização foi bem-sucedida
        if($stmt) {
            $success = "Perfil atualizado com sucesso";
        } else {
            $err = "Por favor, tente novamente mais tarde";
        }
    }

    // Alterar a palavra-passe
    if(isset($_POST['update_pwd'])) {
        $ad_id = $_SESSION['ad_id'];
        $ad_pwd = sha1(md5($_POST['ad_pwd'])); // Dupla encriptação

        // SQL para atualizar a palavra-passe
        $query = "UPDATE his_admin SET ad_pwd=? WHERE ad_id=?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('si', $ad_pwd, $ad_id);
        $stmt->execute();

        // Verificar se a atualização foi bem-sucedida
        if($stmt) {
            $success = "Palavra-passe atualizada com sucesso";
        } else {
            $err = "Por favor, tente novamente mais tarde";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php');?>

<body>
    <!-- Início da página -->
    <div id="wrapper">

        <!-- Início da barra superior -->
        <?php include('assets/inc/nav.php');?>
        <!-- Fim da barra superior -->

        <!-- Início da barra lateral esquerda -->
        <?php include('assets/inc/sidebar.php');?>
        <!-- Fim da barra lateral esquerda -->

        <!-- Início do conteúdo da página -->
        <?php
            $aid = $_SESSION['ad_id'];
            $ret = "SELECT * FROM his_admin WHERE ad_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();

            // Loop para obter os dados do utilizador
            while($row = $res->fetch_object()) {
        ?>
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $row->ad_fname;?> <?php echo $row->ad_lname;?>'s Profile</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Fim do título da página -->

                    <div class="row">
                        <!-- Início da coluna esquerda -->
                        <div class="col-lg-4 col-xl-4">
                            <div class="card-box text-center">
                                <img src="assets/images/users/<?php echo $row->ad_dpic;?>" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                                <h4 class="mb-0"><?php echo $row->ad_fname;?> <?php echo $row->ad_lname;?></h4>
                                <p class="text-muted">@System_Administrator_HMIS</p>
                                <div class="text-left mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Nome Completo:</strong> <span class="ml-2"><?php echo $row->ad_fname;?> <?php echo $row->ad_lname;?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span class="ml-2 "><?php echo $row->ad_email;?></span></p>
                                </div>
                            </div> <!-- fim do card-box -->
                        </div> <!-- fim da coluna esquerda -->

                        <!-- Início da coluna direita -->
                        <div class="col-lg-8 col-xl-8">
                            <div class="card-box">
                                <ul class="nav nav-pills navtab-bg nav-justified">
                                    <li class="nav-item">
                                        <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                            Atualizar Perfil
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            Alterar Palavra-passe
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- Início da secção Atualizar Perfil -->
                                    <div class="tab-pane show active" id="aboutme">
                                        <form method="post" enctype="multipart/form-data">
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Informações Pessoais</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">Primeiro Nome</label>
                                                        <input type="text" name="ad_fname" class="form-control" id="firstname" placeholder="<?php echo $row->ad_fname;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Último Nome</label>
                                                        <input type="text" name="ad_lname" class="form-control" id="lastname" placeholder="<?php echo $row->ad_lname;?>">
                                                    </div>
                                                </div> <!-- fim da coluna -->
                                            </div> <!-- fim da linha -->

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="useremail">Endereço de Email</label>
                                                        <input type="email" name="ad_email" class="form-control" id="useremail" placeholder="<?php echo $row->ad_email;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="useremail">Foto de Perfil</label>
                                                        <input type="file" name="ad_dpic" class="form-control btn btn-success" id="useremail" placeholder="<?php echo $row->ad_email;?>">
                                                    </div>
                                                </div>
                                            </div> <!-- fim da linha -->

                                            <div class="text-right">
                                                <button type="submit" name="update_profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Guardar</button>
                                            </div>
                                        </form>
                                    </div> <!-- fim da secção Atualizar Perfil -->

                                    <!-- Início da secção Alterar Palavra-passe -->
                                    <div class="tab-pane" id="settings">
                                        <form method="post">
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Informações Pessoais</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">Palavra-passe Antiga</label>
                                                        <input type="password" class="form-control" id="firstname" placeholder="Introduza a Palavra-passe Antiga">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Nova Palavra-passe</label>
                                                        <input type="password" class="form-control" name="ad_pwd" id="lastname" placeholder="Introduza a Nova Palavra-passe">
                                                    </div>
                                                </div> <!-- fim da coluna -->
                                            </div> <!-- fim da linha -->

                                            <div class="form-group">
                                                <label for="useremail">Confirmar Palavra-passe</label>
                                                <input type="password" class="form-control" id="useremail" placeholder="Confirme a Nova Palavra-passe">
                                            </div>

                                            <div class="text-right">
                                                <button type="submit" name="update_pwd" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Atualizar Palavra-passe</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- fim da secção Alterar Palavra-passe -->

                                </div> <!-- fim do conteúdo das tabulações -->
                            </div> <!-- fim do card-box -->

                        </div> <!-- fim da coluna direita -->
                    </div> <!-- fim da linha -->

                </div> <!-- fim do container -->
            </div> <!-- fim do conteúdo -->

            <!-- Início do rodapé -->
            <?php include("assets/inc/footer.php");?>
            <!-- fim do rodapé -->

        </div>
        <?php }?>
        <!-- Fim do conteúdo da página -->

    </div>
    <!-- Fim do wrapper -->

    <!-- Overlay da barra direita -->
    <div class="rightbar-overlay"></div>

    <!-- Ficheiros JavaScript -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>
</html>
