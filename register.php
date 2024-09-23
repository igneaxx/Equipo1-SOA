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

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registro de usuario
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $user = trim($_POST['username']);
    $pass = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $email = trim($_POST['email']);

    if (empty($user) || empty($pass) || empty($email)) {
        echo "All fields are required.";
        exit();
    }

    // Usar sentencia preparada para prevenir inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $pass, $email);

    if ($stmt->execute() === TRUE) {
        header("Location: login.html");
        exit(); 
    } else {
        echo "Error al registrar el usuario.";
    }
}

?>
