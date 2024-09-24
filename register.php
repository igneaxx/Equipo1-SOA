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

if (isset($_POST['action']) && $_POST['action'] == 'register') {
    // Verificar que los campos no estén vacíos
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    $user = $conn->real_escape_string($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $conn->real_escape_string($_POST['email']);

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $user, $pass, $email);

    // Ejecutar la consulta e verificar el resultado
    if ($stmt->execute()) {
        echo "Usuario registrado con éxito.";
        // Solo redirigir si la inserción fue exitosa
        header("Location: search.html");
        exit();
    } else {
        // Mostrar el error en caso de fallo
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close(); 
}

// Cerrar la conexión
$conn->close(); 
?>
