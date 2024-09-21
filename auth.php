<?php
session_start(); // Inicia la sesión

$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Usar sentencia preparada para prevenir inyecciones SQL
    $stmt = $conn->prepare("SELECT user_id, password FROM Users WHERE username=?");
    $stmt->bind_param("s", $user);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                // Almacenar el user_id en la sesión
                $_SESSION['user_id'] = $row['user_id'];
                
                header("Location: reservations.php");
                exit();
            } else {
                echo "Credenciales inválidas.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    } else {
        echo "Error en la consulta.";
    }
}

// Cerrar conexiones y declaración
$stmt->close();
$conn->close();
?>
