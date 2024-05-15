<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Função para atualizar uma consulta existente
function atualizarConsulta($conn, $consulta_id, $nova_data, $nova_hora) {
    // Preparar a declaração SQL
    $stmt = $conn->prepare("UPDATE his_medical_records SET mdr_date_rec = ? WHERE mdr_id = ?");
    $nova_data_hora = $nova_data . ' ' . $nova_hora;
    $stmt->bind_param("si", $nova_data_hora, $consulta_id);

    // Executar a declaração SQL
    if ($stmt->execute() === TRUE) {
        // Consulta atualizada com sucesso
        return true;
    } else {
        // Erro ao atualizar a consulta
        return false;
    }

    // Fechar declaração
    $stmt->close();
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consulta_id = $_POST["consulta_id"];
    $nova_data = $_POST["nova_data"];
    $nova_hora = $_POST["nova_hora"];

    // Chamar a função para atualizar a consulta
    if (atualizarConsulta($mysqli, $consulta_id, $nova_data, $nova_hora)) {
        // Consulta atualizada com sucesso
        echo "Consulta atualizada com sucesso!";
    } else {
        // Erro ao atualizar a consulta
        echo "Erro ao atualizar a consulta.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Consulta</title>
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
                                    <h2 class="header-title mb-4" style="font-size: 28px;">Atualizar Consulta</h2>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="consulta_id">ID da Consulta</label>
                                                <input type="text" name="consulta_id" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nova_data">Nova Data da Consulta</label>
                                                <input type="date" name="nova_data" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nova_hora">Nova Hora da Consulta</label>
                                                <input type="time" name="nova_hora" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Atualizar Consulta</button>
                                        </div>
                                    </form>
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
