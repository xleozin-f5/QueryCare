<?php
// Incluir arquivo de configuração
include('assets/inc/config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ad_id'])) {
    $ad_id = $_POST['ad_id'];
    $ad_fname = $_POST['ad_fname'];
    $ad_lname = $_POST['ad_lname'];
    $ad_email = $_POST['ad_email'];

    // Atualizar os dados do administrador no banco de dados
    $query = "UPDATE his_admin SET ad_fname=?, ad_lname=?, ad_email=? WHERE ad_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssi', $ad_fname, $ad_lname, $ad_email, $ad_id);
    if($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
