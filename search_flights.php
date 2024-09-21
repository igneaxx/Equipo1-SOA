<?php
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

// Obtener los valores del formulario de búsqueda
$origin = $_POST['origin'];
$destination = $_POST['destination'];

// Consulta SQL para obtener los vuelos disponibles
$sql = "SELECT * FROM Flights WHERE origin=? AND destination=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $origin, $destination);
$stmt->execute();
$result = $stmt->get_result();
$flights = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Vuelos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="busca">
    <h1>Resultados de Vuelos</h1>

    <?php if (!empty($flights)): ?>
        <table>
            <tr>
                <th>ID de Vuelo</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha de Salida</th>
                <th>Fecha de Regreso</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($flights as $flight): ?>
                <tr>
                    <td><?php echo $flight['flight_id']; ?></td>
                    <td><?php echo $flight['origin']; ?></td>
                    <td><?php echo $flight['destination']; ?></td>
                    <td><?php echo $flight['departure_date']; ?></td>
                    <td><?php echo $flight['return_date'] ? $flight['return_date'] : 'N/A'; ?></td>
                    <td><?php echo $flight['price']; ?></td>
                    <td>
                        <form action="reserve_flight.php" method="POST">
                            <input type="hidden" name="flight_id" value="<?php echo $flight['flight_id']; ?>">
                            <input type="submit" value="Reservar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron vuelos.</p>
    <?php endif; ?>

    <a href="search.html">Buscar Nuevos Vuelos</a>
    </div>
</body>
</html>
