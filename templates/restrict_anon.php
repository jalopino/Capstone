<?php
if (!isset($_SESSION["user_id"])) {
    header("Location: {$base}capstone/index.php");
    exit();
}
?>