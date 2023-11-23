<?php include __DIR__ . '/../../admin2023/static/header.php';?>
<?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
<?php

// Check if officer_id is present in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Officer ID is required.");
}

$officer_id = $_GET['id'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute delete query
$stmt = $conn->prepare("DELETE FROM officer WHERE officer_id = ?");
$stmt->bind_param("i", $officer_id);

if ($stmt->execute()) {
    echo "Officer deleted successfully.";
    // Optionally, redirect back to the officers list
    header("Location: {$base}capstone/admin2023/officers/manageofficer.php"); 
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
