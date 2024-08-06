<?php
include 'php/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login_signup.php");
  exit();
}

// Retrieve user's information from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT username, email, address, phone, dob, user_image FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
} else {
  echo "User not found.";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Prrofile </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!--Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="home.php"><?php echo $websiteName; ?><span>.</span></a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto " href="#hero">Intro</a></li>
          <li><a class="nav-link scrollto " href="about-us.php">About</a></li>
          <li><a class="nav-link scrollto " href="product-list.php">Products</a></li>
          <li class="dropdown">
            <a href="#"><span>Content</span> <i class="bi bi-chevron-down"></i></a>
            <?php
            include 'php/dbconnect.php';
            // Fetch categories from the database
            $sql = "SELECT category_name FROM categories_posts";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              echo '<ul>';
              while ($row = $result->fetch_assoc()) {
                $category_name = urlencode($row['category_name']);
                $display_name = htmlspecialchars($row['category_name']);
                echo "<li><a href=\"posts.php?category=$category_name\">$display_name</a></li>";
              }
              echo '</ul>';
            } else {
              echo "No categories found.";
            }
            ?>
          </li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li>
            <?php
            if (isset($_SESSION['user_id'])) {
              include 'php/dbconnect.php';

              // Retrieve user's image path from the database
              $user_id = $_SESSION['user_id'];
              $query = "SELECT user_image FROM users WHERE user_id = $user_id";
              $result = mysqli_query($conn, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $user_image = $row['user_image'];
              }
              echo '<div class="dropdown">';
              echo '<div class="avatar dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">';
              echo '<i class="fa-solid fa-home"></i>'; // Link to user's image
              echo '</div>';
              echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
              echo '<li><a class="dropdown-item" href="shop_cart.php">Cart</a></li>';
              echo '<li><a class="dropdown-item" href="profile.php">Profile</a></li>';
              echo '<li><a class="dropdown-item" href="php/logout.php">Logout</a></li>'; // Logout link
              echo '</ul>';
              echo '</div>';
            } else {
              // If user is not logged in, display login button
              echo '<form action="login_signup.php">';
              echo '<button type="submit" class="btn btn-primary">Login</button>';
              echo '</form>';
            }
            ?>
          </li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->


  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <ol>
            <li><a href="home.php">Home</a></li>
            <li>Profile</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">

        <div class="container-xl px-4 mt-4">
          <nav class="nav nav-borders">
            <a class="nav-link active ms-0" href="profile.php" target="__blank">Profile</a>
            <a class="nav-link" href="shop_cart.php" target="__blank">Cart</a>
            <a class="nav-link" href="ChangePassword.php" target="__blank">Change password</a>
          </nav>
          <hr class="mt-0 mb-4" />
          <div class="row">
            <div class="col-xl-4">
              <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                  <img class="img-account-profile rounded-circle mb-2" src="<?php echo $user['user_image']; ?>" alt="Profile Picture" />
                  <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                  <button class="btn btn-primary" type="button">Upload new image</button>
                </div>
              </div>
            </div>
            <div class="col-xl-8">
              <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                  <form id="profileForm" action="php/update_user.php" method="post" onsubmit="return handleFormSubmit(event)">
                    <div class="mb-3">
                      <label class="small mb-1" for="inputUsername">Username</label>
                      <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Enter your username" value="<?php echo $user['username']; ?>" disabled />
                    </div>
                    <div class="mb-3">
                      <label class="small mb-1" for="inputEmailAddress">Email address</label>
                      <input class="form-control" id="inputEmailAddress" name="email" type="email" placeholder="Enter your email address" value="<?php echo $user['email']; ?>" disabled />
                    </div>
                    <div class="mb-3">
                      <label class="small mb-1" for="inputAddress">Address</label>
                      <input class="form-control" id="inputAddress" name="address" type="text" placeholder="Enter your address" value="<?php echo $user['address']; ?>" disabled />
                    </div>
                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label class="small mb-1" for="inputPhone">Phone number</label>
                        <input class="form-control" id="inputPhone" name="phone" type="tel" placeholder="Enter your phone number" value="<?php echo $user['phone']; ?>" disabled />
                      </div>
                      <div class="col-md-6">
                        <label class="small mb-1" for="inputBirthday">Birthday</label>
                        <input class="form-control" id="inputBirthday" name="dob" type="date" placeholder="Enter your birthday" value="<?php echo $user['dob']; ?>" disabled />
                      </div>
                    </div>
                    <button class="btn btn-primary" type="button" id="editButton">Edit</button>
                    <button class="btn btn-success" type="submit" id="saveButton" style="display:none;">Save changes</button>
                  </form>
                  <div id="message" class="mt-3"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
  

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3><?php echo $websiteName; ?><span>.</span></h3>
            <p>
              <?php echo nl2br($address); ?><br><br>
              <strong>Phone:</strong> <?php echo $phone; ?><br>
              <strong>Email:</strong> <?php echo $email; ?><br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="home.php">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="about-us.php">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="product-list.php">Productions</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="submit_post.php">Submit your post</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4>
            <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
            <div class="social-links mt-3">
              <?php foreach ($socialLinks as $social => $link) { ?>
                <a href="<?php echo $link; ?>" class="<?php echo $social; ?>"><i class="bx bxl-<?php echo $social; ?>"></i></a>
              <?php } ?>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span><?php echo $websiteName; ?></span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

  <!--Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
    document.getElementById('editButton').addEventListener('click', function() {
      var fields = document.querySelectorAll('#profileForm input');
      fields.forEach(function(field) {
        field.disabled = false;
      });
      document.getElementById('saveButton').style.display = 'inline-block';
      this.style.display = 'none';
    });

    function validateForm() {
      var email = document.getElementById('inputEmailAddress').value;
      var phone = document.getElementById('inputPhone').value;
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      var phonePattern = /^0\d{9}$/;

      if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        return false;
      }

      if (!phonePattern.test(phone)) {
        alert('Please enter a valid phone number (10 digits starting with 0).');
        return false;
      }

      return true;
    }

    function handleFormSubmit(event) {
      event.preventDefault();

      if (!validateForm()) {
        return false;
      }

      var form = document.getElementById('profileForm');
      var formData = new FormData(form);

      var xhr = new XMLHttpRequest();
      xhr.open('POST', form.action, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          document.getElementById('message').innerHTML = '<div class="alert alert-success">Profile updated successfully!</div>';
        } else {
          document.getElementById('message').innerHTML = '<div class="alert alert-danger">Failed to update profile. Please try again.</div>';
        }
      };
      xhr.send(formData);

      return false;
    }
  </script>

</body>

</html>