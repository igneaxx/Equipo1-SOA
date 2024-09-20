<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registro de usuario
if ($_POST['action'] == 'register') {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $sql = "INSERT INTO Users (username, password, email) VALUES ('$user', '$pass', '$email')";
    if ($conn->query($sql) === TRUE) {
        // Registro exitoso, redirige a la página de bienvenida o confirmación
        header("Location: login.html");
        exit(); 
    } else {
        echo "Error: " . $conn->error;
    }
}


// Inicio de sesión
if ($_POST['action'] == 'login') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $sql = "SELECT password FROM Users WHERE username='$user'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            header("Location: my_reservations.php");
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "No such user";
    }
}

$conn->close();
?>
