<?php

$host = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection success!<br>";
    $sql = "CREATE DATABASE IF NOT EXISTS foodfusiondb";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully!<br>";
    } else {
        echo "Error creating database: " . $conn->error . "<br>";
    }
}


?>