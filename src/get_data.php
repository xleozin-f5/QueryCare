<?php 
include "../inc/connect.inc";

function getConsultas($usrID) {
    $conn = connect(); // assuming connect() function is defined in connect.inc
    $sql = "SELECT * FROM consulta WHERE id_utente = '$usrID'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo $row["motivo"]. "<br>"; // replace "column_name" with the actual column name you want to display
      }
    } else {
      echo "No consultas found";
    }
    mysqli_close($conn);
  }
?>