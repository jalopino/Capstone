<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/../static/header.php';?>
    <?php include __DIR__ . '/../templates/restrict_user.php';?>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input from the registration form
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password) || empty($email)) {
            // If the post is empty, redirect to the homepage
            header("Location: {$base}capstone/auth/register.php"); 
            exit;
            $stmt->close();
            $conn->close();
        }

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Check if user or email exists
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            // Username or email already exists
            echo "Username or email already in use. Please choose another one.";
            $_SESSION["register_feedback"] = "invalid";
            header("Location: {$base}capstone/auth/register.php");
            exit();
        // Hash the password
        } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Insert the user into the database
        $insertStmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
        $insertStmt->bind_param("sss", $email, $username, $hashedPassword);
        $insertStmt->execute();
        echo "Succesfuly registered!";
        $_SESSION["register_feedback"] = "success";
        // Redirect to a success page or login page
        header("Location: {$base}capstone/auth/login.php");
        exit();
        }
        $stmt->close();
        $conn->close();
}
    ?>
</body>
</html>