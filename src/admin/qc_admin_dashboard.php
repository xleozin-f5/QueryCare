<?php
  // Iniciar a sessão
  session_start();
  // Incluir ficheiro de configuração
  include('assets/inc/config.php');
  // Incluir verificação de login
  include('assets/inc/checklogin.php');
  check_login();
  // Obter ID do administrador da sessão
  $aid=$_SESSION['ad_id'];
?>
<!DOCTYPE html>
<html lang="en">

<!-- Início do cabeçalho -->
<?php include("assets/inc/head.php");?>

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
        <div class="content-page">
            <div class="content">

                <!-- Início do conteúdo -->
                <div class="container-fluid">

                    <!-- Início do título da página -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">QueryCare - Painel de Gestão Hospitalar</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Fim do título da página -->

                    <!-- Início das métricas principais -->
                    <div class="row">
                        <!-- Início da métrica de pacientes internados -->
                        <div class="col-md-6 col-xl-4">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="mdi mdi-hotel font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <?php
                                                // Código para somar o número de pacientes internados
                                                $result ="SELECT count(*) FROM his_patients WHERE pat_type = 'InPatient' ";
                                                $stmt = $mysqli->prepare($result);
                                                $stmt->execute();
                                                $stmt->bind_result($inpatient);
                                                $stmt->fetch();
                                                $stmt->close();
                                            ?>
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $inpatient;?></span></h3>
                                            <p class="text-muted mb-1 text-truncate">Utentes</p>
                                        </div>
                                    </div>
                                </div> <!-- Fim da linha -->
                            </div> <!-- Fim do widget-rounded-circle -->
                        </div> <!-- Fim da coluna -->
                        <!-- Fim da métrica de pacientes internados -->

                        <!-- Início da métrica de funcionários -->
                        <div class="col-md-6 col-xl-4">
                            <div class="widget-rounded-circle card-box">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="mdi mdi-doctor font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <?php
                                                // Código para somar o número de funcionários
                                                $result ="SELECT count(*) FROM his_docs ";
                                                $stmt = $mysqli->prepare($result);
                                                $stmt->execute();
                                                $stmt->bind_result($doc);
                                                $stmt->fetch();
                                                $stmt->close();
                                            ?>
                                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $doc;?></span></h3>
                                            <p class="text-muted mb-1 text-truncate">Médicos</p>
                                        </div>
                                    </div>
                                </div> <!-- Fim da linha -->
                            </div> <!-- Fim do widget-rounded-circle -->
                        </div> <!-- Fim da coluna -->
                        <!-- Fim da métrica de funcionários -->

                    </div>
                    <!-- Fim das métricas principais -->

                    <!-- Início da secção de médicos recentemente empregados -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card-box">
                                <h4 class="header-title mb-3">Médicos do Hospital</h4>

                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">

                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2">Foto</th>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Departamento</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            // SQL para obter os dez médicos de forma aleatória
                                            $ret="SELECT * FROM his_docs ORDER BY RAND() LIMIT 10 "; 
                                            $stmt= $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res=$stmt->get_result();
                                            while($row=$res->fetch_object()) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td style="width: 36px;">
                                                    <img src="../doc/assets/images/users/<?php echo $row->doc_dpic;?>" alt="img" title="contact-img" class="rounded-circle avatar-sm" />
                                                </td>
                                                <td></td>
                                                <td><?php echo $row->doc_fname;?> <?php echo $row->doc_lname;?></td>
                                                <td><?php echo $row->doc_email;?></td>
                                                <td><?php echo $row->doc_dept;?></td>
                                                <td>
                                                    <a href="qc_admin_view_single_employee.php?doc_id=<?php echo $row->doc_id;?>&&doc_number=<?php echo $row->doc_number;?>" class="btn btn-xs btn-primary"><i class="mdi mdi-eye"></i> Ver</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- Fim da coluna -->
                    </div>
                    <!-- Fim da secção de médicos recentemente empregados -->

                </div> <!-- Fim do container -->
            </div> <!-- Fim do conteúdo -->

            <!-- Início do rodapé -->
            <?php include('assets/inc/footer.php');?>
            <!-- Fim do rodapé -->

        </div>
        <!-- Fim do conteúdo da página -->

    </div>
    <!-- Fim do wrapper -->

    <!-- Barra direita -->
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="dripicons-cross noti-icon"></i>
            </a>
            <h5 class="m-0 text-white">Configurações</h5>
        </div>
        <div class="slimscroll-menu">
            <!-- Caixa de usuário -->
            <div class="user-box">
                <div class="user-img">
                    <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                    <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                </div>

                <h5><a href="javascript: void(0);">Geneva Kennedy</a> </h5>
                <p class="text-muted mb-0"><small>Admin Head</small></p>
            </div>

            <!-- Configurações -->
            <hr class="mt-0" />
            <h5 class="pl-3">Configurações Básicas</h5>
            <hr class="mb-0" />

            <div class="p-3">
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox1" type="checkbox" checked>
                    <label for="Rcheckbox1">
                        Notificações
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox2" type="checkbox" checked>
                    <label for="Rcheckbox2">
                        Acesso à API
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox3" type="checkbox">
                    <label for="Rcheckbox3">
                        Atualizações Automáticas
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-2">
                    <input id="Rcheckbox4" type="checkbox" checked>
                    <label for="Rcheckbox4">
                        Status Online
                    </label>
                </div>
                <div class="checkbox checkbox-primary mb-0">
                    <input id="Rcheckbox5" type="checkbox" checked>
                    <label for="Rcheckbox5">
                        Pagamento Automático
                    </label>
                </div>
            </div>

            <!-- Linha do tempo -->
            <hr class="mt-0" />
            <h5 class="px-3">Mensagens <span class="float-right badge badge-pill badge-danger">25</span></h5>
            <hr class="mb-0" />
            <div class="p-3">
                <div class="inbox-widget">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                        <p class="inbox-item-text">I've finished it! See you so...</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                        <p class="inbox-item-text">Nice to meet you</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                        <p class="inbox-item-text">Hey! there I'm available...</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="assets/images/users/user-6.jpg" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                    </div>
                </div> <!-- Fim do inbox-widget -->
            </div> <!-- Fim do .p-3 -->
        </div> <!-- Fim do slimscroll-menu -->
    </div>
    <!-- Fim da barra direita -->

    <!-- Overlay da barra direita -->
    <div class="rightbar-overlay"></div>

    <!-- Ficheiros JavaScript -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Plugins JS -->
    <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
    <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/libs/flot-charts/jquery.flot.js"></script>
    <script src="assets/libs/flot-charts/jquery.flot.time.js"></script>
    <script src="assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
    <script src="assets/libs/flot-charts/jquery.flot.selection.js"></script>
    <script src="assets/libs/flot-charts/jquery.flot.crosshair.js"></script>

    <!-- Inicialização do dashboard 1 JS -->
    <script src="assets/js/pages/dashboard-1.init.js"></script>

    <!-- App JS -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
