<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Recuperar o ID do médico logado
if(isset($_SESSION['doc_id'])) {
    $doc_id = $_SESSION['doc_id'];

    // Recuperar a lista de pacientes
    $result_pacientes = $mysqli->query("SELECT pat_id, pat_fname FROM his_patients");
    $pacientes = $result_pacientes->fetch_all(MYSQLI_ASSOC);

    // Função para agendar uma nova consulta
    function agendarConsulta($conn, $nome_paciente, $data_consulta, $hora_consulta, $medico_id, $razao_consulta) {
        // Preparar a declaração SQL
        $stmt = $conn->prepare("INSERT INTO his_medical_records (mdr_doc_id, mdr_pat_id, mdr_date_rec, mdr_time_rec, mdr_reason) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            die('Erro na preparação da consulta: ' . $conn->error);
        }

        // Vincular os parâmetros
        $stmt->bind_param("iisss", $medico_id, $nome_paciente, $data_consulta, $hora_consulta, $razao_consulta);

        // Executar a declaração SQL
        if (!$stmt->execute()) {
            die('Erro na execução da consulta: ' . $stmt->error);
        }

        // Fechar a declaração
        $stmt->close();
    }

    // Verificar se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome_paciente = $_POST["nome_paciente"];
        $data_consulta = $_POST["data_consulta"];
        $hora_consulta = $_POST["hora_consulta"];
        $razao_consulta = $_POST["razao_consulta"];

        // Chamar a função para agendar a consulta
        agendarConsulta($mysqli, $nome_paciente, $data_consulta, $hora_consulta, $doc_id, $razao_consulta);
    }
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
    <title>Marcar Consulta</title>
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
                                    <h2 class="header-title mb-4" style="font-size: 28px;">Marcar Consulta</h2>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome_paciente">Paciente</label>
                                                <select name="nome_paciente" class="form-control" required>
                                                    <option value="">Selecione o Paciente</option>
                                                    <?php foreach ($pacientes as $paciente): ?>
                                                        <option value="<?php echo $paciente['pat_id']; ?>"><?php echo $paciente['pat_fname']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="data_consulta">Data da Consulta</label>
                                                <input type="date" name="data_consulta" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hora_consulta">Hora da Consulta</label>
                                                <input type="time" name="hora_consulta" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="razao_consulta">Motivo da Consulta</label>
                                                <select name="razao_consulta" class="form-control" required>
                                                    <option value="">Selecione o Motivo</option>
                                                    <option value="Importante">Importante</option>
                                                    <option value="Rotina">Rotina</option>
                                                    <option value="Emergência">Emergência</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Marcar Consulta</button>
                                        </div>
                                    </form>
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
