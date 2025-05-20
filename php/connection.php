<!-- connection php to database -->
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "bowling_inventory";
$port = 3306;

$connect = new mysqli($host, $user, $pass, $db, $port);

// show error message if connection failed
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>