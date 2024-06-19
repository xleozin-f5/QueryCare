<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Função para recuperar todas as consultas agendadas para o médico logado
function getConsultas($conn, $doc_id) {
    $sql = "SELECT mdr_id, mdr_pat_name, mdr_date_rec, mdr_reason FROM his_medical_records WHERE mdr_doc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doc_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Função para atualizar uma consulta existente
function atualizarConsulta($conn, $consulta_id, $nova_data, $novo_motivo) {
    $stmt = $conn->prepare("UPDATE his_medical_records SET mdr_date_rec = ?, mdr_reason = ? WHERE mdr_id = ?");
    
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("ssi", $nova_data, $novo_motivo, $consulta_id);

    if (!$stmt->execute()) {
        die('Erro na execução da consulta: ' . $stmt->error);
    }

    $stmt->close();
}

// Função para excluir uma consulta existente
function excluirConsulta($conn, $consulta_id) {
    $stmt = $conn->prepare("DELETE FROM his_medical_records WHERE mdr_id = ?");
    
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("i", $consulta_id);

    if (!$stmt->execute()) {
        die('Erro na execução da consulta: ' . $stmt->error);
    }

    $stmt->close();
}

// Verificar se o médico está logado
if(isset($_SESSION['doc_id'])) {
    $doc_id = $_SESSION['doc_id'];

    // Processamento do formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["action"]) && isset($_POST["consulta_id"])) {
            $action = $_POST["action"];
            $consulta_id = $_POST["consulta_id"];

            if ($action == "update") {
                $nova_data = $_POST["nova_data"];
                $novo_motivo = $_POST["novo_motivo"];
                atualizarConsulta($mysqli, $consulta_id, $nova_data, $novo_motivo);
            } elseif ($action == "delete") {
                excluirConsulta($mysqli, $consulta_id);
            }
        }
    }

    // Obter consultas agendadas
    $consultas = getConsultas($mysqli, $doc_id);
} else {
    // Redirecionar se o médico não estiver logado
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Consultas</title>
    <?php include('assets/inc/head.php');?>
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
                                    <?php if (!empty($consultas)): ?>
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nome do Paciente</th>
                                                    <th>Data da Consulta</th>
                                                    <th>Motivo</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($consultas as $consulta): ?>
                                                    <tr>
                                                        <td><?php echo $consulta['mdr_id']; ?></td>
                                                        <td><?php echo $consulta['mdr_pat_name']; ?></td>
                                                        <td><?php echo $consulta['mdr_date_rec']; ?></td>
                                                        <td><?php echo $consulta['mdr_reason']; ?></td>
                                                        <td>
                                                            <!-- Formulário para atualizar consulta -->
                                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                                                <input type="hidden" name="action" value="update">
                                                                <input type="hidden" name="consulta_id" value="<?php echo $consulta['mdr_id']; ?>">
                                                                <input type="date" name="nova_data" class="form-control mb-2" required>
                                                                <select name="novo_motivo" class="form-control mb-2" required>
                                                                    <option value="">Selecione o Motivo</option>
                                                                    <option value="Importante">Importante</option>
                                                                    <option value="Rotina">Rotina</option>
                                                                    <option value="Emergência">Emergência</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-sm btn-primary">Atualizar</button>
                                                            </form>
                                                            <!-- Formulário para excluir consulta -->
                                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="mt-2">
                                                                <input type="hidden" name="action" value="delete">
                                                                <input type="hidden" name="consulta_id" value="<?php echo $consulta['mdr_id']; ?>">
                                                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>Nenhuma consulta agendada.</p>
                                    <?php endif; ?>
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
