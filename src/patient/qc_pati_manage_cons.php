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
    <title>Gerenciar Consultas - QueryCare</title>
    <?php include('assets/inc/head.php');?>
    <!-- Inclua seus estilos CSS e scripts JS necessários aqui -->
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
                                    <h2 class="header-title mb-4">Gerenciar Consultas Agendadas</h2>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Nome do Paciente</th>
                                                    <th>Data da Consulta</th>
                                                    <th>Hora da Consulta</th>
                                                    <th>Médico</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Loop para exibir as consultas agendadas -->
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row["mdr_pat_name"] . "</td>";
                                                        echo "<td>" . $row["mdr_date_rec"] . "</td>";
                                                        echo "<td>" . $row["mdr_time_rec"] . "</td>";
                                                        echo "<td>" . $row["doc_fname"] . "</td>";
                                                        echo "<td>
                                                                <button type='button' class='btn btn-info' data-toggle='modal' data-target='#editModal' 
                                                                        data-id='" . $row["mdr_id"] . "' 
                                                                        data-data='" . $row["mdr_date_rec"] . "' 
                                                                        data-hora='" . $row["mdr_time_rec"] . "'>
                                                                    Editar
                                                                </button>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='5'>Nenhuma consulta agendada encontrada</td></tr>";
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

        <!-- Modal de Edição -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Consulta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="qc_pati_updatecons.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editDataConsulta">Nova Data da Consulta</label>
                                <input type="date" class="form-control" id="editDataConsulta" name="editDataConsulta" required>
                            </div>
                            <div class="form-group">
                                <label for="editHoraConsulta">Nova Hora da Consulta</label>
                                <input type="time" class="form-control" id="editHoraConsulta" name="editHoraConsulta" required>
                            </div>
                            <input type="hidden" id="consultaId" name="consultaId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Fim Modal de Edição -->

        <!-- Inclua seus scripts JS após o conteúdo da página -->
        <script src="assets/js/vendor.min.js"></script>
        <!-- Inclua outros scripts necessários aqui -->

        <!-- Script para preencher o modal com os dados da consulta selecionada -->
        <script>
            $(document).ready(function(){
                $('#editModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var consultaId = button.data('id');
                    var dataConsulta = button.data('data');
                    var horaConsulta = button.data('hora');
                    
                    var modal = $(this);
                    modal.find('.modal-title').text('Editar Consulta #' + consultaId);
                    modal.find('.modal-body #consultaId').val(consultaId);
                    modal.find('.modal-body #editDataConsulta').val(dataConsulta);
                    modal.find('.modal-body #editHoraConsulta').val(horaConsulta);
                });
            });
        </script>

        <!-- Script JS principal -->
        <script src="assets/js/app.min.js"></script>
        <!-- Inclua outros scripts principais aqui -->

        <!-- Rodapé da página -->
        <?php include('assets/inc/footer.php');?>
    </div>
    <!-- Fim wrapper -->
</body>
</html>
