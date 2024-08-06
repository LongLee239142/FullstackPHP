<?php
// Start the session
session_start();

// Include the database connection file
include 'dbconnect.php';
if (isset($_SESSION['user_id'])) {
    // Unset session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to login page or any other page
    header("Location: ../login.php");
    exit(); // Ensure script stops execution after redirection
}

// Close the database connection
$conn->close();
?>