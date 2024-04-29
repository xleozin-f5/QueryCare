<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
// Connect to the database
include "../inc/connect.inc";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $fullname = $_POST["fullname"];
    $healthnumber = $_POST["healthnumber"];
    $password = $_POST["password"];
    $repeat_password = $_POST["repeat_password"];
    $role = 0;

    // Validate the form data
    if ($password!= $repeat_password) {
        // The passwords do not match
        echo "The passwords do not match.";
        return;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $sql = "INSERT INTO users (full_name, healthnumber, password, role) VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sisi", $fullname, $healthnumber, $hashed_password, $role);
    mysqli_stmt_execute($stmt);

    // Check if the insert was successful
    if (mysqli_stmt_affected_rows($stmt) == 1) {
        // The user was added successfully
        exit(header("location: ../public/registration.php"));
    } else {
        // There was an error adding the user
        exit(header("location: ../public/registration.php"));
    }

    // Close the statement and the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>