<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Registro de usuario
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);  // Hasheamos después de validar
    $email = trim($_POST['email']);

    // Validar que no estén vacíos
    if (empty($user) || empty($pass) || empty($email)) {
        echo "Todos los campos son requeridos.";
        exit();
    }

    // Hash de la contraseña
    $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

    // Usar sentencia preparada para prevenir inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $hashed_pass, $email);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit(); 
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>