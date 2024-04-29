<?php
include "../inc/connect.inc";
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
        <form action="../src/register.php" method="POST">
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
            <p class="text-center">Já tem uma conta na QueryCare? Faça login <a href="../src/login.php">aqui</a>.</p>
        </div>

    </div>
</body>
</html>
