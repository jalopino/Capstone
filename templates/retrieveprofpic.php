<?php
// Prepare and execute a secure SQL query
if(isset($_SESSION["user_id"])) {
    $sql = "SELECT prof_img FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($profile_pic_path);
        $stmt->fetch();
    }
    $imglocation = substr($profile_pic_path, 15);
}
?>


