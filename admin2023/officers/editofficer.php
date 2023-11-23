<?php include __DIR__ . '/../../admin2023/static/header.php';?>
<?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
<?php
// Function to get officer data
function getOfficerData($conn, $id) {
    $stmt = $conn->prepare("SELECT username, fname, lname, badge_num FROM officer WHERE officer_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Check if officer_id is present in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Officer ID is required.");
}

$officer_id = $_GET['id'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch officer data
$officerData = getOfficerData($conn, $officer_id);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password']; // New password
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $badge_num = $_POST['badge_num'];

    if (empty($username) || empty($fname) || empty($lname) || empty($badge_num)) {
        // If the post is empty, redirect to the homepage
        header("Location: {$base}capstone/admin2023/officers/manageofficer.php"); 
        exit;
        $stmt->close();
        $conn->close();
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

// Prepare SQL based on whether the password was provided
    if (!empty($password)) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE officer SET username = ?, password = ?, fname = ?, lname = ?, badge_num = ? WHERE officer_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $hashed_password, $fname, $lname, $badge_num, $officer_id);
    } else {
        $sql = "UPDATE officer SET username = ?, fname = ?, lname = ?, badge_num = ? WHERE officer_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $fname, $lname, $badge_num, $officer_id);
    }

    // Execute and close
    if ($stmt->execute()) {
        echo "Officer updated successfully.";
        header("Location: {$base}capstone/admin2023/officers/manageofficer.php"); 
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Officer</title>
</head>
<body>
    <div class="background-container">
        <div style="display: flex; justify-content: center; align-items: center; height: 80vh;">
            <div class="loginform">
            <h1>Update Officer <i class="fa fa-cog"></i></h1>
            <div>
                <form action="editofficer.php?id=<?php echo $officer_id; ?>" method="post">
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" value="<?php echo $officerData['username']; ?>"><br>

                    <label for="password">Password (leave blank to keep current password):</label><br>
                    <input type="password" id="password" name="password"><br>

                    <label for="fname">First Name:</label><br>
                    <input type="text" id="fname" name="fname" value="<?php echo $officerData['fname']; ?>"><br>

                    <label for="lname">Last Name:</label><br>
                    <input type="text" id="lname" name="lname" value="<?php echo $officerData['lname']; ?>"><br>

                    <label for="badge_num">Badge Number:</label><br>
                    <input type="text" id="badge_num" name="badge_num" value="<?php echo $officerData['badge_num']; ?>"><br>

                    <input class="button" type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<style>
    label {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
    }

    input {
        border-color: black;
    }
</style>