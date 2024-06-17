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
        // Obtém o ID do médico a ser excluído
        $id=intval($_GET['delete']);
        // Prepara a consulta para excluir o médico pelo ID
        $adn="delete from his_docs where doc_id=?";
        $stmt= $mysqli->prepare($adn);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->close();	 
  
          if($stmt)
          {
            // Mensagem de sucesso ao excluir o médico
            $success = "Médico excluído";
          }
            else
            {
                // Mensagem de erro ao excluir o médico
                $err = "Tente mais tarde";
            }
    }
?>

<!DOCTYPE html>
<html lang="en">

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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Painel;</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Médico</a></li>
                                        <li class="breadcrumb-item active">Gerir Médico</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Gerenciar Detalhes do Médico</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Fim do Título da Página -->

                    <!-- Tabela de Médicos -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title"></h4>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-12 text-sm-center form-inline">
                                            <div class="form-group mr-2" style="display:none">
                                                <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                    <option value="">Show all</option>
                                                    <option value="Discharged">Discharged</option>
                                                    <option value="OutPatients">OutPatients</option>
                                                    <option value="InPatients">InPatients</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">Nome</th>
                                                <th data-hide="phone">Cedula</th>
                                                <th data-hide="phone">Email</th>
                                                <th data-hide="phone">Ação</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            /*
                                                Obtém detalhes de todos os médicos
                                            */
                                                $ret="SELECT * FROM  his_docs ORDER BY RAND() "; 
                                                // Consulta SQL para obter até dez médicos aleatoriamente
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
                                                <td><?php echo $row->doc_fname;?> <?php echo $row->doc_lname;?></td>
                                                <td><?php echo $row->doc_number;?></td>
                                                <td><?php echo $row->doc_email;?></td>

                                                <td>
                                                    <!-- Botões de ação -->
                                                    <a href="qc_admin_manage_employee.php?delete=<?php echo $row->doc_id;?>" class="badge badge-danger"><i class=" mdi mdi-trash-can-outline "></i> Apagar</a>
                                                    <a href="qc_admin_view_single_employee.php?doc_id=<?php echo $row->doc_id;?>&&doc_number=<?php echo $row->doc_number;?>" class="badge badge-success"><i class="mdi mdi-eye"></i> Ver</a>
                                                    <a href="qc_admin_update_single_employee.php?doc_number=<?php echo $row->doc_number;?>" class="badge badge-primary"><i class="mdi mdi-check-box-outline "></i> Atualizar</a>
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
                    <!-- Fim da Tabela de Médicos -->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer -->
            <?php include('assets/inc/footer.php');?>
            <!-- Fim do Footer -->

        </div>

        <!-- Fim do Conteúdo da Página -->

    </div>
    <!-- Fim do wrapper -->


    <!-- Overlay da Barra Lateral Direita -->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Footable js -->
    <script src="assets/libs/footable/footable.all.min.js
