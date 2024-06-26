<?php
  // Inicia a sessão
  session_start();
  // Inclui arquivos de configuração e de verificação de login
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  // Verifica se o usuário está logado
  check_login();
  // Obtém o ID do administrador da sessão
  $aid=$_SESSION['ad_id'];
  
  // Verifica se o parâmetro 'delete' foi enviado por GET
  if(isset($_GET['delete']))
  {
        // Obtém o ID do paciente a ser excluído
        $id=intval($_GET['delete']);
        // Prepara a consulta para excluir o paciente pelo ID
        $adn="delete from his_patients where pat_id=?";
        $stmt= $mysqli->prepare($adn);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();	 
  
          if($stmt)
          {
            // Mensagem de sucesso ao excluir os registros do paciente
            $success = "Registos dos Pacientes Eliminados";
          }
            else
            {
                // Mensagem de erro ao excluir os registros do paciente
                $err = "Tente Novamente Mais Tarde";
            }
    }
?>

<!DOCTYPE html>
<html lang="pt">
    
<?php include('assets/inc/head.php');?>

    <body>

        <!-- Início da página -->
        <div id="wrapper">

            <!-- Topbar -->
                <?php include('assets/inc/nav.php');?>
            <!-- Fim do Topbar -->

            <!-- Barra Lateral Esquerda -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Fim da Barra Lateral Esquerda -->

            <!-- Conteúdo da Página -->
            <div class="content-page">
                <div class="content">

                    <!-- Conteúdo Inicial -->
                    <div class="container-fluid">
                        
                        <!-- Título da Página -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Painel</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
                                            <li class="breadcrumb-item active">Gerir Pacientes</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Gerenciar Detalhes do Paciente</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- Fim do Título da Página --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"></h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                <div class="form-group mr-2" style="display:none">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Mostrar tudo</option>
                                                        <option value="Alta">Alta</option>
                                                        <option value="Consulta Externa">Consulta Externa</option>
                                                        <option value="Internamento">Internamento</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="demo-foo-search" type="text" placeholder="Pesquisar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">Pacientes</th>
                                                <th data-hide="phone">Nº. Utente de Saúde</th>
                                                <th data-hide="phone">Morada</th>
                                                <th data-hide="phone">Ação</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                Obtém detalhes de todos os pacientes
                                            */
                                                $ret="SELECT * FROM  his_patients ORDER BY RAND() "; 
                                                // Consulta SQL para obter até dez pacientes aleatoriamente
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>

                                                <tbody>
                                                <tr>
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></td>
                                                    <td><?php echo $row->pat_number;?></td>
                                                    <td><?php echo $row->pat_addr;?></td>
                                                    
                                                    <td>
                                                        <!-- Botões de ação -->
                                                        <a href="qc_admin_manage_patient.php?delete=<?php echo $row->pat_id;?>" class="badge badge-danger"><i class=" mdi mdi-trash-can-outline "></i> Apagar</a>
                                                        <a href="qc_admin_view_single_patient.php?pat_id=<?php echo $row->pat_id;?>&&pat_number=<?php echo $row->pat_number;?>" class="badge badge-success"><i class="mdi mdi-eye"></i> Ver</a>
                                                        <a href="qc_admin_update_single_patient.php?pat_id=<?php echo $row->pat_id;?>" class="badge badge-primary"><i class="mdi mdi-check-box-outline "></i> Atualizar</a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="8">
                                                    <div class="text-right">
                                                        <!-- Paginação -->
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer -->
                 <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- Fim do Conteúdo da Página -->

        </div>
        <!-- Fim do wrapper -->


        <!-- Overlay da Barra Lateral Direita -->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

</body>

</html>
                                     