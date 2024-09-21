
<?php
var_dump($_POST);
exit();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "Aylin2024!";
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

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

// Inicio de sesión
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Usar sentencia preparada para prevenir inyecciones SQL
    $stmt = $conn->prepare("SELECT password FROM Users WHERE username=?");
    $stmt->bind_param("s", $user);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                header("Location: reservations.php");
                exit();
            } else {
                echo "Invalid credentials";
            }
        } else {
            echo "No such user";
        }
    } else {
        echo "Error en la consulta.";
    }
}

$conn->close();
?>
