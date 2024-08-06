<?php
session_start(); // Start a session

include 'php/dbconnect.php';

// Function to verify the user's credentials against the database
function verifyLogin($conn, $username, $password)
{
    // Prepare SQL statement to retrieve the user's data
    $stmt = $conn->prepare("SELECT * FROM employee WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row with the provided username exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $row['password_hash'])) {
            return $row; // Return user data if login successful
        }
    }

    return false; // Login failed
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify the user's credentials
    $user = verifyLogin($conn, $username, $password);
    if ($user) {
        // Login successful, set session variables
        $_SESSION['user_id'] = $user['id'];
        // Redirect the user to index.php
        header("Location: index.php");
        exit(); // Make sure no other output is sent
    } else {
        // Login failed, redirect back to the login page with an error message
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OPM - Login</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #4e73df;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            width: 400px;
            margin: 0 auto;
            border: 0;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        .form-control-user {
            border-radius: 25px;
            padding: 1rem 2rem;
            font-size: 0.9rem;
            background-color: #f8f9fc;
        }

        .btn-user {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }

        .alert {
            margin-bottom: 0;
            border-radius: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-lg-6">
            <div class="card o-hidden">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Admin Page OPM</h1>
                        </div>
                        <?php
                        // Display error message if login failed
                        if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials') {
                            echo '<div class="alert alert-danger" role="alert">Invalid username or password.</div>';
                        }
                        ?>
                        <form class="user" id="loginForm" method="post" action="login.php">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputUsername" name="username" aria-describedby="emailHelp" placeholder="Enter Username...">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        // JavaScript to show the alert message if login fails
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            var username = document.getElementById('exampleInputUsername').value.trim();
            var password = document.getElementById('exampleInputPassword').value.trim();
            if (username === '' || password === '') {
                event.preventDefault(); // Prevent form submission
                var errorMessage = document.createElement('div');
                errorMessage.classList.add('alert', 'alert-danger');
                errorMessage.textContent = 'Please enter both username and password.';
                document.getElementById('loginForm').appendChild(errorMessage);
                errorMessage.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    </script>
</body>

</html>