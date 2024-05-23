<?php
	session_start(); // Inicia a sessão
	include('assets/inc/config.php'); // Inclui o ficheiro de configuração

	if(isset($_POST['update_doc'])) // Verifica se o formulário foi submetido
	{
        $email=$_GET['email']; // Obtém o email do URL
        $pwd=sha1(md5($_GET['pwd'])); // Obtém e encripta a nova palavra-passe do URL
        $status = $_POST['status']; // Obtém o estado de reset do formulário

        // SQL para atualizar os valores capturados
        $query="UPDATE his_docs SET doc_pwd =? WHERE doc_email = ?";
        $query1 = "UPDATE his_pwdresets SET status =? WHERE email = ?";
        $stmt = $mysqli->prepare($query);
        $stmt1 = $mysqli->prepare($query1);
        $rc=$stmt->bind_param('ss', $pwd, $email);
        $rs=$stmt1->bind_param('ss', $status, $email);
        $stmt->execute();
        $stmt1->execute();
		
		if($stmt && $stmt1) // Verifica se as queries foram executadas com sucesso
		{
			$success = "Password Updated"; // Define a mensagem de sucesso
		}
        else
        {
			$err = "Please Try Again Or Try Later"; // Define a mensagem de erro
        }
	}
?>
<!-- Fim do lado do servidor -->
<!DOCTYPE html>
<html lang="en">
    
    <!--Cabeçalho-->
    <?php include('assets/inc/head.php');?>
    <body>

        <!-- Início da página -->
        <div id="wrapper">

            <!-- Barra superior -->
            <?php include("assets/inc/nav.php");?>
            <!-- Fim da barra superior -->

            <!-- Barra lateral -->
            <?php include("assets/inc/sidebar.php");?>
            <!-- Fim da barra lateral -->

            <!-- Conteúdo da página -->
            <div class="content-page">
                <div class="content">

                    <!-- Conteúdo -->
                    <div class="container-fluid">
                        
                        <!-- Título da página -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="qc_admin_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Password Resets</a></li>
                                            <li class="breadcrumb-item active">Manage </li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Atualizar Detalhes da Palavra-passe do Funcionário</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- Fim do título da página --> 
                        <!-- Formulário -->
                        <?php
                            $email=$_GET['email']; // Obtém o email do URL
                            $ret="SELECT  * FROM his_pwdresets WHERE email=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$email);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            while($row=$res->fetch_object()) // Loop para obter os dados do funcionário
                            {
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Preencha todos os campos</h4>
                                        <!-- Formulário de atualização de palavra-passe -->
                                        <form method="post" enctype="multipart/form-data">
                                            
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Email</label>
                                                    <input required="required"  type="email" value="<?php echo $row->email;?>" class="form-control" name="doc_email" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Password</label>
                                                    <input required="required"  type="text" value="<?php echo $row->pwd;?>"  name="doc_pwd" class="form-control" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-6" style="display:none">
                                                    <label for="inputCity" class="col-form-label">Reset Status</label>
                                                    <input required="required"  type="text" value="Reset"  name="status" class="form-control" id="inputCity">
                                                </div>  
                                                
                                            </div>                                            

                                            <button type="submit" name="update_doc" class="ladda-button btn btn-success" data-style="expand-right">Atualizar Palavra-passe</button>

                                        </form>
                                        <!-- Fim do formulário de atualização -->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <?php }?>

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Rodapé -->
                <?php include('assets/inc/footer.php');?>
                <!-- Fim do rodapé -->

            </div>

        </div>
        <!-- FIM wrapper -->

       
        <!-- Overlay da barra lateral direita-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Inicialização dos botões -->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>
