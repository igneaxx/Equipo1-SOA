<?php
session_start(); // Asegúrate de iniciar la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Asegúrate de que el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirige si no está autenticado
    exit();
}

$user_id = $_SESSION['user_id']; // Obtén el user_id de la sesión
$flight_id = $_POST['flight_id']; // Obtén el ID del vuelo del formulario

// Inserta la reserva en la base de datos
$sql = "INSERT INTO Reservations (user_id, flight_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $flight_id);

if ($stmt->execute()) {
    // Redirige a "Mis Reservas" después de la reserva
    header("Location: reservations.php"); // Cambia esto por la URL de tu página de reservas
    exit();
} else {
    echo "Error al guardar la reserva.";
}

$stmt->close();
$conn->close();
?>
