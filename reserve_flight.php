<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no está autenticado, redirige al login
    header("Location: login.html");
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$flight_id = $_POST['flight_id']; // Recibir el ID del vuelo del formulario

// Inserta la reserva en la base de datos
$sql = "INSERT INTO Reservations (user_id, flight_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $flight_id);

if ($stmt->execute()) {
    // Redirige a la página de reservas después de hacer la reserva
    header("Location: reservations.php");
    exit();
} else {
    echo "Error al guardar la reserva: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
