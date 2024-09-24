<?php
$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

session_start(); 

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

    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $user, $pass, $email);

    // Intentar ejecutar la consulta
    if ($stmt->execute()) {
        // Aquí deberías verificar que se inserte realmente el usuario
        if ($stmt->affected_rows > 0) {
            echo "Usuario registrado con éxito."; 
            header("Location: login.html");
            exit(); // Detener ejecución aquí
        } else {
            echo "Error: No se insertaron filas en la base de datos.";
            exit();
        }
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
        exit(); // Detener ejecución aquí
    }

    $stmt->close(); 
}

$conn->close(); 
?>
