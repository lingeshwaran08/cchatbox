<?php
$host = "localhost";
$user = "root"; // Change if you have a different username
$password = ""; // Change if you set a password
$database = "chatbot_db"; // Make sure this matches your database name

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


