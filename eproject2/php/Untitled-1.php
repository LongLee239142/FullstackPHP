<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Validate form fields
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        // Send notification (e.g., email or database insert)
        // For example, send an email
        // $to = "your_email@example.com";
        // $subject = "New Message from $name";
        // $body = "Name: $name\nEmail: $email\nMessage: $message";
        // mail($to, $subject, $body);

        // Display success message
        $success = "Thank you for your message!";
        
    }
}
?>
<form method="post" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea><br>
    <input type="submit" value="Send">
</form>
<?php if (isset($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } elseif (isset($success)) { ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php } ?>