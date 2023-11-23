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
                <div class="login-container">
                    <div class="loginform" style="width: 20%">
                        <form name="login" method="post" action="<?php echo $base; ?>capstone/auth/auth.php" style="text-align: center;">
                        <img src="<?php echo $base ?>capstone/materials/logo.png" alt="LOGO" style="max-width: 40%; max-height: 40%; margin-bottom: -15px;">
                        <h1 style="color: #176bfd;">Login</h1>
                        <p style="margin-bottom: 10px; font-size:smaller; margin-top: -10px; margin-bottom: 40px;">Sign in to continue</p>
                        <?php
                        if ($_SESSION["register_feedback"] == "success") {
                            echo '<p style="color: green;">Successfully registered!</p>';
                            session_destroy();
                        } else if ($_SESSION["login_feedback"] == ("invalid_password" || "invalid_user")) {
                            echo '<p style="color: red;">Invalid username or password!</p>';
                            session_destroy();
                        } 
                        ?>
                        <p style="text-align: start; font-size:x-small"><i class="fa fa-user"></i>USERNAME</p>
                        <input type="text" id="username" name="username" placeholder="Username" style="border: solid black 1px;"></br>
                        <p style="text-align: start; font-size:x-small"><i class="fa fa-lock"></i>PASSWORD</p>
                        <input type="password" id="password" name="password" placeholder="Password" style="border: solid black 1px;"></br>
                        <input type="submit" value="Login" class="button">
                        </form>
                        <p style="text-align: center;">Don't have an account?<a href="<?php echo $base; ?>capstone/auth/register.php"> Register here!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include __DIR__ . '/../static/footer.php';?>
</html>

