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
    // Si no está autenticado, verificar las credenciales
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar en la base de datos
    $stmt = $conn->prepare("SELECT user_id, password FROM Users WHERE username=?");
    $stmt->bind_param("s", $username);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id']; // Almacena el user_id en la sesión
            } else {
                echo "Credenciales inválidas.";
                exit();
            }
        } else {
            echo "Usuario no encontrado.";
            exit();
        }
    }
}

// Ahora que el usuario está autenticado, proceder a insertar la reserva
$user_id = $_SESSION['user_id'];
$flight_id = $_POST['flight_id'];

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
