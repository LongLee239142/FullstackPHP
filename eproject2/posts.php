<?php
include 'php/config.php';
include 'php/dbconnect.php';
session_start();
$active_page = basename($_SERVER['SCRIPT_NAME']);

// Get category parameter from the URL
if (isset($_GET['category'])) {
  $category_safe = mysqli_real_escape_string($conn, $_GET['category']);
  $category = htmlspecialchars($_GET['category']);
} else {
  // Default category if not provided
  $category_safe = "General"; // You can change this to your default category
}

// Pagination setup
$postsPerPage = 4; // Number of posts per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Get current page number
$offset = ($page - 1) * $postsPerPage; // Offset for SQL query

// Query to fetch posts based on category with pagination
$query_posts = "SELECT * FROM posts WHERE category_id IN (SELECT category_id FROM categories_posts WHERE category_name = '$category_safe') ORDER BY id DESC LIMIT $offset, $postsPerPage";
$result_posts = mysqli_query($conn, $query_posts);

// Query to count total number of posts for pagination
$totalPostsQuery = "SELECT COUNT(*) AS total FROM posts WHERE category_id IN (SELECT category_id FROM categories_posts WHERE category_name = '$category_safe')";
$totalPostsResult = mysqli_query($conn, $totalPostsQuery);
$totalPostsRow = mysqli_fetch_assoc($totalPostsResult);
$totalPosts = $totalPostsRow['total'];
$totalPages = ceil($totalPosts / $postsPerPage);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $category; ?></title>
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
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <ol>
            <li><a href="home.php">Home</a></li>
            <li><a href="posts.php?category=<?php echo $category; ?>"><?php echo $category; ?></a></li>
          </ol>
        </div>
      </div>
    </section>

    <div class="container">
      <div class="row">
        <?php
        if (mysqli_num_rows($result_posts) > 0) {
          while ($row = mysqli_fetch_assoc($result_posts)) {
            echo '<div class="col-lg-6">';
            echo '<div class="card mb-4">';
            echo '<a href="post-detail.php?post_id=' . $row['id'] . '"><img class="card-img-top" src="' . $row['post_image'] . '" alt="' . $row['title'] . '" /></a>';
            echo '<div class="card-body">';
            echo '<div class="small text-muted">' . date("F j, Y", strtotime($row['date'])) . '</div>';
            echo '<h2 class="card-title h4"><a href="post-detail.php?post_id=' . $row['id'] . '">' . $row['title'] . '</a></h2>';
            echo '<p class="card-text">' . $row['short_description'] . '</p>';
            echo '<a class="btn btn-primary" href="post-detail.php?post_id=' . $row['id'] . '">Read more →</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          // If no posts found
          echo '<div class="col-lg-12">';
          echo '<p>No posts found.</p>';
          echo '</div>';
        }
        ?>
      </div>

      <!-- Pagination -->
      <div class="row">
        <div class="col-lg-12">
          <nav aria-label="Pagination">
            <ul class="pagination justify-content-center my-4">
              <?php
              if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="posts.php?category=' . $category_safe . '&page=' . ($page - 1) . '">Newer</a></li>';
              } else {
                echo '<li class="page-item disabled"><span class="page-link">Newer</span></li>';
              }
              for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $page) {
                  echo '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
                } else {
                  echo '<li class="page-item"><a class="page-link" href="posts.php?category=' . $category_safe . '&page=' . $i . '">' . $i . '</a></li>';
                }
              }
              if ($page < $totalPages) {
                echo '<li class="page-item"><a class="page-link" href="posts.php?category=' . $category_safe . '&page=' . ($page + 1) . '">Older</a></li>';
              } else {
                echo '<li class="page-item disabled"><span class="page-link">Older</span></li>';
              }
              ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </main>




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
              <div class="input-group">
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="Your email address" required>
                <div class="invalid-feedback">
                  Please enter a valid email address.
                </div>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary">Subscribe</button>
                </div>
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
              <li><i class="bx bx-chevron-right"></i> <a href="#">Productions</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Submit your post</a></li>
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

<!-- <?php
      // Close the database connection
      mysqli_close($conn);
      ?> -->