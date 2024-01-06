<?php

$hostname = "localhost:3306";
$username = "root";
$password = "";
$database = "micro02";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de connexió: " . $conn->connect_error);
}

?>