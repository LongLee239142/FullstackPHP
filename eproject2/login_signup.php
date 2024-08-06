<?php
include 'php/login_process.php';
include 'php/signup_process.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="assets/css/login_signup.css" />
  <link rel="stylesheet" href="assets/css/login_signup1.css" />
  <title>Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form id="sign-in-form" action="" class="sign-in-form" method="post">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="login_email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="login_password" />
          </div>
          <?php if (isset($error)) { ?>
            <div style="background-color: #CCCCCC; border: 1px solid #FF0000; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
              <h3 style="color: red;"><?php echo $error; ?></h3>
            </div>
          <?php }  ?>
          <a href="ForgetPass.php">Forgot Password?</a>
          <input type="submit" value="Login" class="btn solid" name="login" />
          <div class="text-center"><a href="home.php" class="continute">Continute without Login</a></div>
        </form>
        



        <form id="sign-up-form" action="php/signup_process.php" class="sign-up-form" method="post">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" name="username" />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" />
            <p class="error-message password-error"></p>
            <!-- Error message placeholder -->
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Re-Enter Password" name="repassword" />
            <p class="error-message password-error"></p>
            <!-- Error message placeholder -->
          </div>
          <div class="input-field">
            <i class="fa fa-phone"></i>
            <input type="text" placeholder="Phone" name="phone" />
          </div>
          <div class="input-field">
            <i class="fas fa-calendar"></i>
            <input type="text" id="dob" name="dob" placeholder="Date Of Birth" onfocus="(this.type='date')" onblur="(this.type='text')" name="dob" />
          </div>
          <div class="input-field">
            <i class="fas fa-map-marker-alt"></i>
            <input type="text" placeholder="Address" name="address" />
          </div>
          <input type="submit" class="btn" value="Sign up" name="signup" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
            ex ratione. Aliquid!
          </p>
          <button class="btn transparent" id="sign-up-btn">Sign up</button>
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
            laboriosam ad deleniti.
          </p>
          <button class="btn transparent" id="sign-in-btn">Sign in</button>
        </div>
        <img src="img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="assets/js/login_signup.js"></script>
  <!-- <script src="assets/js/signup_validation.js"></script> -->
</body>

</html>