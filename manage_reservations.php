<?php
$servername = "10.138.0.2";
$username = "root";
$password = "";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener reservas
$user_id = $_POST['user_id'];
$sql = "SELECT * FROM Reservations WHERE user_id='$user_id'";
$result = $conn->query($sql);
$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}
echo json_encode($reservations);

$conn->close();
?>
