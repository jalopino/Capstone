<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/../static/header.php';?>
    <?php include __DIR__ . '/../templates/restrict_anon.php';?>
    <title>Profile - <?php echo $_SESSION["username"];?></title>
</head>
<body>
    <?php 
        include __DIR__ . '/../templates/nationality.php';
        include __DIR__ . '/../templates/eyecolor.php';
        include __DIR__ . '/../templates/bloodtype.php';
        include __DIR__ . '/../templates/sex.php';
    ?>
    <p style="color: black; margin-left: 10px; font-weight: bold;"><i class="fa fa-bell fa-lg" style="color: #176bfd;"></i>Notice! First time users must update their license information and credentials first.</p>
    <div class="profile-pic-popup" style="position: absolute;">
        <div class="profile-pic-popup-child">
            <h3>Upload your profile picture!</h3>
            <form action="<?php echo $base; ?>capstone/dashboard/uploadprofpic.php" method="post" enctype="multipart/form-data">
                <p style="color: #176bfd; font-weight: bold; display: inline;">Select a file:</p>
                <input type="file" name="file" id="file" style="padding-left: 0px;">
                <input class="button" type="submit" name="submit" value="Upload">
            </form>
            <div>
                <h4>Note: </h4>
                <p>Upload a JPG, JPEG, PNG file only.</p>
            </div>
        </div>
    </div>
    <div class="background-container">
        <div class="row" style="border: 2px solid black; align-items: flex-start; margin: 2%; border-radius: 10px">
            <div class="column border-table" style="flex: 25%; border-right: 1px solid black; height: 80vh;">
                <div>
                    <div class="tabs">
                        <div class="pop-up">
                            <div class="profile-pic" style="border: 1px solid black">
                            <?php 
                                if(is_null($profile_pic_path)) {
                                    echo '<a href="javascript:void(0);"><img src="'.$base.'capstone/images/default.png" alt="Profile Picture"></a>';
                                } else {
                                    echo '<a href="javascript:void(0);"><img src="' . htmlspecialchars($imglocation) . '" alt="Profile Picture"></a>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="tabs" id="changepasstab" style="cursor: pointer;">
                    <i class="fa fa-lock"></i><a href="javascript:void(0);">Change Password</a>
                    </div>
                    <div class="tabs" id="licenseinformationtab" style="cursor: pointer;">
                    <i class="fa fa-user"></i><a href="javascript:void(0);">License Information</a>
                    </div>
                </div>
            </div>
            <div class="column change-pass-tab" style="width: 70%; padding-left: 5%; padding-right: 44%;">
                <div>
                <form method="post" action="<?php echo $base; ?>capstone/auth/changepass.php">
                        <h3>Update Your Password</h3>
                        <p style="text-align: start; font-size:x-small">Old Password</p>
                        <input type="password" id="oldpass" name="oldpass" placeholder="Old Password" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small">New Password</p>
                        <input type="password" id="newpass" name="newpass" placeholder="New Password" style="border: solid black 1px;"></br>
                        <input type="submit" value="Change Password" class="button">
                    </form>
                    <?php 
                    if (isset($_SESSION['change_pass'])) {
                    $pwd_status =  $_SESSION['change_pass'];
                    echo "<h3 style='color: green;'> '. $pwd_status .'</h3>";
                    }
                    unset($_SESSION['change_pass']);
                    ?>
                </div>
            </div>
            <div class="column license-info-tab" style="width: 50%; padding-left: 5%; border-left: 1px solid black;">
                <div>
                <form method="post" action="<?php echo $base; ?>capstone/info_checker/licenseinfo.php">
                        <h3>Update Your License Information</h3>
                        <p style="text-align: start; font-size:x-small">First name</p>
                        <input type="text" id="fname" name="fname" placeholder="e.g. Juan" value="<?php echo $rtv_fname ?>" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small">Last name</p>
                        <input type="text" id="lname" name="lname" placeholder="e.g. De La Cruz" value="<?php echo $rtv_lname ?>" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small">Middle name</p>
                        <input type="text" id="mname" name="mname" placeholder="e.g. Martinez" value="<?php echo $rtv_mname ?>" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small;">Nationality</p>
                        <?php echo $nationality;?>
                        <p style="text-align: start; font-size:x-small">Sex</p>
                        <?php echo $sex;?>
                        <p style="text-align: start; font-size:x-small">Date of Birth</p>
                        <input type="date" id="dob" name="dob" style="border: solid black 1px;" value="<?php echo $rtv_dob ?>">
                        <p style="text-align: start; font-size:x-small">Weight</p>
                        <input type="number" id="weight" name="weight" placeholder="e.g. 64 (by KG)" style="border: solid black 1px;" value="<?php echo $rtv_weight ?>"></br>
                        <p style="text-align: start; font-size:x-small">Height</p>
                        <input type="number" id="height" name="height" placeholder="e.g. 1.3 (by Meters)" style="border: solid black 1px;" step="0.01" value="<?php echo $rtv_height ?>"></br>
                        <p style="text-align: start; font-size:x-small">Address (Street, City/ Municipality, Province, Zip Code)</p>
                        <input type="text" id="address" name="address" placeholder="e.g. Street, City/ Municipality, Province, Zip Code" style="border: solid black 1px;" value="<?php echo $rtv_address ?>"></br>
                        <p style="text-align: start; font-size:x-small">Blood Type</p>
                        <?php echo $bloodtype;?>
                        <p style="text-align: start; font-size:x-small">Eye color</p>
                        <?php echo $eyecolor;?>
                       <!-- <p style="text-align: start; font-size:x-small">Phone Number</p>
                        <input type="text" id="phonenum" name="phonenum" placeholder="09XXXXXXXXX" style="border: solid black 1px;"></br> -->
                        <p style="text-align: start; font-size:x-small">License No.</p>
                        <input type="text" id="license" name="license" placeholder="e.g. XXX-XX-XXXXXX" style="border: solid black 1px;" value="<?php echo $rtv_license_no ?>"></br>
                        <input type="submit" value="Update Information" class="button" style="margin-bottom: 30px;">
                    </form>
                </div>
            </div>
            <div class="column license-info-tab" style="width: 20%; padding-right: 5%; padding-left: 5%;">
                <div>
                    <h3>Upload an Image of Your License</h3>
                    <form action="<?php echo $base; ?>capstone/info_checker/pictotext.php" method="post" enctype="multipart/form-data">
                        <p style="color: #176bfd; font-weight: bold; display: inline;">Select a file:</p>
                        <input type="file" name="file" id="file" style="padding-left: 0px;">
                        <input class="button" type="submit" name="submit" value="Upload">
                    </form>
                    <div>
                        <h4>Alternatively: </h4>
                        <p>You may update your license information by uploading a picture of your driver's license.</p>
                        <p>Here's an example of how you should take the picture of your license:</p>
                        <?php echo '<img style="width: 100%; height: auto;" src="'. $base .'capstone/images/sample_license.jpg" alt="Sample License">' ?>
                        <br>
                        <?php 
                            if(isset($_SESSION["license_readable"])) {
                                if ($_SESSION["license_readable"]) {
                                    echo'<p style="color: green;">Your license number has been updated!</p>';
                                } else {
                                    echo '<p style="color: red;">The picture of your license was not clear <br> or the license number has been registered to another account. Please try again!</p>';
                                }
                                unset($_SESSION["license_readable"]);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    .tabs {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding-top: 10px;
        padding-bottom: 10px;
        border-bottom: 0.5px solid black;
    }

    .profile-pic {
        width: 100px;
        height: 100px;
        border-radius: 50%; /* Makes the container circular */
        overflow: hidden; /* Clips the image to fit the circular shape */
    }

    .profile-pic img {
        width: 100%;
        height: 100%;
        object-fit: fill; /* Resizes the image to cover the circular frame */
    }

    .overlay-text {
        opacity: 0;
    }

    .profile-pic:hover {
        background-color: black;
        opacity: 0.5;
    }

    .profile-pic-popup {
        background-color: rgba(105,105,105, 0.5);
        display: flex; 
        justify-content: center; 
        align-items: center;
        position: absolute; 
        z-index: 99; 
        width: 100%; 
        height: 90%; 
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .profile-pic-popup-child {
        height: fit-content;
        background-color: white;
        padding: 40px;
        border: 2px solid black;
        border-radius: 5px;
    }

    select {
        padding: 15px;
    }

</style>
<?php include __DIR__ . '/../static/footer.php';?>
</html> 