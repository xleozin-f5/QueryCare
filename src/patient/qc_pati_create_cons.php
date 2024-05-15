<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Função para agendar uma nova consulta
function agendarConsulta($conn, $nome_paciente, $endereco_paciente, $idade_paciente, $numero_paciente, $data_consulta) {
    // Preparar a declaração SQL
    $stmt = $conn->prepare("INSERT INTO his_medical_records (mdr_pat_name, mdr_pat_adr, mdr_pat_age, mdr_pat_number, mdr_date_rec) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome_paciente, $endereco_paciente, $idade_paciente, $numero_paciente, $data_consulta);

    // Executar a declaração SQL
    return $stmt->execute();
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_paciente = $_POST["nome_paciente"];
    $endereco_paciente = $_POST["endereco_paciente"];
    $idade_paciente = $_POST["idade_paciente"];
    $numero_paciente = $_POST["numero_paciente"];
    $data_consulta = $_POST["data_consulta"];

    // Chamar a função para agendar a consulta
    agendarConsulta($mysqli, $nome_paciente, $endereco_paciente, $idade_paciente, $numero_paciente, $data_consulta);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Consulta</title>
    <?php include('assets/inc/head.php');?>
    <!-- Link para Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-2mBE1PjHb02PwpsBKrVRBUcuv3wG7UhA2t+18+1xUFJ03KqFuV4FgH26clA0jp/2oLZKo7H2x9IuWwb6pW7quw==" crossorigin="anonymous" />
    <style>
        /* Estilos para o pop-up */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            z-index: 9999;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif;
        }
        .popup.success {
            background-color: #7bed9f;
            border: 2px solid #2ecc71;
        }
        .popup p {
            margin: 0;
            font-size: 16px;
            color: #333;
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
        .popup .icon {
            font-size: 24px;
            color: #2ecc71; /* Cor do ícone de marca de verificação */
            display: inline-block;
            vertical-align: middle;
        }
    </style>
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
                                    <h2 class="header-title mb-4" style="font-size: 28px;">Agendar Consulta</h2>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome_paciente">Nome do paciente</label>
                                                <input type="text" name="nome_paciente" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="data_consulta">Data da consulta</label>
                                                <input type="date" name="data_consulta" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hora_consulta">Hora da consulta</label>
                                                <input type="time" name="hora_consulta" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="motivo">Motivo da consulta</label>
                                                <input type="text" name="motivo" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Agendar Consulta</button>
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

        <!-- Pop-up para consulta agendada com sucesso -->
        <div id="popup" class="popup success">
            <i class="fas fa-check-circle icon"></i>
            <p>Consulta agendada com sucesso!</p>
        </div>

        <!-- Script para mostrar o pop-up -->
        <script>
            // Verificar se a consulta foi agendada com sucesso
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($conn->error)): ?>
                // Mostrar o pop-up
                document.getElementById("popup").style.display = "block";
                // Ocultar o pop-up após 3 segundos
                setTimeout(function() {
                    document.getElementById("popup").style.display = "none";
                }, 3000);
            <?php endif; ?>
        </script>
    </div>
    <!-- END wrapper -->
</body>
</html>