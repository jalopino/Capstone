<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/../static/header.php';?>
    <?php include __DIR__ . '/../templates/restrict_user.php';?>
</head>
<body>
    <div class="background-container">
    <div class="row">
            <div class="column">
                <div class="login-container" style="margin-top: 50px; margin-bottom: 50px;">
                    <div class="loginform" style="width: 20%;">
                        <form method="post" action="<?php echo $base; ?>capstone/auth/createuser.php" style="text-align: center;">
                        <img src="<?php echo $base ?>capstone/materials/logo.png" alt="LOGO" style="max-width: 40%; max-height: 40%; margin-bottom: -15px;">
                        <h1 style="color: #176bfd;">Registration</h1>
                        <p style="margin-bottom: 10px; font-size:smaller; margin-top: -10px; margin-bottom: 40px;">Register to continue</p>
                        <?php 
                            if($_SESSION["register_feedback"] == "invalid") {
                                echo '<p style="color: red;">Username or email already in use. Please choose another one.</p>';
                            }
                        ?>
                        <p style="text-align: start; font-size:x-small"><i class="fa fa-envelope"></i>EMAIL</p>
                        <input type="email" id="email" name="email" placeholder="Email" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small"><i class="fa fa-user"></i>USERNAME</p>
                        <input type="text" id="username" name="username" placeholder="Username" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small"><i class="fa fa-lock"></i>PASSWORD</p>
                        <input type="password" id="password" name="password" placeholder="Password" style="border: solid black 1px;"></br>
                        <input type="submit" value="Register" class="button">
                        </form>
                        <p style="text-align: center;">Already have an account?<a href="<?php echo $base; ?>capstone/auth/login.php"> Login here!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include __DIR__ . '/../static/footer.php';?>
</html>

