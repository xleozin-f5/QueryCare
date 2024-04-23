<?php
// Inicia a sessão
session_start();

// Verifica se a sessão está definida
if (isset($_SESSION)) {
    // Limpa todos os dados da sessão
    session_unset();

    // Destrói a sessão
    session_destroy();
}

// Redireciona para a página de login
header("Location: /QueryCare/src/login.php");
exit; // Garante que nenhum código adicional seja executado após o redirecionamento
?>
