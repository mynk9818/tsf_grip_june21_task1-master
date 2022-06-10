<?php
$servername = "localhost";
$username = "YOUR_USERNAME_HERE";
$password = "YOUR_PASSWORD_HERE";
$dbname = "YOUR_DB_NAME_HERE";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
