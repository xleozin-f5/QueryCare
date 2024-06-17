<?php
	// Inicia a sessão
	session_start();
	// Inclui o ficheiro de configuração e de verificação de login
	include('assets/inc/config.php');
	include('assets/inc/checklogin.php');
	// Verifica se o utilizador está autenticado
	check_login();
	// Obtém o ID do administrador a partir da sessão
	$aid=$_SESSION['ad_id'];
	// Verifica se o parâmetro 'delete' está definido na URL
	if(isset($_GET['delete']))
	{
		// Obtém o ID do paciente a eliminar da URL
		$id=intval($_GET['delete']);
		// Prepara a query SQL para eliminar o registo do paciente
		$adn="delete from his_patients where pat_id=?";
		$stmt= $mysqli->prepare($adn);
		$stmt->bind_param('i',$id);
		$stmt->execute();
		$stmt->close();	 
  
		// Verifica se a query foi executada com sucesso
		if($stmt)
		{
			$success = "Registo do Paciente Eliminado";
		}
		else
		{
			$err = "Por favor, tente novamente mais tarde";
		}
    }
?>
<!-- Fim do lado do servidor -->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="pt">

<!-- Cabeçalho -->
<?php include('assets/inc/head.php');?>

<body>

    <!-- Início da página -->
    <div id="wrapper">

        <!-- Barra superior -->
        <?php include("assets/inc/nav.php");?>
        <!-- Fim da barra superior -->

        <!-- Barra lateral esquerda -->
        <?php include("assets/inc/sidebar.php");?>
        <!-- Fim da barra lateral esquerda -->

        <!-- Início do conteúdo da página -->
        <div class="content-page">
            <div class="content">

                <!-- Início do conteúdo -->
                <div class="container-fluid">

                    <!-- Título da página -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="qc_admin_dashboard.php">Painel</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
                                        <li class="breadcrumb-item active">Adicionar Pacientes</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Adicionar Detalhes do Paciente</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Fim do título da página -->

                    <!-- Linha do formulário -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Preencha Todos os Campos</h4>
                                    <!-- Formulário de adicionar paciente -->
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4" class="col-form-label">Primeiro Nome</label>
                                                <input type="text" required="required" name="pat_fname" class="form-control" id="inputEmail4" placeholder="Primeiro Nome do Paciente">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4" class="col-form-label">Sobrenome</label>
                                                <input required="required" type="text" name="pat_lname" class="form-control" id="inputPassword4" placeholder="Sobrenome do Paciente">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4" class="col-form-label">Data de Nascimento</label>
                                                <input type="text" required="required" name="pat_dob" class="form-control" id="inputEmail4" placeholder="DD/MM/AAAA">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAddress" class="col-form-label">Endereço</label>
                                            <input required="required" type="text" class="form-control" name="pat_addr" id="inputAddress" placeholder="Endereço do Paciente">
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="inputCity" class="col-form-label">Número de Telemóvel</label>
                                                <input required="required" type="text" name="pat_phone" class="form-control" id="inputCity">
                                            </div>
                                            <div class="form-group col-md-2" style="display:none">
                                                <?php 
                                                    // Gera um número de paciente aleatório
                                                    $length = 5;    
                                                    $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                ?>
                                                <label for="inputZip" class="col-form-label">Número do Paciente</label>
                                                <input type="text" name="pat_number" value="<?php echo $patient_number;?>" class="form-control" id="inputZip">
                                            </div>
                                        </div>

                                        <button type="submit" name="add_patient" class="ladda-button btn btn-primary" data-style="expand-right">Adicionar Paciente</button>

                                    </form>
                                    <!-- Fim do formulário de adicionar paciente -->
                                </div> <!-- Fim do corpo do cartão -->
                            </div> <!-- Fim do cartão -->
                        </div> <!-- Fim da coluna -->
                    </div>
                    <!-- Fim da linha do formulário -->

                </div> <!-- Fim do contentor -->

            </div> <!-- Fim do conteúdo -->

            <!-- Rodapé -->
            <?php include('assets/inc/footer.php');?>
            <!-- Fim do rodapé -->

        </div>

        <!-- Fim do conteúdo da página -->
    </div>
    <!-- Fim da página -->


    <!-- Sobreposição da barra lateral direita -->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js-->
    <script src="assets/js/app.min.js"></script>

    <!-- Loading buttons js -->
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>

    <!-- Buttons init js-->
    <script
