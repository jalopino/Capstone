<?php
require("conn.php");

$response = array();

// Check if all required POST data is set
if (isset($_POST["officername"]) && isset($_POST["drivername"]) && 
    isset($_POST["dob"]) && isset($_POST["licensenum"]) &&
    isset($_POST["tov"]) && isset($_POST["date"]) && isset($_POST["phone"])) {

    $officername = mysqli_real_escape_string($connect, $_POST["officername"]);
    $drivername = mysqli_real_escape_string($connect, $_POST["drivername"]);
    $dob = mysqli_real_escape_string($connect, $_POST["dob"]);
    $licensenum = mysqli_real_escape_string($connect, $_POST["licensenum"]);
    $tov = mysqli_real_escape_string($connect, $_POST["tov"]);
    $date = mysqli_real_escape_string($connect, $_POST["date"]);
    $phone_no = mysqli_real_escape_string($connect, $_POST["phone"]);

    // Fetch officer_id based on officername
    $sql = "SELECT officer_id FROM officer WHERE username = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $officername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $officer_id = $row['officer_id'];

        // Fetch info_id based on licensenum
        // Assuming licensenum is related to user_information
        $sql = "SELECT info_id FROM user_information WHERE license_no = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("s", $licensenum);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $info_id = $row['info_id'];

            // Fetch user_id based on info_id
            // Assuming user_id is related to users
            $sql = "SELECT user_id FROM users WHERE info_id = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("i", $info_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_id = $row['user_id'];

                // Insert data into violations table
                $sql = "INSERT INTO violations (user_id, officer_id, name, violation, date, phone_no) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("iissss", $user_id, $officer_id, $drivername, $tov, $date, $phone_no);

                if ($stmt->execute()) {
                    $response["success"] = 1;
                    $response["message"] = "Violation recorded successfully";
                } else {
                    $response["error"] = "Error recording violation: " . $stmt->error;
                }
            } else {
                $response["error"] = "User ID not found for given license number";
            }
        } else {
            $response["error"] = "Info ID not found for given license number";
        }
    } else {
        $response["error"] = "Officer not found for given username";
    }
} else {
    $response["error"] = "Missing required fields";
}

echo json_encode($response);
$connect->close();
?>
