<?php include __DIR__ . '/../../admin2023/static/header.php';?>
<?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and trim whitespace
    $username = trim($_POST['username']);
    $password = ($_POST['password']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $badge_num = trim($_POST['badge_num']);

    // Check if the post content is empty

    if (empty($username) || empty($password) || empty($fname) || empty($lname) || empty($badge_num)) {
        // If the post is empty, redirect to the homepage
        header("Location: {$base}capstone/admin2023/officers/manageofficer.php"); 
        exit;
        $stmt->close();
        $conn->close();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check for existing username
    $stmt = $conn->prepare("SELECT username FROM officer WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Username already exists";
        header("Location: {$base}capstone/admin2023/officers/manageofficer.php"); 
        exit;
        $stmt->close();
        $conn->close();
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO officer (username, password, fname, lname, badge_num) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $hashed_password, $fname, $lname, $badge_num);

    // Execute and close
    if ($stmt->execute()) {
        echo "New officer added successfully";
        header("Location: {$base}capstone/admin2023/officers/manageofficer.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
