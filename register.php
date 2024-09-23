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

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $user = trim($_POST['username']);
    $pass = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("INSERT INTO Users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $pass, $email);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit(); 
    } else {
        echo "Error al registrar el usuario.";
    }
}
$stmt->close();
$conn->close();
?>

?>
