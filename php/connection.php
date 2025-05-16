<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "bowling_inventory";
$port = 3306;

$connect = new mysqli($host, $user, $pass, $db, $port);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>