<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "covidtrack";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname,3310);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
?>    