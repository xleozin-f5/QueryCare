<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "QueryCare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se os campos obrigatórios estão presentes
    if (isset($_POST["id_utente"]) && isset($_POST["id_medico"]) && isset($_POST["data_hora_marcacao"]) && isset($_POST["motivo"]) && isset($_POST["obs"]) && isset($_POST["urgencia"])) {
        // Atribua valores dos campos do formulário a variáveis
        $id_utente = $_POST["id_utente"];
        $id_medico = $_POST["id_medico"];
        $data_hora_marcacao = $_POST["data_hora_marcacao"];
        $motivo = $_POST["motivo"];
        $obs = $_POST["obs"];
        $urgencia = $_POST["urgencia"];

        // Prepare and execute the database insertion using prepared statements
        $sql = "INSERT INTO consulta (id_utente, id_medico, data_hora_marcacao, motivo, data_hora_registo, obs, urgencia) VALUES (?, ?, ?, ?, NOW(), ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("iissss", $id_utente, $id_medico, $data_hora_marcacao, $motivo, $obs, $urgencia);

        // Execute statement
        if ($stmt->execute()) {
            echo "Appointment booked successfully!";
        } else {
            echo "Error: " . $stmt->error;
            var_dump($conn->error); // Verifique os erros SQL
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Campos obrigatórios não foram enviados.";
    }
} else {
    var_dump($_POST); // Verifique se os dados do formulário estão sendo recebidos corretamente
    echo "Formulário não enviado corretamente.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Appointment Booking Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/marca_consulta.css">
</head>
<body>
    <div class="background">
        <div class="container">
            <div class="booking-form">
                <h2 class="text-center">Hospital Appointment Booking Form</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="id_utente">Patient ID:</label>
                        <input type="number" class="form-control" name="id_utente" id="id_utente" required>
                    </div>
                    <div class="form-group">
                        <label for="id_medico">Doctor ID:</label>
                        <input type="number" class="form-control" name="id_medico" id="id_medico" required>
                    </div>
                    <div class="form-group">
                        <label for="data_hora_marcacao">Appointment Date and Time:</label>
                        <input type="datetime-local" class="form-control" name="data_hora_marcacao" id="data_hora_marcacao" required>
                    </div>
                    <div class="form-group">
                        <label for="motivo">Reason:</label>
                        <input type="text" class="form-control" name="motivo" id="motivo" required>
                    </div>
                    <div class="form-group">
                        <label for="obs">Observation:</label>
                        <textarea class="form-control" name="obs" id="obs" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="urgencia">Urgency:</label>
                        <select class="form-control" name="urgencia" id="urgencia" required>
                            <option value="Urgent">Urgent</option>
                            <option value="Non-urgent">Non-urgent</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Book Appointment</button>
                </form>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>