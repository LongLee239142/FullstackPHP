<?php
// Include the database connection file
include 'dbconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert message into contact_message table
    $insertQuery = "INSERT INTO contact_message (name, email, subject, message) 
                    VALUES ('$name', '$email', '$subject', '$message')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        // Message inserted successfully
        echo "<script>alert('Message inserted successfully');</script>";
        header("Location: ../home.php");
    } else {
        // Error inserting message
        echo "<script>alert('Error inserting message');</script>";
    }
}
?>