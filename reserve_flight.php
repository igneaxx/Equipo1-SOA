<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Asegurarse de que el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$flight_id = $_POST['flight_id'];

// Insertar la nueva reserva en la base de datos
$sql = "INSERT INTO Reservations (user_id, flight_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $flight_id);

if ($stmt->execute()) {
    // Reserva exitosa, redirigir a la página de reservas
    header("Location: reservations.php");
    exit();
} else {
    echo "Error al realizar la reserva: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
