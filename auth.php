<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Registro de usuario
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $user = $conn->real_escape_string($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $conn->real_escape_string($_POST['email']);
    
    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $pass, $email);
    
    if ($stmt->execute()) {
        // Registro exitoso
        header("Location: login.html");
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Inicio de sesión
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $user = $conn->real_escape_string($_POST['username']);
    $pass = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT password FROM Users WHERE username=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        
        if (password_verify($pass, $hashedPassword)) {
            header("Location: reservations.php");
            exit();
        } else {
            echo "Credenciales inválidas";
        }
    } else {
        echo "No existe este usuario";
    }
    $stmt->close();
}

$conn->close();
?>
