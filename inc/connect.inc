<?php
$env = parse_ini_file('info.env');

$server = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASSWORD'];
$dbname = $env['DB_NAME'];

$conn = mysqli_connect($server, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if (!$conn) {
    echo "Erro ao conectar ao banco de dados: " . mysqli_connect_error();
}



?>