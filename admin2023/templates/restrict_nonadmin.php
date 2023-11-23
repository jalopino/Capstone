<?php
if (!isset($_SESSION["admin_id"])) {
    header("Location: {$base}capstone/admin2023/auth/login.php");
    exit();
}
?>