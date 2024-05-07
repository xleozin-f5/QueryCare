<?php
    session_start();
    unset($_SESSION['ad_id']);
    session_destroy();

    header("Location: qc_admin_logout.php");
    exit;
?>
