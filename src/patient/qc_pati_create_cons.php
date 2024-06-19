<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Função para agendar uma nova consulta
function agendarConsulta($conn, $nome_paciente, $numero_paciente, $data_consulta, $hora_consulta, $medico_id, $razao_consulta) {
    // Preparar a declaração SQL
    $stmt = $conn->prepare("INSERT INTO his_medical_records (mdr_pat_name, mdr_pat_number, mdr_date_rec, mdr_doc_id, mdr_reason) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Vincular os parâmetros
    $data_hora_consulta = $data_consulta . ' ' . $hora_consulta;
    $stmt->bind_param("sssss", $nome_paciente, $numero_paciente, $data_hora_consulta, $medico_id, $razao_consulta);

    // Executar a declaração SQL
    if (!$stmt->execute()) {
        die('Erro na execução da consulta: ' . $stmt->error);
    }

    // Fechar a declaração
    $stmt->close();
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar o nome do paciente da sessão
    $nome_paciente = $_SESSION['pat_name'];
    $numero_paciente = $_SESSION['pat_number'];
    $data_consulta = $_POST["data_consulta"];
    $hora_consulta = $_POST["hora_consulta"];
    $medico_id = $_POST["medico_id"];
    $razao_consulta = $_POST["razao_consulta"];

    // Chamar a função para agendar a consulta
    agendarConsulta($mysqli, $nome_paciente, $numero_paciente, $data_consulta, $hora_consulta, $medico_id, $razao_consulta);
}
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
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title">Agendar Consulta</h4>
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="data_consulta">Data da Consulta:</label>
                                        <input type="date" class="form-control" id="data_consulta" name="data_consulta" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="hora_consulta">Hora da Consulta:</label>
                                        <input type="time" class="form-control" id="hora_consulta" name="hora_consulta" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="medico_id">Médico:</label>
                                        <select class="form-control" id="medico_id" name="medico_id" required>
                                            <?php
                                            // Consultar os médicos disponíveis
                                            $stmt = $mysqli->prepare("SELECT doc_id, doc_fname, doc_lname FROM his_docs");
                                            $stmt->execute();
                                            $stmt->bind_result($doc_id, $doc_fname, $doc_lname);
                                            while ($stmt->fetch()) {
                                                echo "<option value='$doc_id'>$doc_fname $doc_lname</option>";
                                            }
                                            $stmt->close();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="razao_consulta">Razão da Consulta:</label>
                                        <textarea class="form-control" id="razao_consulta" name="razao_consulta" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Agendar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('assets/inc/footer.php');?>
        </div>
    </div>
    <div class="rightbar-overlay"></div>
</body>
</html>
