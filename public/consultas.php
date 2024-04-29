<?php 
include "../inc/connect.inc";
include "../src/get_data.php";
?>

<html>
    <div><?php echo getConsultas($_SESSION['usrID']);?></div>
</html>