<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Consulta SQL para obter as consultas agendadas do banco de dados
$sql = "SELECT * FROM his_medical_records";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Consultas</title>
    <?php include('assets/inc/head.php');?>
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
                                    <h2 class="header-title mb-4" style="font-size: 28px;">Gerenciar Consultas</h2>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nome do Paciente</th>
                                                    <th>Data da Consulta</th>
                                                    <th>Hora da Consulta</th>
                                                    <th>Motivo</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Loop para exibir as consultas agendadas -->
                                                <?php
                                                // Se houver resultados da consulta
                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row["mdr_id"] . "</td>";
                                                        echo "<td>" . $row["mdr_pat_name"] . "</td>";
                                                        echo "<td>" . $row["mdr_date_rec"] . "</td>";
                                                        echo "<td>" . $row["mdr_time_rec"] . "</td>";
                                                        echo "<td>" . $row["mdr_reason"] . "</td>";
                                                        // Botão de editar abre o modal de edição
                                                        echo "<td>
                                                                <button type='button' class='btn btn-info' data-toggle='modal' data-target='#editModal' data-id='" . $row["mdr_id"] . "' data-data='" . $row["mdr_date_rec"] . "' data-hora='" . $row["mdr_time_rec"] . "'>Editar</button>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6'>Nenhuma consulta agendada encontrada</td></tr>";
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
                    <form method="post" action="update_consulta.php">
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
    </div>
    <!-- END wrapper -->
</body>
</html>
