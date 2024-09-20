<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Reservar vuelo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $flight_id = $_POST['flight_id'];

    $sql = "INSERT INTO Reservations (user_id, flight_id) VALUES ('$user_id', '$flight_id')";
    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página que muestra todas las reservas del usuario
        header("Location: my_reservations.php?user_id=" . $user_id);
        exit(); // Asegúrate de detener el script después de redirigir
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
