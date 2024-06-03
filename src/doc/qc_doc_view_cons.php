<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Verificar se o ID do médico está definido na sessão
if(isset($_SESSION['doc_id'])) {
    // Obtendo o ID do médico logado
    $doc_id = $_SESSION['doc_id'];

    // Consulta SQL para obter as consultas agendadas para o médico logado
    $sql = "SELECT * FROM his_medical_records WHERE mdr_doc_id = $doc_id";
    $result = $mysqli->query($sql);

    if ($result) {
        // Resultados da consulta estão disponíveis
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Consultas Agendadas</title>
            <?php include('assets/inc/head.php');?>
        </head>
        <body>
            <!-- Begin page -->
            <div id="wrapper">
                <!-- Topbar Start -->
                <?php include('assets/inc/nav.php');?>
                <!-- end Topbar -->
                <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
                <!-- Left Sidebar End -->
                <!-- ============================================================== -->
                <!-- Start Page Content here -->
                <!-- ============================================================== -->
                <div class="content-page">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="header-title mb-4" style="font-size: 28px;">Consultas Agendadas</h2>
                                            <div class="table-responsive">
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nome do Paciente</th>
                                                            <th>Data da Consulta</th>
                                                            <th>Motivo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Verificar se existem resultados da consulta
                                                        if ($result->num_rows > 0) {
                                                            // Loop através de cada linha de resultado
                                                            while($row = $result->fetch_assoc()) {
                                                                // Exibir os dados na tabela
                                                                echo "<tr>";
                                                                echo "<td>" . $row["mdr_id"] . "</td>";
                                                                echo "<td>" . $row["mdr_pat_name"] . "</td>";
                                                                echo "<td>" . $row["mdr_date_rec"] . "</td>";
                                                                echo "<td>" . $row["mdr_reason"] . "</td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            // Se não houver consultas agendadas, exibir uma mensagem na tabela
                                                            echo "<tr><td colspan='4'>Nenhuma consulta agendada! </td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Page content -->
                <!-- ============================================================== -->
                <!-- Right bar overlay-->
                <div class="rightbar-overlay"></div>
                <!-- Vendor js -->
                <script src="assets/js/vendor.min.js"></script>
                <!-- Footable js -->
                <script src="assets/libs/footable/footable.all.min.js"></script>
                <!-- Init js -->
                <script src="assets/js/pages/foo-tables.init.js"></script>
                <!-- App js -->
                <script src="assets/js/app.min.js"></script>
                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->
            </div>
            <!-- END wrapper -->
        </body>
        </html>
        <?php
    } else {
        // Se houver um erro na consulta SQL, exibir mensagem de erro
        echo "Erro na consulta SQL: " . $mysqli->error;
    }
} else {
    // Se o ID do médico não estiver definido na sessão, redirecionar para a página de login
    header("Location: login.php");
    exit();
}
?>
