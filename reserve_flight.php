<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si no está autenticado
    header("Location: login.html");
    exit();
}

// Ahora que el usuario está autenticado, proceder a insertar la reserva
$user_id = $_SESSION['user_id'];
$flight_id = $_POST['flight_id'];

// Inserta la reserva en la base de datos
$sql = "INSERT INTO Reservations (user_id, flight_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $flight_id);

if ($stmt->execute()) {
    header("Location: reservations.php");
    exit();
} else {
    echo "Error al guardar la reserva: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
