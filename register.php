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
} else {
    echo "Conexión exitosa a la base de datos.<br>";
}

// Registro de usuario
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    // Verificar que los campos no estén vacíos
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // Mostrar datos recibidos para depurar
    var_dump($_POST);

    // Asignar y procesar los datos del formulario
    $user = $conn->real_escape_string($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar la contraseña
    $email = $conn->real_escape_string($_POST['email']);

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    
    // Verificar si la preparación de la sentencia fue exitosa
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    } else {
        echo "Consulta preparada correctamente.<br>";
    }

    $stmt->bind_param("sss", $user, $pass, $email);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        echo "Registro exitoso.<br>";
        header("Location: search.html"); // Redirigir después de un registro exitoso
        exit();
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close(); // Cerrar la sentencia si se creó correctamente
}

$conn->close(); // Cerrar la conexión
?>
