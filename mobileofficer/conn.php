<?php 
$username = "root";
$password = "";
$host = "localhost";
$dbname = "capstone";
$connect = @mysqli_connect($host, $username, $password) or
            die("unable to connect to host.");
$db = @mysqli_select_db($connect, $dbname) or
            die("Unable to connect to students database.");
if(function_exists('get_magic_quotes_gpc') && get_magic_quotes()) {
    function undo_magic_quotes_gpc(&$array) {
            foreach($array as &$value) {
                if(is_array($value)) {
                    undo_magic_quotes_gpc($value);
                } else {
                    $value = stripslashes($value);
                }
            }
    }
    undo_magic_quotes_gpc($_POST);
    undo_magic_quotes_gpc($_GET);
    undo_magic_quotes_gpc($_COOKIE);
}
header('Content-Type: text/html; charset=utf-8');
session_start();
?>