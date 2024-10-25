<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accesodb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

if ($data) {
    $username = $data->username ?? null;
    $email = $data->email ?? null;
    $password = $data->password ?? null;

    $checkUserSql = "SELECT * FROM usuarios WHERE username='$username' OR email='$email'";
    $checkResult = $conn->query($checkUserSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "El usuario o correo electrónico ya está en uso."]);
    } else {
        $insertSql = "INSERT INTO usuarios (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($insertSql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Registro exitoso."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al registrar: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "No se recibieron datos."]);
}

$conn->close();
?>