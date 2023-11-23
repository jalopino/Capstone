<?php
require("conn.php");
$sql = "UPDATE violations SET Fullname = " . $_REQUEST["Fullname"] . " , Dateofbirth = " . $_REQUEST["Dateofbirth"] . " , Licensenumber = " . $_REQUEST["Licensenumber"] . " , Typeofviolation = " . $_REQUEST["Typeofviolation"] . " WHERE ViolationID = '" . $_REQUEST["ViolationID"] . "'";
try {
    $dbrecords = mysqli_query($connect, $sql);
} catch (Exception $e) {
    $response["success"] = 0;
    $response["message"] = "Database Error #1. Please Try Again!";
    die(json_encode($response));
}
$response["success"] = 0;
$response["message"] = "Record Updated";
die(json_encode($response));
?>