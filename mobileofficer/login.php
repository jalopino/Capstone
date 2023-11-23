<?php
require("conn.php");

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT password FROM officer WHERE username = ?"; // Adjust table and field names as necessary
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $response["success"] = 1;
        $response["message"] = "success";
    } else {
        $response["success"] = 0;
        $response["message"] = "Invalid Username or Password";
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Invalid Username or Password";
}

echo json_encode($response);
?>
