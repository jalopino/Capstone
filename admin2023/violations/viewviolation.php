<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/../../admin2023/static/header.php';?>
    <?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
    <title>Manage Violations</title>
</head>
<body>
<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the violation_id from the URL parameter.wwwwwww
$violation_id = isset($_GET['violation_id']) ? intval($_GET['violation_id']) : 0;

// Fetch the violation details if violation_id is provided.
if ($violation_id) {
    $query = "SELECT * 
    FROM violations
    INNER JOIN users ON users.user_id = violations.user_id
    INNER JOIN user_information ON users.info_id = user_information.info_id 
    INNER JOIN officer ON officer.officer_id = violations.officer_id 
    WHERE violation_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $violation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $violationDetails = $result->fetch_assoc();
}
?>
<div class="login-container">
    <div class="loginform">
    <?php
    // Check if violation details are available
    if (isset($violationDetails)) {
        // Display violation details
        echo "<h1 style='font-weight: bold;'>Violation Details</h1>";
        echo "<p>Violation ID: " . htmlspecialchars($violationDetails['violation_id']) . "</p>";
        echo "<p>Name of Violator: " . htmlspecialchars($violationDetails['first_name'] . " " . $violationDetails['last_name']) . "</p>";
        echo "<p>Officer ID: " . htmlspecialchars($violationDetails['officer_id']) . "</p>";
        echo "<p>Issued By: " . htmlspecialchars($violationDetails['fname'] . " " . $violationDetails['lname']) . "</p>";
        echo "<p>Violation: " . htmlspecialchars($violationDetails['violation']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($violationDetails['date']) . "</p>";
        echo "<p>Status: " . htmlspecialchars($violationDetails['status']) . "</p>";
        echo "<p>Fine: ₱" . htmlspecialchars($violationDetails['fine']) . "</p>";
        if (!$violationDetails['dispute'] == NULL) {
            echo "<p>Dispute: " . htmlspecialchars($violationDetails['dispute']) . "</p>";
        }
        if (!$violationDetails['due_date'] == NULL) {
            echo "<p>Due: " . htmlspecialchars($violationDetails['due_date']) . "</p>";
        }
    } else {
        echo "<p>No violation found.</p>";
    }
    ?>
        <div class="status-update-form" style="margin-top: 40px;">
        <form action="<?php echo $base . "capstone/admin2023/violations/update_violation_status.php" ?>" method="post">
            <input type="hidden" name="violation_id" value="<?php echo htmlspecialchars($violationDetails['violation_id']); ?>">

            <label for="status">Update Status:</label>
            <select name="status" id="status">
                <option value="<?php echo $violationDetails['status']?>"><?php echo "Current: " . $violationDetails['status']?></option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
                <option value="Dispute Accepted">Dispute Accepted</option>
            </select>
            <br>
            <input class="button" type="submit" value="Update Status">
        </form>
    </div>
    </div>
</div>
</body>
<?php include __DIR__ . '/../static/footer.php';?>
<style>
    .dispute-form {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    .dispute-form input[type="text"] {
        margin: 10px 0;
        padding: 10px;
        width: 300px;
    }
    .dispute-form input[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .dispute-form input[type="submit"]:hover {
        background-color: #0056b3;
    }
    label {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
    }

    input {
        border-color: black;
    }
</style>
</html>
