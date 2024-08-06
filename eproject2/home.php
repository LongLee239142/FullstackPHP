<?php
include 'php/config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Home</title>
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">


  <!--Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

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

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1>Welcome to <span><?php echo $websiteName; ?></span></h1>
      <h2> <?php echo $webintro; ?> </php>
      </h2>
      <div class="d-flex">
        <a href="#product" class="btn-get-started scrollto">Get Started</a>
        <a href="<?php echo $video; ?>" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
      </div>
    </div>
  </section><!-- End Hero -->
  <main id="main">

    <!-- ======= Product Section ======= -->
    <section id="product" class="product">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2><a href="product-list.php">Product</a></h2>
          <h3>Featured <span>products</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>


        <div class="row product-container" data-aos="fade-up" data-aos-delay="200">

          <?php
          include 'php/dbconnect.php'; // Include the database connection file

          // Query to select the top 10 products
          $query = "SELECT * FROM products ORDER BY price DESC LIMIT 6";

          // Execute the query
          $result = mysqli_query($conn, $query);

          // Check if there are any results
          if (mysqli_num_rows($result) > 0) {
            // Loop through each row
            while ($row = mysqli_fetch_assoc($result)) {
              // Output HTML for each product
              echo '<div class="col-lg-4 col-md-6 product-item">';
              echo '<img src="' . $row['image'] . '" class="img-fluid" alt="">';
              echo '<div class="product-info">';
              echo '<h4>' . $row['product_name'] . '</h4>';
              echo '<p>$' . $row['price'] . '</p>';
              echo '<p>' . $row['description'] . '</p>';
              echo '<a href="product-details.php?product_id=' . $row['product_id'] . '" class="details-link" title="More Details"><i class="bx bx-link"></i></a>';
              echo '</div>';
              echo '</div>';
            }
          } else {
            // If no products are found
            echo 'No products found.';
          }


          ?>

        </div>
    </section><!-- End product Section -->

    <!-- ======= Post Section ======= -->
    <section id="post" class="post section-bg">
      <div class="container" data-aos="fade-up">
        <?php
        include 'php/dbconnect.php'; // Include the database connection file

        // Query to fetch the category
        $category_name = "Rain Harvesting Methods";
        $category_name_safe = mysqli_real_escape_string($conn, $category_name); // Sanitize the category name

        // Query to get the category ID based on the category name
        $query_category_id = "SELECT category_id FROM categories_posts WHERE category_name = '$category_name_safe'";
        $result_category_id = mysqli_query($conn, $query_category_id);

        // Check if the category exists
        if ($result_category_id && mysqli_num_rows($result_category_id) > 0) {
          $row_category_id = mysqli_fetch_assoc($result_category_id);
          $category_id = $row_category_id['category_id'];

          // Query to load top 4 posts with the same category ID
          $query_top_posts = "SELECT id, title, short_description, post_image FROM posts WHERE category_id = $category_id AND approval_state = 1 ORDER BY id DESC LIMIT 4";
          $result_top_posts = mysqli_query($conn, $query_top_posts);

          // Check if there are any top posts
          if ($result_top_posts && mysqli_num_rows($result_top_posts) > 0) {
            echo '<div class="section-title">';
            echo '<h2><a href="posts.php?category=' . $category_name_safe . '">' . $category_name . '</a></h2>';
            echo '<p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>';
            echo '</div>';
            echo '<div class="row">';

            // Loop through top 4 posts
            while ($row = mysqli_fetch_assoc($result_top_posts)) {
              echo '<div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">';
              echo '<div class="post">';
              echo '<div class="post-img">';
              // Assuming post_image contains the image URL in the database
              echo '<img src="' . $row['post_image'] . '" class="img-fluid" alt="" >';
              echo '</div>';
              echo '<div class="post-info">';
              echo '<h4><a href="post-detail.php?post_id=' . $row['id'] . '">' . $row['title'] . '</a></h4>';
              echo '<span>' . $row['short_description'] . '</span>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }

            echo '</div>'; // End row
          } else {
            // If no top posts found
            echo '<p>No posts found.</p>';
          }
        } else {
          // If the category does not exist
          echo '<p>Category not found.</p>';
        }
        ?>
      </div>
    </section>

    <section id="post" class="post section-bg">
      <div class="container" data-aos="fade-up">
        <?php
        include 'php/dbconnect.php'; // Include the database connection file

        // Query to fetch the category
        $category_name = "Latest Developments In Rain Harvesting"; // You can set the category dynamically or retrieve it from somewhere
        $category_name_safe = mysqli_real_escape_string($conn, $category_name); // Sanitize the category name

        // Query to get the category ID based on the category name
        $query_category_id = "SELECT category_id FROM categories_posts WHERE category_name = '$category_name_safe'";
        $result_category_id = mysqli_query($conn, $query_category_id);

        // Check if the category exists
        if ($result_category_id && mysqli_num_rows($result_category_id) > 0) {
          $row_category_id = mysqli_fetch_assoc($result_category_id);
          $category_id = $row_category_id['category_id'];

          // Query to load top 4 posts with the same category ID
          $query_top_posts = "SELECT id, title, short_description, post_image FROM posts WHERE category_id = $category_id AND approval_state = 1 ORDER BY id DESC LIMIT 4";
          $result_top_posts = mysqli_query($conn, $query_top_posts);

          // Check if there are any top posts
          if ($result_top_posts && mysqli_num_rows($result_top_posts) > 0) {
            echo '<div class="section-title">';
            echo '<h2><a href="posts.php?category=' . $category_name_safe . '">' . $category_name . '</a></h2>';
            echo '<p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>';
            echo '</div>';
            echo '<div class="row">';

            // Loop through top 4 posts
            while ($row = mysqli_fetch_assoc($result_top_posts)) {
              echo '<div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">';
              echo '<div class="post">';
              echo '<div class="post-img">';
              // Assuming post_image contains the image URL in the database
              echo '<img src="' . $row['post_image'] . '" class="img-fluid" alt="" >';
              echo '</div>';
              echo '<div class="post-info">';
              echo '<h4><a href="post-detail.php?post_id=' . $row['id'] . '">' . $row['title'] . '</a></h4>';
              echo '<span>' . $row['short_description'] . '</span>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }

            echo '</div>'; // End row
          } else {
            // If no top posts found
            echo '<p>No posts found.</p>';
          }
        } else {
          // If the category does not exist
          echo '<p>Category not found.</p>';
        }
        ?>
      </div>
    </section>


    <section id="post" class="post section-bg">
      <div class="container" data-aos="fade-up">
        <?php
        include 'php/dbconnect.php'; // Include the database connection file

        // Query to fetch the category
        $category_name = "Effectively Make Use Of Rain Water"; // You can set the category dynamically or retrieve it from somewhere
        $category_name_safe = mysqli_real_escape_string($conn, $category_name); // Sanitize the category name

        // Query to get the category ID based on the category name
        $query_category_id = "SELECT category_id FROM categories_posts WHERE category_name = '$category_name_safe'";
        $result_category_id = mysqli_query($conn, $query_category_id);

        // Check if the category exists
        if ($result_category_id && mysqli_num_rows($result_category_id) > 0) {
          $row_category_id = mysqli_fetch_assoc($result_category_id);
          $category_id = $row_category_id['category_id'];

          // Query to load top 4 posts with the same category ID
          $query_top_posts = "SELECT id, title, short_description, post_image FROM posts WHERE category_id = $category_id AND approval_state = 1 ORDER BY id DESC LIMIT 4";
          $result_top_posts = mysqli_query($conn, $query_top_posts);

          // Check if there are any top posts
          if ($result_top_posts && mysqli_num_rows($result_top_posts) > 0) {
            echo '<div class="section-title">';
            echo '<h2><a href="posts.php?category=' . $category_name_safe . '">' . $category_name . '</a></h2>';
            echo '<p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>';
            echo '</div>';
            echo '<div class="row">';

            // Loop through top 4 posts
            while ($row = mysqli_fetch_assoc($result_top_posts)) {
              echo '<div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">';
              echo '<div class="post">';
              echo '<div class="post-img">';
              // Assuming post_image contains the image URL in the database
              echo '<img src="' . $row['post_image'] . '" class="img-fluid" alt="" >';
              echo '</div>';
              echo '<div class="post-info">';
              echo '<h4><a href="post-detail.php?post_id=' . $row['id'] . '">' . $row['title'] . '</a></h4>';
              echo '<span>' . $row['short_description'] . '</span>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }

            echo '</div>'; // End row
          } else {
            // If no top posts found
            echo '<p>No posts found.</p>';
          }
        } else {
          // If the category does not exist
          echo '<p>Category not found.</p>';
        }
        ?>
      </div>
    </section>




    <!-- End Post Section -->



    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <h3><span>Contact Us</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-6">
            <div class="info-box mb-4">
              <i class="bx bx-map"></i>
              <h3>Our Address</h3>
              <p><?php echo $address; ?></p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p><?php echo $email; ?></p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3>Call Us</h3>
              <p><?php echo $phone; ?></p>
            </div>
          </div>

        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-6 ">
            <iframe class="mb-4 mb-lg-0" src="<?php echo $mapaddress; ?>" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
          </div>

          <div class="col-lg-6">
            <form id="contact-form" action="php/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit" id="submit-btn">Send Message</button></div>
            </form>
          </div>


        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <div id="subscribe-message"></div>
            <form id="subscribe-form" action="php/subscribe.php" method="post" class="needs-validation" novalidate>
              <div class="form-group">
                <div class="invalid-feedback">
                  Please enter a valid email address.
                </div>
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="Your email address" required><input type="submit" value="Subscribe">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


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
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
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


</body>

</html>