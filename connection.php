<?php
$servername = "localhost";
$username = "root";
$password = null;

//Connection
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//Database
$sql = "CREATE DATABASE IF NOT EXISTS UserDB";
if ($conn->query($sql) === TRUE) {
    echo " ";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}
$conn->select_db('UserDB');

// Users
$sql = "CREATE TABLE IF NOT EXISTS Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    UserName VARCHAR(100),
    Email VARCHAR(255),
    Password VARCHAR(255)
)";
if ($conn->query($sql) === TRUE) {
    echo " ";
} else {
    echo "Error creating table Users: " . $conn->error . "<br>";
}

// Close connection
// $conn->close();
?>
