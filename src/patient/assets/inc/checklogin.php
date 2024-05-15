<?php
function check_login()
{
    if (empty($_SESSION['pat_id'])) {
        $host = $_SERVER['HTTP_HOST'];
        $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = "index.php";
        header("Location: http://$host$uri/$extra");
        exit; // É uma boa prática terminar a execução do script após um redirecionamento
    }
}
?>