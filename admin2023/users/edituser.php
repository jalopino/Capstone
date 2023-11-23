<?php include __DIR__ . '/../../admin2023/static/header.php';?>
<?php include __DIR__ . '/../../admin2023/templates/restrict_nonadmin.php';?>
<?php
// Function to get officer data
function getOfficerData($conn, $id) {
    $stmt = $conn->prepare("SELECT *
    FROM users
    INNER JOIN user_information ON user_information.info_id = users.info_id
    WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Check if officer_id is present in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("User ID is required.");
}

$user_id = $_GET['id'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch officer data
$userData = getOfficerData($conn, $user_id);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $license_num = $_POST['license_no'];

    $sql = "UPDATE user_information 
    INNER JOIN users ON users.info_id = user_information.info_id
    SET first_name = ?, last_name = ?, license_no = ? 
    WHERE users.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $first_name, $last_name, $license_num, $user_id);

    // Execute and close
    if ($stmt->execute()) {
        echo "Officer updated successfully.";
        // Optionally, redirect or fetch data again
        header("Location: {$base}capstone/admin2023/users/manageuser.php"); 
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
            <h1>Update User <i class="fa fa-cog"></i></h1>
            <div class="image-container" style="margin-bottom: 30px">
                <?php
                $profile_pic_path = $userData['prof_img'];
                if (isset($profile_pic_path)) {
                $imglocation = substr($profile_pic_path, 15);
                echo '<img src="' . htmlspecialchars($imglocation) . '" alt="Profile Picture">';
                } else {
                echo '<img src="'.$base.'capstone/images/default.png" alt="Profile Picture">';
                }
                ?>
            </div>
            <div>
                <form action="edituser.php?id=<?php echo $user_id; ?>" method="post">
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $userData['first_name']; ?>"><br>

                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $userData['last_name']; ?>"><br>

                    <label for="license_no">License Number:</label><br>
                    <input type="text" id="license_no" name="license_no" value="<?php echo $userData['license_no']; ?>"><br>

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

    .image-container {
        width: 100px;
        height: 100px;
        overflow: hidden;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>