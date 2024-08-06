<?php 
include 'ForgetPass_processing.php'
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
        <h2>Forger Password</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="Email" class="form-label">Your Email</label>
                <input type="Email" class="form-control" id="Email" name = "email">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">User name</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <?php if (isset($message)) { ?>
            <div style="background-color: #CCCCCC; border: 1px solid #FF0000; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
              <h3 style="color: red;"><?php echo $message; ?></h3>
            </div>
          <?php }  ?>
          <?php if (isset($message1)) { ?>
            <div style="background-color: #CCCCCC; border: 1px solid green; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
              <h3 style="color: green;"><?php echo $message1; ?></h3>
            </div>
          <?php }  ?>
            <button type="submit" class="btn btn-primary" name="Send">Send</button>
        </form>
    </div>

</body>

</html>