<?php
if (!isset($_COOKIE['my_cookie'])) {

    header("Location: ForgetPass.php");

    exit();
} else {
    include 'php/dbconnect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changepassword'])) {
        // Validate user input
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        $username = $_COOKIE['my_cookie'];
        if (empty($newPassword) || empty($confirmPassword)) {
            $error = "Please enter a new password.";
        } elseif ($newPassword !== $confirmPassword) {
         
            $error = "Passwords do not match!";
        } else {
            // Hash the new password
            $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Prepare the SQL statement
            $sql = "UPDATE users SET password_hash = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bind_param("ss", $password_hash, $username);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the login/signup page
                echo "<script> alert('Change Password successfully.');</script>";
                echo "<script>location.href = 'login_signup.php'</script>";
            } else {
                $error = "Error changing password!";
            }

            // Close the statement
            $stmt->close();
        }

        // Close the database connection
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />   -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>

<body>
    <div class="container">
        <h2>Change Password</h2>
        <form action="ChangePassForgot.php" method="post">
            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword">
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
            </div>
            <?php if (isset($error)) { ?>
                <h3 style="color: red;"><?php echo $error; ?></h3>
            <?php }  ?>
            <button type="submit" class="btn btn-primary" name="changepassword">Change Password</button>
        </form>
    </div>

</body>

</html>