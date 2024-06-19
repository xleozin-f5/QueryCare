<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Recuperar as consultas agendadas
function obterConsultas($conn) {
    $sql = "SELECT mdr_id, mdr_pat_name, mdr_pat_number, mdr_date_rec, mdr_doc_id, mdr_reason 
            FROM his_medical_records";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

$consultas = obterConsultas($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueryCare</title>
    <?php include('assets/inc/head.php');?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-2mBE1PjHb02PwpsBKrVRBUcuv3wG7UhA2t+18+1xUFJ03KqFuV4FgH26clA0jp/2oLZKo7H2x9IuWwb6pW7quw==" crossorigin="anonymous" />
</head>
<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php');?>
        <?php include("assets/inc/sidebar.php");?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="header-title mb-4" style="font-size: 28px;">Consultas Agendadas</h2>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nome do Paciente</th>
                                                <th>Data e Hora da Consulta</th>
                                                <th>Médico</th>
                                                <th>Motivo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($consultas) > 0): ?>
                                                <?php foreach ($consultas as $consulta): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($consulta['mdr_pat_name'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($consulta['mdr_date_rec'] ?? ''); ?></td>
                                                        <td>
                                                            <?php
                                                                $medico_id = $consulta['mdr_doc_id'] ?? null;
                                                                if ($medico_id) {
                                                                    $medico_result = $mysqli->query("SELECT doc_fname FROM his_docs WHERE doc_id = '$medico_id'");
                                                                    $medico = $medico_result->fetch_assoc();
                                                                    echo htmlspecialchars($medico['doc_fname'] ?? '');
                                                                } else {
                                                                    echo '';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($consulta['mdr_reason'] ?? ''); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6">Nenhuma consulta agendada encontrada.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rightbar-overlay"></div>

        <script src="assets/js/vendor.min.js"></script>
    </div>
</body>
</html>
