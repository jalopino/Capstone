<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/../../admin2023/static/header.php';?>
</head>
<body>
    <div class="background-container">
        <div class="row">
            <div class="column">
                <div class="login-container">
                    <div class="loginform" style="width: 20%">
                        <form method="post" action="" style="text-align: center;">
                        <img src="<?php echo $base ?>capstone/materials/logo.png" alt="LOGO" style="max-width: 40%; max-height: 40%; margin-bottom: -15px;">
                        <h1>Admin</h1>
                        <p style="margin-bottom: 10px; font-size:smaller; margin-top: -10px; margin-bottom: 40px;">Sign in to continue</p>
                        <?php
                        if ($_SESSION["adminlogin_feedback"] == ("invalid_password" || "invalid_user")) {
                            echo '<p style="color: red;">Invalid username or password!</p>';
                            session_destroy();
                        } 
                        ?>
                        <p style="text-align: start; font-size:x-small"><i class="fa fa-user"></i>USERNAME</p>
                        <input type="text" id="username" name="username" placeholder="Username" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small"><i class="fa fa-lock"></i>PASSWORD</p>
                        <input type="password" id="password" name="password" placeholder="Password" style="border: solid black 1px;"></br>
                        <input type="submit" value="Login" class="button">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include __DIR__ . '/../../static/footer.php';?>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL statement to fetch the user's data
    $stmt = $conn->prepare("SELECT admin_id, username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["admin_id"] = $id;
            $_SESSION["admin_username"] = $username;
            header("Location: {$base}capstone/admin2023"); 
            exit();
        } else {
            $_SESSION["adminlogin_feedback"] = "invalid_pass";
        }
    } else {
        $_SESSION["adminlogin_feedback"] = "invalid_user";
    }
    header("Location: {$base}capstone/admin2023"); 
    exit();
    $stmt->close();
    $conn->close();
}
?>
</html>

