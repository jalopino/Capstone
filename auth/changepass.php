<?php include __DIR__ . '/../static/header.php';?>
<?php include __DIR__ . '/../templates/restrict_anon.php';?>
<?php 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id']) && isset($_POST['oldpass']) && isset($_POST['newpass'])) {
        $user_id = $_SESSION['user_id'];
        $old_password = $_POST['oldpass'];
        $new_password = $_POST['newpass'];

        if (empty($old_password) || empty($new_password)) {
            // If the post is empty, redirect to the homepage
            header("Location: {$base}capstone/dashboard/profile.php"); 
            exit;
            $stmt->close();
            $conn->close();
        }


        // Fetch the old password from the database for the user
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $old_hashed_password = $row['password'];

            // Verify if the old password matches the one in the database
            if (password_verify($old_password, $old_hashed_password)) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the user's password
                $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("si", $hashed_password, $user_id);
                $update_stmt->execute();

                $_SESSION['change_pass'] = "Password successfully changed!";
                $conn->close();
                // Redirect to dashboard.php
                header("Location: {$base}capstone/dashboard/home.php"); 
                exit();
            } else {
                echo "Old password does not match.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Please provide user_id, old_password, and new_password";
    }
}
?>