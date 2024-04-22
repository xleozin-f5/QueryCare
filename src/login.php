<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
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
    <link rel="stylesheet" href="login.css">
    <style>
      /* Pq não em um arquivo css? */
        body {
            font-family: Arial, sans-serif;
            background: url('../assets/hplogin.jpg') no-repeat center center fixed;
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
        <?php
        //De novo, precisa estar em um outro arquivo "src"
        if (isset($_POST["login"])) {
            $healthnumber = $_POST["healthnumber"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE healthnumber = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $healthnumber);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i> A palavra-passe não corresponde</div>";
                }
            } else {
                echo "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i> O número de utente de saúde não corresponde</div>";
            }
        }
        ?>
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
            <p>Não tens conta? <a href="registration.php">Regista-te aqui</a>.</p>
        </div>
    </div>
    <!-- Font Awesome Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
