<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QueryCare - Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../src/login/registration.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $healthnumber = $_POST["healthnumber"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($fullName) OR empty($healthnumber) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"Todos os campos são necessários!");
           }
           if (!filter_var($healthnumber, FILTER_VALIDATE_INT)) {
            array_push($errors, "O número de Saúde não é válido");
           }
           if (strlen($password)<8) {
            array_push($errors,"A senha deve ter pelo menos 8 caracteres");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Senha não corresponde");
           }
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE healthnumber = '$healthnumber'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors, "Este número de saúde já foi registado!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO users (full_name, healthnumber, password) VALUES ( ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sss",$fullName, $healthnumber, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>Foste registado com sucesso.</div>";
            }else{
                die("Ups, Algo deu errado :( ");
            }
           }
          

        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Nome Completo">
            </div>
            <div class="form-group">
    <input type="text" class="form-control" name="healthnumber" placeholder="Número de utente de saúde" type="text" maxlength="9">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Palavra de Passe">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repete a Palavra de Passe">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Aceder" name="submit">
            </div>
        </form>
        <div>
        <div><p>Já tem conta na QueryCare? Faça login <a href="login.php">aqui</a>.</p></div>
      </div>
    </div>
</body>
</html>