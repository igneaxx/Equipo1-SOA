<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_reservation";

session_start(); // Asegúrate de iniciar la sesión

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
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    
    // Verificar si la preparación de la sentencia fue exitosa
    if ($stmt) {
        $stmt->bind_param("sss", $user, $pass, $email);
        
        if ($stmt->execute()) {
            // Registro exitoso, redirigir a login
            header("Location: login.html");
            exit();
        } else {
            // Mostrar error en caso de fallo de ejecución
            echo "Error al registrar el usuario: " . $stmt->error;
        }
        $stmt->close(); // Cerrar la sentencia si se creó correctamente
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
}

$conn->close(); // Cerrar la conexión
?>
