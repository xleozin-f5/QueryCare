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

if (!isset($_SESSION['logged_in']) && $_SERVER['PHP_SELF'] != '/QueryCare/src/login.php' && $_SERVER['PHP_SELF'] != '/QueryCare/src/registration.php') {
  // Redireciona o usuário para a página de login
  header("location: ./login.php");
}

// Verifica se o usuário já está logado e tentando acessar a página de login
if (isset($_SESSION['logged_in']) && $_SERVER['PHP_SELF'] == './src/login.php') {
  // Redireciona o usuário para a página inicial
  header("location: ./index.php");
}

?>