<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // Obtener el user_id desde la sesión

// Obtener las reservas del usuario
$sql = "SELECT r.reservation_id, f.origin, f.destination, f.departure_date, f.return_date, f.price 
        FROM Reservations r
        JOIN Flights f ON r.flight_id = f.flight_id
        WHERE r.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Usar un parámetro preparado para prevenir inyección SQL
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="search.css">
</head>
<body class="reserv">
<div class="busca">
    <h1>Mis Reservas</h1>

    <!-- Botón para crear una nueva reserva -->
    <a href="search.html" class="button">Crear Nueva Reserva</a>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Reserva ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha de salida</th>
                <th>Fecha de regreso</th>
                <th>Precio</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['reservation_id']; ?></td>
                    <td><?php echo $row['origin']; ?></td>
                    <td><?php echo $row['destination']; ?></td>
                    <td><?php echo $row['departure_date']; ?></td>
                    <td><?php echo $row['return_date'] ? $row['return_date'] : 'N/A'; ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No tienes reservas.</p>
    <?php endif; ?>
</div>
</body>
</html>
