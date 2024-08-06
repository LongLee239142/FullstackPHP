<?php
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mail = new PHPMailer(true);

try {
    // Configuration SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // SMTP server yours
    $mail->SMTPAuth = true;
    $mail->Username = 'long.ld195887@gmail.com'; // Your Gmail email address
    $mail->Password = 'bseqjabykfetxgsm';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set up email information
    $mail->setFrom('long.ld195887@gmail.com', 'Long Le');
    $mail->addAddress($email, 'Recipient Name');
    $mail->Subject = 'Subject of the email';
    $mail->Body = 'http://localhost:8081/eproject_test/ChangePassForgot.php';

    // Send email
    $mail->send();
    $message1 = "Please Check Your Email!";
} catch (Exception $e) {
    echo "There was an error sending email: {$mail->ErrorInfo}";
}
?>