<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$pat_number = $_SESSION['pat_number'];

// Consulta SQL para contar o número de consultas agendadas para o paciente atual
$sql_count = "SELECT COUNT(*) AS total_consultas FROM his_medical_records WHERE mdr_pat_number = ?";
$stmt_count = $mysqli->prepare($sql_count);
$stmt_count->bind_param('s', $pat_number);
$stmt_count->execute();
$stmt_count->bind_result($total_consultas);
$stmt_count->fetch();
$stmt_count->close();

// Consulta SQL para obter as consultas agendadas para o paciente atual
$sql = "SELECT m.mdr_id, m.mdr_pat_name, DATE_FORMAT(m.mdr_date_rec, '%Y-%m-%d %H:%i:%s') AS formatted_date, m.mdr_reason, d.doc_fname 
        FROM his_medical_records m
        INNER JOIN his_docs d ON m.mdr_doc_id = d.doc_id
        WHERE m.mdr_pat_number = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $pat_number);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueryCare - Painel do Paciente</title>
    <?php include("assets/inc/head.php"); ?>
</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('assets/inc/nav.php'); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">QueryCare - Painel do Paciente</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <!-- Patient Information -->
                        <div class="col-xl-6">
                            <div class="card-box">
                                <h4 class="header-title mb-3">Informações do Paciente</h4>
                                <!-- Exibir informações do paciente -->
                                <p>Nº. Utente de Saúde: <?php echo $pat_number; ?></p>
                                <!-- Você pode adicionar mais informações do paciente aqui -->
                            </div>
                        </div>
                        <!-- end Patient Information -->

<!-- Consultas Agendadas -->
<div class="col-xl-6">
    <div class="widget-rounded-circle card-box">
        <div class="row">
            <div class="col-6">
                <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                    <i class="mdi mdi-calendar-check font-22 avatar-title text-primary"></i>
                </div>
            </div>
            <div class="col-6">
                <div class="text-right">
                    <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $total_consultas; ?></span></h3>
                    <p class="text-muted mb-1 text-truncate">Consultas Agendadas</p>
                </div>
            </div>
        </div> <!-- Fim da linha -->
    </div> <!-- Fim do widget-rounded-circle -->
</div> <!-- Fim da coluna -->
<!-- Fim de Consultas Agendadas -->
                    </div>

                    <div class="row">
                        <!-- Adicionar mais seções para recursos ou informações do paciente aqui -->
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include('assets/inc/footer.php'); ?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <!-- Conteúdo da barra lateral direita -->
    </div>
    <!-- /Right-bar -->
    <!-- Overlay da barra lateral direita-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js-->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
