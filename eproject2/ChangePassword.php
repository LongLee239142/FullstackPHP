<?php
include 'php/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changepassword'])) {
    // Validate user input
    $currentPassword = $_POST['currentPassword'];
    $username = $_POST['username'];

    // Prepare the SQL statement to get the user's password hash
    $sql_m = "SELECT password_hash FROM users WHERE username = ?";
    $stmtm = $conn->prepare($sql_m);
    if (!$stmtm) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameter
    $stmtm->bind_param("s", $username);
    $stmtm->execute();
    $result = $stmtm->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password_hash = $row["password_hash"];

        if (password_verify($currentPassword, $password_hash)) {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if (empty($newPassword) || empty($confirmPassword)) {
                $error = "Please enter a new password!";
            } elseif ($newPassword !== $confirmPassword) {
                $error = "Passwords do not match!";
            } else {
                // Hash the new password
                $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Prepare the SQL statement
                $sql = "UPDATE users SET password_hash = ? WHERE username = ?";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Error preparing statement: " . $conn->error);
                }

                // Bind the parameters
                $stmt->bind_param("ss", $password_hash, $username);

                // Execute the statement
                if ($stmt->execute()) {
                    echo "<script> alert('Change Password successfully.');</script>";
                    echo "<script>location.href = 'php/logout.php'</script>";
                } else {
                    $error = "Error changing password!";
                }

                // Close the statement
                $stmt->close();
            }
        } else {
            $error = "Current password is incorrect!";
        }
    } else {
        $error = "Current password or User Name is incorrect!";
    }

    // Close the statement and the database connection
    $stmtm->close();
    $conn->close();
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
        <form action="ChangePassword.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">UserName</label>
                <input type="text" class="form-control" id="currentPassword" name="username">
            </div>
            <div class="mb-3">
                <label for="currentPassword" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword">
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword">
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
            </div>
            <?php if (isset($error)) { ?>
            <div style="background-color: #CCCCCC; border: 1px solid #FF0000; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
              <h3 style="color: red;"><?php echo $error; ?></h3>
            </div>
          <?php }  ?>
            <button type="submit" class="btn btn-primary" name="changepassword">Change Password</button>
            <a href="home.php" class="btn btn-lg btn-default md-btn-flat mt-2 mr-3">Back to Home</a>
        </form>
    </div>

</body>

</html>