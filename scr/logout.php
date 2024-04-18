<?php
require_once "database.php";
session_unset();
session_destroy();
header("Location: ./login.php");
exit;
?>