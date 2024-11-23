<?php

$host = 'localhost';    // Server host (usually 'localhost')
$username = 'root';      // Your MySQL username
$password = '';          // Your MySQL password
$database = 'shop';      // The name of your database

// Create connection
$conn = new mysqli($host, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Connected successfully to the 'shop' database.";
}
?>
