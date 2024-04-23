<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "QueryCare";

// Tentar se conectar ao banco de dados
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

// Verificar se a conexão foi bem-sucedida
if (!$conn) {
    echo "Erro ao conectar ao banco de dados: " . mysqli_connect_error();
} else {
    echo "Conexão bem-sucedida!";
}
?>
