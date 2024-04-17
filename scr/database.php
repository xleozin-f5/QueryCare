<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "QueryCare";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Ups, Algo deu errado:(");
}

?>      