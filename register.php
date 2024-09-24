<?php
$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

session_start(); // Inicia la sesión

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Registro de usuario
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    // Verificar que los campos no estén vacíos
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // Asignar y procesar los datos del formulario
    $user = $conn->real_escape_string($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar la contraseña
    $email = $conn->real_escape_string($_POST['email']);

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    
    // Verificar si la preparación de la sentencia fue exitosa
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sss", $user, $pass, $email);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        echo "Registro exitoso.";
        // Registro exitoso, redirigir a login o la página que desees
        header("Location: login.html");
        exit();
    } else {
        // Mostrar error en caso de fallo de ejecución
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close(); // Cerrar la sentencia si se creó correctamente
}

$conn->close(); // Cerrar la conexión
?>
