<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accesodb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

$username = $data->username ?? null;
$email = $data->email ?? null;
$password = $data->password ?? null;

$sql = "SELECT * FROM usuarios WHERE username='$username' AND email='$email' AND password='$password'";
$result = $conn->query($sql);

$response = new stdClass();
if ($result && $result->num_rows > 0) {
    $response->success = true;
} else {
    $response->success = false;
}

echo json_encode($response);
$conn->close();
?>