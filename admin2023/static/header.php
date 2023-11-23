<?php 
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'https' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST'].'/';
?>
<?php
    // Establish a MySQL connection (modify these parameters as needed)
    $host = 'localhost';
    $database = 'capstone';
    $username_db = 'root';
    $password_db = '';
    $conn = new mysqli($host, $username_db, $password_db, $database);
    if ($conn->connect_error) {
        echo "Connection to database failed!";
        die("Connection failed: " . $conn->connect_error);
    }

/* Prepared Statements to prevent sql injections
$query = $conn->prepare("SELECT * FROM users WHERE username_db$username_db = :username_db$username_db"); 
$query->bindParam(':username_db$username_db', $user_input);
$query->execute(); */
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);

    session_start();
?>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base; ?>capstone/style.css?version=4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="<?php echo $base; ?>capstone/scripts.js?version=12"></script>
<div class="navcontainer">
  <?php 
      echo '<a href="'.$base.'capstone/admin2023" class="logo"><img class="logo-pic" src="'.$base.'capstone/materials/logo.png" alt="Logo"></a>';
  ?>
    <nav>
      <ul>
        <?php 
            if(isset($_SESSION["admin_id"])) {
              echo '<li><i class="fa fa-table"></i><a href="'.$base.'capstone/admin2023">DASHBOARD</a></li>';
              echo '<li><i class="fa fa-arrow-right-from-bracket"></i><a href="'.$base.'capstone/auth/logout.php">LOG-OUT</a></li>';
            }
        ?>
      </ul>
    </nav>
</div>
<style>
    .profile-pic-icon {
        margin-left: 5px;
        display: inline-block;
        vertical-align: bottom;
        width: 25px;
        height: 25px;
        border-radius: 50%; /* Makes the container circular */
        overflow: hidden; /* Clips the image to fit the circular shape */
    }

    .profile-pic-icon img {
        width: 100%;
        height: 100%;
        object-fit: fill; /* Resizes the image to cover the circular frame */
    }
</style>