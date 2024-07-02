<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Obter o número do paciente da sessão
$pat_number = $_SESSION['pat_number'];

// Consulta SQL para obter as consultas agendadas apenas para o paciente logado
$sql = "SELECT m.mdr_id, m.mdr_pat_name, m.mdr_date_rec, m.mdr_reason, d.doc_fname 
        FROM his_medical_records m
        INNER JOIN his_docs d ON m.mdr_doc_id = d.doc_id
        WHERE m.mdr_pat_number = ?";

// Preparar a declaração SQL
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $pat_number);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Agendadas</title>
    <?php include('assets/inc/head.php');?>
    <!-- Adicione os estilos e scripts necessários aqui -->
</head>
<body>
    <div id="wrapper">
        <?php include('assets/inc/nav.php');?>
        <?php include('assets/inc/sidebar.php');?>
        
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="header-title mb-4">Consultas Agendadas</h2>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Paciente</th>
                                                    <th>Data da Consulta</th>
                                                    <th>Médico</th>
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
                                                        echo "<td>" . $row["mdr_pat_name"] . "</td>";
                                                        echo "<td>" . $row["mdr_date_rec"] . "</td>";
                                                        echo "<td>" . $row["doc_fname"] . "</td>";
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

        <!-- Inclua seus scripts e estilos de rodapé aqui -->
        <?php include('assets/inc/footer.php');?>
    </div>

    <!-- Scripts JS -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- Inclua outros scripts necessários aqui -->

</body>
</html>
