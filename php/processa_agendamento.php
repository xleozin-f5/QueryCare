<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $data_consulta = $_POST["data_consulta"];

    // Aqui você pode adicionar lógica para processar os dados do formulário, como salvar em um banco de dados.
    // Lembre-se de validar e sanitizar os dados antes de usar em operações de banco de dados para evitar vulnerabilidades.

    // Exemplo de resposta simples (pode ser ajustado conforme necessário):
    echo "Consulta agendada com sucesso para $nome em $data_consulta.";
} else {
    // Redirecionar ou tratar de outra forma se alguém tentar acessar este script diretamente.
    echo "Acesso negado.";
}
?>
