<?php
    session_start();
    unset($_SESSION['pati_id']);
    unset($_SESSION['pati_number']);
    session_destroy();

    header("Location: qc_pati_logout.php");
    exit;
?>
