<?php
// Database connection parameters
$servername = "localhost"; 
$sql_username = "root"; 
$sql_password = "Duclm1201"; 
$dbname = "eprojects1"; 

// Create connection
$conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>