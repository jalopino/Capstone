<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log - In</title>
    <?php include __DIR__ . '/../static/header.php';?>
    <?php include __DIR__ . '/../templates/restrict_user.php';?>
</head>
<body>
<?php 
    if (!isset($_POST['username'])) {
        // Use the HTTP_REFERER to go back to the previous page if available
        if(isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            // Default to a specific page if HTTP_REFERER is not set
            header("Location: {$base}capstone/index.php");
        }
        exit; // Make sure to end the execution of the script
    }
    ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL statement to fetch the user's data
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            header("Location: {$base}capstone/dashboard/home.php"); 
            exit();
        } else {
            echo "Invalid password.";
            header("Location: {$base}capstone/auth/login.php"); 
            $_SESSION["login_feedback"] = "invalid_pass";
            exit();
        }
    } else {
        echo "User not found.";
        header("Location: {$base}capstone/auth/login.php");
        $_SESSION["login_feedback"] = "invalid_user";
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>