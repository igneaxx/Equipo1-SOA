<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Registro de usuario
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    // ... tu código de registro ...
}

// Inicio de sesión
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
                $_SESSION['user_id'] = $row['user_id']; // Guardar user_id en la sesión
                header("Location: reservations.php");
                exit();
            } else {
                echo "Invalid credentials";
            }
        } else {
            echo "No such user";
        }
    } else {
        echo "Error en la consulta.";
    }
}
$stmt->close();
$conn->close();
?>
