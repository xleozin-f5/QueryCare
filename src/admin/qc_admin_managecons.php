<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Verificar se o ID da consulta a ser editada ou excluída foi passado via GET
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $consulta_id = $_GET['id'];

    // Se a ação for 'delete', excluir a consulta
    if($action == 'delete') {
        $stmt = $mysqli->prepare("DELETE FROM his_medical_records WHERE mdr_id = ?");
        $stmt->bind_param("i", $consulta_id);
        $stmt->execute();
        $stmt->close();

        // Redirecionar de volta para a página de gerenciamento após excluir a consulta
        header("Location: qc_admin_managecons.php");
        exit();
    }
}

// Recuperar todas as consultas agendadas
$result = $mysqli->query("SELECT mdr_id, mdr_pat_name, mdr_pat_number, mdr_date_rec, mdr_doc_id, mdr_reason FROM his_medical_records");
$consultas = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Consultas</title>
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
                                    <h2 class="header-title mb-4" style="font-size: 28px;">Gerenciar Consultas</h2>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome do Paciente</th>
                                                <th>Número do Paciente</th>
                                                <th>Data e Hora da Consulta</th>
                                                <th>Médico</th>
                                                <th>Motivo</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($consultas as $consulta): ?>
                                                <tr>
                                                    <td><?php echo isset($consulta['mdr_id']) ? htmlspecialchars($consulta['mdr_id']) : ''; ?></td>
                                                    <td><?php echo isset($consulta['mdr_pat_name']) ? htmlspecialchars($consulta['mdr_pat_name']) : ''; ?></td>
                                                    <td><?php echo isset($consulta['mdr_pat_number']) ? htmlspecialchars($consulta['mdr_pat_number']) : ''; ?></td>
                                                    <td><?php echo isset($consulta['mdr_date_rec']) ? htmlspecialchars($consulta['mdr_date_rec']) : ''; ?></td>
                                                    <td>
                                                        <?php
                                                            // Verificar se $medico_id não é nulo antes de acessar
                                                            $medico_id = isset($consulta['mdr_doc_id']) ? $consulta['mdr_doc_id'] : null;
                                                            $medico_result = $mysqli->query("SELECT doc_fname FROM his_docs WHERE doc_id = '$medico_id'");
                                                            $medico = $medico_result->fetch_assoc();
                                                            echo isset($medico['doc_fname']) ? htmlspecialchars($medico['doc_fname']) : '';
                                                        ?>
                                                    </td>
                                                    <td><?php echo isset($consulta['mdr_reason']) ? htmlspecialchars($consulta['mdr_reason']) : ''; ?></td>
                                                    <td>
                                                        <a href="editar_consulta.php?id=<?php echo $consulta['mdr_id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                                        <a href="qc_admin_managecons.php?action=delete&id=<?php echo $consulta['mdr_id']; ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Excluir</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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
