<?php
$servername = "localhost";
$username = "wahid";
$password = "";
$database = "blog";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
