<?php
include "../inc/connect.inc";
// Habilitar a exibição de erros de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se o formulário de login foi enviado
if (isset($_POST["login"])) {
    // Obtém os dados do formulário
    $healthnumber = $_POST["healthnumber"];
    $password = $_POST["password"];

    // Consulta para selecionar o usuário com o número de saúde fornecido
    $sql = "SELECT * FROM users WHERE healthnumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $healthnumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifica se o usuário foi encontrado
    if ($user) {
        // Verifica se a senha está correta
        if (password_verify($password, $user["password"])) {
            // Define a variável de sessão para indicar que o usuário está logado
            $_SESSION["user"] = "yes";
            // Redireciona para a página inicial
            header("Location: ../public/menupac.html");
            exit();
        } else {
            // Exibe uma mensagem de erro se a senha estiver incorreta
            $error_message = "A palavra-passe não corresponde";
        }
    } else {
        // Exibe uma mensagem de erro se o número de saúde não for encontrado
        $error_message = "O número de utente de saúde não corresponde";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueryCare - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        /* Estilos embutidos */
        body {
            font-family: Arial, sans-serif;
            background: url('../assets/img/hplogin.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
     <h2 class="text-center">Login QueryCare</h2> 
        <?php if (isset($error_message)) : ?>
            <!-- Exibe mensagem de erro se houver -->
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" placeholder="Número de Utente de Saúde" name="healthnumber" class="form-control" maxlength="9">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" placeholder="Palavra-Passe" name="password" class="form-control">
                </div>
            </div>
            <div class="form-btn">
                <button type="submit" name="login" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Entrar</button>
            </div>
        </form>
        <div class="register-link">
        <p>Não tens conta? <a href="./registration.php">Regista-te aqui</a>.</p>
        </div>
    </div>
    <!-- Font Awesome Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
