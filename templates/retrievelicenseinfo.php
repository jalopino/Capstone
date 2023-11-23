<?php
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rtv_fname;
$rtv_lname;
$rtv_mname;
$rtv_nationality;
$rtv_sex;
$rtv_dob;
$rtv_address;
$rtv_license_no;
$rtv_blood_type;
$rtv_eye_color;
$rtv_height;
$rtv_weight;

// Replace 'your_user_id' with the actual user ID you want to retrieve information for
$user_id = $_SESSION["user_id"];
if(isset($_SESSION["user_id"])) {
    // SQL query to fetch user information
    $sql = "SELECT ui.first_name, ui.last_name, ui.middle_name, ui.nationality, ui.sex, ui.dob, ui.address, ui.license_no, ui.blood_type, ui.eye_color, ui.height, ui.weight
            FROM users u
            JOIN user_information ui ON u.info_id = ui.info_id
            WHERE u.user_id = $user_id";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rtv_fname = $row["first_name"];
                $rtv_lname = $row["last_name"]; 
                $rtv_mname = $row["middle_name"];
                $rtv_nationality = $row["nationality"];
                $rtv_sex = $row["sex"]; 
                $rtv_dob = $row["dob"];
                $rtv_address = $row["address"];
                $rtv_license_no = $row["license_no"]; 
                $rtv_blood_type = $row["blood_type"];
                $rtv_eye_color = $row["eye_color"];
                $rtv_height = $row["height"];
                $rtv_weight = $row["weight"];
            }
        } else {
            echo '<p style="color: red; margin-bottom: -20px; padding-left: 15px;">Please update your personal information first!</p>';
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>