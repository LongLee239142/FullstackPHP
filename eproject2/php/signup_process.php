<?php
// Include the database connection file
include 'dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    // Validate password
    if ($password !== $repassword) {
        $error_message = "Passwords do not match.";
    // } elseif (!validatePassword($password)) {
    //     $error_message = "Password must be at least 8 characters long, contain one uppercase letter, one special character, and one number.";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $sql = "INSERT INTO users (username, email, password_hash, address, phone, dob) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $email, $password_hash, $address, $phone, $dob);
        
        if ($stmt->execute()) {
            echo "<script> alert('User registered successfully.');</script>";
            echo "<script>location.href = '../login_signup.php'</script>";
          
        } else {
            echo "<script> alert('Registration Failed');</script>";
            echo "<script>location.href = '../login_signup.php'</script>";
          
        }
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
