<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log - out</title>
    <?php include __DIR__ . '/../static/header.php';?>
</head>
<body>
    <?php 
    //Destroy the session
    session_destroy();
    // Redirect to a login page or any other desired page
    header("Location: {$base}capstone/index.php");
    exit();
    ?>
</body>
</html>