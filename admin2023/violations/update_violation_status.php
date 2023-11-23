<?php include __DIR__ . '/../../admin2023/static/header.php';?>
<?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['violation_id']) && isset($_POST['status'])) {
    $violation_id = $_POST['violation_id'];
    $new_status = $_POST['status'];

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute update query
    $stmt = $conn->prepare("UPDATE violations SET status = ? WHERE violation_id = ?");
    $stmt->bind_param("si", $new_status, $violation_id);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
        // Optionally, redirect back to the violation details page or list
        header("Location: viewviolation.php?violation_id=" . $violation_id);
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect or show an error message if the form is not submitted correctly
    die("Invalid request");
}
?>
