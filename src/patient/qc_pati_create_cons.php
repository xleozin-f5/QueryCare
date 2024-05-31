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
    $data_hora_consulta = $data_consulta . ' ' . $hora_consulta . ' ';
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
    $nome_paciente = $_POST["nome_paciente"];
    $numero_paciente = $_POST["numero_paciente"];
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
    <title>Agendar Consulta</title>
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
                                    <h2 class="header-title mb-4" style="font-size: 28px;">Agendar Consulta</h2>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nome_paciente">Nome do paciente</label>
                                                <input type="text" name="nome_paciente" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="numero_paciente">Número do paciente</label>
                                                <input type="text" name="numero_paciente" class="form-control" required>
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
                                                <label for="medico_id">Médico</label>
                                                <select name="medico_id" class="form-control" required>
                                                    <?php
                                                        $result = $mysqli->query("SELECT doc_id, doc_fname FROM his_docs");
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<option value='" . $row['doc_id'] . "'>" . $row['doc_fname'] . "</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="razao_consulta">Motivo da consulta</label>
                                                <input type="text" name="razao_consulta" class="form-control" required>
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

        <div class="rightbar-overlay"></div>

        <script src="assets/js/vendor.min.js"></script>
    </div>
</body>
</html>
