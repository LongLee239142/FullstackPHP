<?php
include 'php/config.php';
include 'php/Functionshopingcart.php';
if (isset($_GET['action']) && $_GET['action'] == 'add_3' && isset($_GET['id'])) {
  if (isset($_SESSION['user_id'])) {
    $productId = $_GET['id'];
    addToCart($productId);
    $message = "Add to cart successfully!";
    echo "<script>alert('$message');</script>";
    echo "<script>location.href ='product-list.php'</script>";
  } else {
    $message = "You can need login!";
    echo "<script>alert('$message');</script>";
    echo "<script>location.href ='home.php'</script>";
  }
}

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
  <main id="main" data-aos="fade-up">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <ol>
            <li><a href="home.php">Home</a></li>
            <li><a href="product-list.php"></a>Products List</li>

          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <?php
    include 'php/dbconnect.php'; // Include your database connection file

    if (isset($_GET['product_id'])) {
      // Sanitize the input to prevent SQL injection
      $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);

      // Updated SQL query to fetch product details along with category name
      $query = "SELECT p.*, c.category_name 
              FROM products p 
              INNER JOIN categories c ON p.category_id = c.category_id
              WHERE p.product_id = '$product_id'";

      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    ?>
        <!-- ======= Product Details Section ======= -->
        <section id="product-details" class="product-details">
          <div class="container">
            <div class="row gy-4">
              <div class="col-lg-8">
                <div class="product-details-slider swiper">
                  <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide">
                      <img src="<?php echo $row['image']; ?>" alt="">
                    </div>
                  </div>
                  <div class="swiper-pagination"></div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="product-info">
                  <h3>Product information</h3>
                  <ul>
                    <li><strong>Category:</strong> <?php echo $row['category_name']; ?></li> 
                    <li><strong>Price:</strong> <?php echo '$' . $row['price']; ?></li>
                    <li><strong>Description:</strong> <?php echo $row['description']; ?></li> 
                    <li>
                      <div class="text-center"><a class="btn btn-outline-dark mt-auto" value="<?php echo $product['id']; ?>" href="?action=add_3&id=<?php echo $row['product_id']; ?>">Add to cart</a></div>
                    </li>
                  </ul>
                </div>
                <div class="product-description">
                  <h2>Product detail</h2>
                  <?php
                  // Read the HTML content from the file
                  $description_file = $row['description_detail'];
                  if (file_exists($description_file)) {
                    echo file_get_contents($description_file);
                  } else {
                    echo "Description not available.";
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </section><!-- End product Details Section -->
    <?php
      } else {
        // If no product found with the given ID
        echo "Product not found.";
      }
    } else {
      // If product_id is not set in the URL
      echo "Product ID not specified.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>


  </main><!-- End #main -->


  </main><!-- End #main --> <!-- ======= Footer ======= -->
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