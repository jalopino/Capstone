<?php
if (isset($_SESSION["user_id"])) {
    header("Location: {$base}capstone/dashboard/home.php");
    exit();
}
?>