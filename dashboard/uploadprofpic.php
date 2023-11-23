<?php include __DIR__ . '/../static/header.php';?>
<?php include __DIR__ . '/../templates/restrict_anon.php';?>
<?php
$userId = $_SESSION["user_id"];
if (isset($_POST["submit"])) {
    $targetDir = __DIR__ .  "/../images/";
    $targetFile = $targetDir . uniqid() . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // ... (previous validation code)
        // Check if the file is an actual image or a fake image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    
        // Check if the file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
    
        // Check the file size (in this example, it's limited to 2MB)
        if ($_FILES["file"]["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        // Allow only specific file formats (you can modify this list)
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } 

    if ($uploadOk == 1) {
        unlink($profile_pic_path);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";

            // Insert the file path into the user's profile picture column
            $filePath = mysqli_real_escape_string($conn, $targetFile);
            $sql = "UPDATE users SET prof_img = '$filePath' WHERE user_id = $userId";

            if ($conn->query($sql) === TRUE) {
                echo "The profile picture has been updated in the database.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        header("Location: {$base}capstone/dashboard/home.php");
        exit();
    }
}
?>
