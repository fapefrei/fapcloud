<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fapcloud";

$conn = new mysqli($servername, $username, $password, $database);

$getsubjects = "SET NAMES 'utf8'";
$result = $conn->query($getsubjects);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
?>