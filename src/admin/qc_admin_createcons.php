<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Recuperar a lista de pacientes
$result_pacientes = $mysqli->query("SELECT pat_id, pat_fname FROM his_patients");
$pacientes = $result_pacientes->fetch_all(MYSQLI_ASSOC);

// Recuperar a lista de médicos
$result_medicos = $mysqli->query("SELECT doc_id, doc_fname FROM his_docs");
$medicos = $result_medicos->fetch_all(MYSQLI_ASSOC);

// Função para agendar uma nova consulta
function agendarConsulta($conn, $nome_paciente, $data_consulta, $hora_consulta, $medico_id, $razao_consulta) {
    // Preparar a declaração SQL
    $stmt = $conn->prepare("INSERT INTO his_medical_records (mdr_pat_name, mdr_pat_number, mdr_date_rec, mdr_doc_id, mdr_reason) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Vincular os parâmetros
    $stmt->bind_param("ssssi", $nome_paciente, $numero_paciente, $data_hora_consulta, $medico_id, $razao_consulta);

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
    $medico_id = $_POST["medico_id"];
    $razao_consulta = $_POST["razao_consulta"];

    // Chamar a função para agendar a consulta
    agendarConsulta($mysqli, $nome_paciente, $data_consulta, $hora_consulta, $medico_id, $razao_consulta);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueryCare</title>
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
                                                <label for="medico_id">Médico</label>
                                                <select name="medico_id" class="form-control" required>
                                                    <option value="">Selecione o Médico</option>
                                                    <?php foreach ($medicos as $medico): ?>
                                                        <option value="<?php echo $medico['doc_id']; ?>"><?php echo $medico['doc_fname']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="razao_consulta">Motivo da Consulta</label>
                                                <select name="razao_consulta" class="form-control" required>
                                                    <option value="">Selecione o Motivo</option>
                                                    <option value="Importante">Importante</option>
                                                    <option value="Importante Nível 2">Importante Nível 2</option>
                                                    <option value="Importante Nível 3">Importante Nível 3</option>
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
