<?php
include "../inc/connect.inc";
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if (isset($_POST["submit"])) {
    $fullName = $_POST["fullname"];
    $healthnumber = $_POST["healthnumber"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];

    // Array para armazenar mensagens de erro
    $errors = array();

    // Verifica se algum campo do formulário está vazio
    if (empty($fullName) || empty($healthnumber) || empty($password) || empty($passwordRepeat)) {
        array_push($errors,"Todos os campos são necessários!");
    }

    // Verifica se o número de saúde é um número válido
    if (!filter_var($healthnumber, FILTER_VALIDATE_INT)) {
        array_push($errors, "O número de Saúde não é válido");
    }

    // Verifica se a senha tem pelo menos 8 caracteres
    if (strlen($password) < 8) {
        array_push($errors,"A senha deve ter pelo menos 8 caracteres");
    }

    // Verifica se as senhas digitadas coincidem
    if ($password !== $passwordRepeat) {
        array_push($errors,"Senha não corresponde");
    }

    // Verifica se há algum erro antes de fazer a consulta ao banco de dados
    if (count($errors) == 0) {
        
        $sql = "SELECT * FROM users WHERE healthnumber = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $healthnumber);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                array_push($errors, "Este número de saúde já foi registado!");
            }
        } else {
            array_push($errors, "Erro na preparação da consulta: " . mysqli_error($conn));
        }
    }

    // Se houver erros, exibe as mensagens de erro
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        // Se não houver erros, insere os dados do usuário no banco de dados
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, healthnumber, password) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $fullName, $healthnumber, $passwordHash);
            mysqli_stmt_execute($stmt);
            header("Location: login.php?registration=success"); // Redireciona para a página de login com mensagem de sucesso
            exit(); // Encerra o script
        } else {
            echo "<div class='alert alert-danger'>Ups, Algo deu errado :(</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/registration.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-QVfVzUCyYNfIZ4LGy5ou7crXKUu9IxTqakm+zaMPj2jM9TkJhV/lGcxkRQDJkEJHGV34nO6sAQlCKGZ+zq4eew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="background-image: url('../assets/img/hplogin.jpg'); background-size: cover; background-position: center; height: 100vh;">
    <div class="container">
        <h2 class="text-center">Register QueryCare</h2>
        <form action="./registration.php" method="post">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="fullname" placeholder="Nome Completo" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" class="form-control" name="healthnumber" placeholder="Número de Utente de Saúde" maxlength="9" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Palavra de Passe" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="repeat_password" placeholder="Repetir a Palavra de Passe" required>
                </div>
            </div>
            <div class="form-btn">
                <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Registrar</button>
            </div>
        </form>
        <div>
            <p class="text-center">Já tem uma conta na QueryCare? Faça login <a href="./login.php">aqui</a>.</p>
        </div>
    </div>
</body>
</html>
