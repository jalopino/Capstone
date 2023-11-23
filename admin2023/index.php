<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <?php include __DIR__ . '/../admin2023/static/header.php';?>
    <?php include __DIR__ . '/../admin2023/templates/restrict_nonadmin.php';?>
</head>
<body>
    <div>
        <div class="login-container">
            <h1 style="position: absolute; margin-top: -200px; font-weight: bold;">
                    ADMIN DASHBOARD
            </h1>
            <div class="row">
                <div class="column" style="flex: 25%;">
                    <div style="display:flex; align-items: center; justify-content: center;">
                        <a href="<?php echo $base . "capstone/admin2023/analytics/analytics.php" ?>">
                            <div class="loginform button">
                                <h1>ANALYTICS<i class="fa fa-chart-simple" style="margin-left: 5px;"></i></h1>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="column" style="flex: 25%;">
                    <div style="display:flex; align-items: center; justify-content: center;">
                        <a href="<?php echo $base . "capstone/admin2023/violations/manage_violations.php" ?>">
                            <div class="loginform button">
                                    <h1>MANAGE VIOLATIONS<i class="fa fa-circle-info" style="margin-left: 5px;"></i></h1>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="column" style="flex: 25%;">
                    <div style="display:flex; align-items: center; justify-content: center;">
                        <a href="<?php echo $base . "capstone/admin2023/officers/manageofficer.php" ?>">
                            <div class="loginform button">
                                    <h1>MANAGE OFFICERS<i class="fa fa-user" style="margin-left: 5px;"></i></h1>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="column" style="flex: 25%;">
                    <div style="display:flex; align-items: center; justify-content: center;">
                        <a href="<?php echo $base . "capstone/admin2023/users/manageuser.php" ?>">
                            <div class="loginform button">
                                    <h1>MANAGE USERS<i class="fa fa-user" style="margin-left: 5px;"></i></h1>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php include __DIR__ . '/../static/footer.php';?>


<style>
    .loginform {
        height: auto;
        width: max-content;
        justify-content: center;
        align-items: center;
        margin: 10px;
        padding: 10px;
    }
    h1 {
        text-align: center;
    }
    .button {
        border-radius: 5px;
    }

</style>