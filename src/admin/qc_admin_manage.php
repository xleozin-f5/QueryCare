<?php
// Inclua os blocos de código PHP necessários aqui
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include('assets/inc/head.php'); ?>
    <?php include('assets/inc/config.php'); ?>
</head>
<body>
    <!-- Início da página -->
    <div id="wrapper">
        <!-- Topbar -->
        <?php include('assets/inc/nav.php'); ?>
        <!-- Fim do Topbar -->

        <!-- Barra Lateral Esquerda -->
        <?php include('assets/inc/sidebar.php'); ?>
        <!-- Fim da Barra Lateral Esquerda -->

        <!-- Conteúdo da Página -->
        <div class="content-page">
            <div class="content">
                <!-- Conteúdo Inicial -->
                <div class="container-fluid">
                    <!-- Título da Página -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Painel</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Administração</a></li>
                                        <li class="breadcrumb-item active">Gerir Administradores</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Gerenciar Detalhes do Administrador</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Fim do Título da Página -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title"></h4>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-12 text-sm-center form-inline">
                                            <div class="form-group mr-2" style="display:none">
                                                <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                    <option value="">Mostrar tudo</option>
                                                    <option value="Ativo">Ativo</option>
                                                    <option value="Inativo">Inativo</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input id="demo-foo-search" type="text" placeholder="Pesquisar" class="form-control form-control-sm" autocomplete="on">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-toggle="true">Nome</th>
                                                <th data-hide="phone">Email</th>
                                                <th data-hide="phone">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM his_admin ORDER BY ad_id";
                                            $result = $mysqli->query($sql);
                                            if ($result->num_rows > 0) {
                                                $count = 1;
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr id="row_<?php echo $row['ad_id']; ?>">
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $row['ad_fname'] . ' ' . $row['ad_lname']; ?></td>
                                                <td><?php echo $row['ad_email']; ?></td>
                                                <td>
                                                    <!-- Botão para editar -->
                                                    <button class="btn btn-sm btn-primary" onclick="editAdmin(<?php echo $row['ad_id']; ?>)">Editar</button>
                                                    <!-- Formulário de exclusão -->
                                                    <form action="" method="post" style="display: inline-block;">
                                                        <input type="hidden" name="ad_id" value="<?php echo $row['ad_id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger" name="delete">Apagar</button>
                                                    </form>
                                                    <!-- Botões de salvar e cancelar (invisíveis inicialmente) -->
                                                    <button class="btn btn-sm btn-success" style="display: none;" onclick="saveAdmin(<?php echo $row['ad_id']; ?>)">Salvar</button>
                                                    <button class="btn btn-sm btn-secondary" style="display: none;" onclick="cancelEdit(<?php echo $row['ad_id']; ?>)">Cancelar</button>
                                                </td>
                                            </tr>
                                            <tr id="editRow_<?php echo $row['ad_id']; ?>" style="display: none;">
                                                <td></td>
                                                <td>
                                                    <input type="text" id="edit_ad_fname_<?php echo $row['ad_id']; ?>" value="<?php echo $row['ad_fname']; ?>" class="form-control">
                                                    <input type="text" id="edit_ad_lname_<?php echo $row['ad_id']; ?>" value="<?php echo $row['ad_lname']; ?>" class="form-control mt-2">
                                                </td>
                                                <td>
                                                    <input type="email" id="edit_ad_email_<?php echo $row['ad_id']; ?>" value="<?php echo $row['ad_email']; ?>" class="form-control">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <?php
                                                    $count++;
                                                }
                                            } else {
                                            ?>
                                            <tr>
                                                <td colspan="4">Nenhum administrador encontrado.</td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="active">
                                                <td colspan="4">
                                                    <div class="text-right">
                                                        <!-- Paginação -->
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- end .table-responsive-->
                            </div>
                            <!-- end card-box -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- container -->
            </div>
            <!-- content -->

            <!-- Footer -->
            <?php include('assets/inc/footer.php'); ?>
            <!-- end Footer -->

        </div>
        <!-- Fim do Conteúdo da Página -->
    </div>
    <!-- Fim do wrapper -->

    <!-- Overlay da Barra Lateral Direita -->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Footable js -->
    <script src="assets/libs/footable/footable.all.min.js"></script>

    <!-- Init js -->
    <script src="assets/js/pages/foo-tables.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

    <script>
        // Função para mostrar campos de edição e botões de salvar/cancelar
        function editAdmin(ad_id) {
            // Esconder botão de editar
            $('#row_' + ad_id + ' button.btn-primary').hide();
            // Mostrar botões de salvar e cancelar
            $('#row_' + ad_id + ' button.btn-success').show();
            $('#row_' + ad_id + ' button.btn-secondary').show();
            // Mostrar campos de edição
            $('#editRow_' + ad_id).show();
        }

        // Função para cancelar a edição
        function cancelEdit(ad_id) {
            // Mostrar botão de editar
            $('#row_' + ad_id + ' button.btn-primary').show();
            // Esconder botões de salvar e cancelar
            $('#row_' + ad_id + ' button.btn-success').hide();
            $('#row_' + ad_id + ' button.btn-secondary').hide();
            // Esconder campos de edição
            $('#editRow_' + ad_id).hide();
        }

        // Função para salvar as alterações
        function saveAdmin(ad_id) {
            var ad_fname = $('#edit_ad_fname_' + ad_id).val();
            var ad_lname = $('#edit_ad_lname_' + ad_id).val();
            var ad_email = $('#edit_ad_email_' + ad_id).val();

            $.ajax({
                url: 'update_admin.php',
                method: 'POST',
                data: {
                    ad_id: ad_id,
                    ad_fname: ad_fname,
                    ad_lname: ad_lname,
                    ad_email: ad_email
                },
                success: function(response) {
                    if(response == 'success') {
                        // Atualizar a tabela após salvar
                        location.reload();
                    } else {
                        alert('Erro ao salvar as alterações.');
                    }
                }
            });
        }
    </script>

</body>
</html>