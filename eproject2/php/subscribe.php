<?php
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mail = new PHPMailer(true);


include 'dbconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email from form
    $email = $_POST['email'];

    // Check if email exists in the users table
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // User already exists, update user status to subscriber
        $updateQuery = "UPDATE users SET substatus = 1 WHERE email = '$email'";
        mysqli_query($conn, $updateQuery);
    } 

    // Insert email into subscribers table 
    $insertQuery = "INSERT INTO subscribers (email) VALUES ('$email')";
    mysqli_query($conn, $insertQuery);


    // Configuration SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // SMTP server yours
    $mail->SMTPAuth = true;
    $mail->Username = 'long.ld195887@gmail.com'; // Your Gmail email address
    $mail->Password = 'bseq jaby kfet xgsm';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set up email information
    $mail->setFrom('long.ld195887@gmail.com', 'Long Le');
    $mail->addAddress($email, 'Recipient Name');
    $mail->Subject = 'Thank you for subscribing!';
    $mail->Body = '
    Dear Subscriber,
    Thank you for subscribing to our newsletter! You are now part of our community.
    We will keep you updated with the latest news, offers, and promotions.
    Best regards,
    Your Website Team';
    try {
    // Send email
    $mail->send();
    // $message = "Please Check Your Email!";
    // echo "<script>alert('$message');</script>";
} catch (Exception $e) {
    // echo "There was an error sending email: {$mail->ErrorInfo}";
}
}