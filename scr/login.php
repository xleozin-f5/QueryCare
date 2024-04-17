<?php
session_start();
if (isset($_SESSION["user"])) {
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
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
            $healthnumber = $_POST["healthnumber"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE healthnumber = '$healthnumber'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>A palavra-passe não corresponde</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>O número de utente de saúde não corresponde</div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="text" placeholder="Número de Utente de Saúde" name="healthnumber" class="form-control" type="text" maxlength="9">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Palavra-Passe" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Entrar" name="login" class="btn btn-primary">
            </div>
        </form>
        <div class="register-link">
            <p>Não tens conta? <a href="registration.php">Regista-te aqui</a>.</p>
        </div>
    </div>
</body>
</html>
