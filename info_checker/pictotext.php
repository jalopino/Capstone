<?php include __DIR__ . '/../static/header.php';?>
<?php include __DIR__ . '/../templates/restrict_anon.php';?>
<?php
use thiagoalessio\TesseractOCR\TesseractOCR;
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $file_name = $_FILES['file']['name'];
        $tmp_file = $_FILES['file']['tmp_name'];
        $file_name = uniqid() . '_' . time() . '_' . str_replace(array('!', "@", '#', '$', '%', '^', '&', ' ', '*', '(', ')', ':', ';', ',', '?', '/' . '\\', '~', '`', '-'), '_', strtolower($file_name));
        if (move_uploaded_file($tmp_file, __DIR__ .  '/../uploads/' . $file_name)) {
            try {
                $fileRead = (new TesseractOCR(__DIR__ .  '/../uploads/' . $file_name))
                    ->setLanguage('eng')
                    ->run();
                $findLicense = preg_split("/[\s,.]+/", $fileRead);
                //explode(" ", $fileRead); OLD METHOD OF FILTERING FOR LICENSE
                /* foreach ($findLicense as $item) {
                     echo "<li>$item</li>";
                } */
                for($x = 0; $x < count($findLicense); $x++) {
                    if (strlen($findLicense[$x]) == 13) {
                        $is_special = preg_match('/[-]/', $findLicense[$x]);
                        if ($is_special) {
                            $is_numeric = preg_match('/[0-9]/', $findLicense[$x]);
                            if ($is_numeric) {
                                echo $findLicense[$x];
                                $_SESSION['license_num'] = $findLicense[$x];
                                $_SESSION['license_readable'] = true;
                                break;
                            }
                        }
                    }  
                    $_SESSION['license_readable'] = false;
                } 
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "<p class='alert alert-danger'>File failed to upload.</p>";
        }
    }
    header("Location: {$base}capstone/info_checker/confirmation.php");
    exit();
}

?>
