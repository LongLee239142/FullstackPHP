<?php

include 'php/Functionshopingcart.php';
include 'php/dbconnect.php';

// Ađd product to cart
if (isset($_POST['update_cart'])) {
  $productId = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  updateCartQuantity($productId, $quantity);
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'add_2' && isset($_GET['id'])) {
  $productId = $_GET['id'];
  removeQuantity($productId);
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}
function getCartInfo()
{
  $cart_info = [];
  if (isset($_SESSION['cart_shop']) && !empty($_SESSION['cart_shop'])) {
    foreach ($_SESSION['cart_shop'] as $productId => $item) {
      $cart_info[] = $item;
    }
  }
  return $cart_info;
}


if (isset($_POST['checkout_action']) && $_POST['checkout_action'] == 'checkout') {
  // Redirect to checkout.php
  header('Location: checkout.php');
  exit;
}

?>

<?php
include 'php/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Shopping cart</title>
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
  <style type="text/css">
    .card {
      margin-top: 150px;
    }

    .ui-w-40 {
      width: 40px !important;
      height: auto;
    }


    .ui-product-color {
      display: inline-block;
      overflow: hidden;
      margin: .144em;
      width: .875rem;
      height: .875rem;
      border-radius: 10rem;
      -webkit-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
      box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
      vertical-align: middle;
    }
  </style>

</head>

<body>
  <!-- ======= Header ======= -->

  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="home.php"><?php echo $websiteName; ?><span>.</span></a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="home.php/#hero">Intro</a></li>
          <li><a class="nav-link scrollto" href="about-us.php">About</a></li>
          <li><a class="nav-link scrollto" href="product-list.php">Products</a></li>
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
              echo '<div class="avatar">';
              echo '<img src="' . $user_image . '" alt="User Avatar">'; // Link to user's image
              echo '</div>';
              echo '<ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">';
              echo '<li><a class="dropdown-item" href="#">Profile</a></li>';
              echo '<li><a class="dropdown-item" href="#">Cart</a></li>';
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
    <div class="container px-3 my-5 clearfix">
      <!-- Shopping cart table -->
      <div class="card">
        <div class="card-header">
          <h2>Shopping Cart</h2>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered m-0">
              <thead>
                <tr>
                  <!-- Set columns width -->
                  <th class="text-center py-3 px-4" style="min-width: 300px;">Product Name &amp; Details</th>
                  <th class="text-right py-3 px-4" style="width: 30px;">Price</th>
                  <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                  <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
                  <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($_SESSION['cart_shop']) && !empty($_SESSION['cart_shop'])) : ?>
                  <?php foreach ($_SESSION['cart_shop'] as $productId => $item) : ?>
                    <tr>
                      <td class="p-4">
                        <div class="media align-items-center">
                          <img src="<?php echo $item['imageproduct']; ?>" class="d-block ui-w-40 ui-bordered mr-4" alt="">
                          <div class="media-body">
                            <a href="#" class="d-block text-dark"><?php echo $item['product_name']; ?> </a>
                            <small>
                              <span class="text-muted">Category:</span>
                              <span class="text-muted"><?php echo $item['category_name']; ?></span>
                            </small>
                          </div>
                        </div>
                      </td>
                      <td class="text-center py-3 px-4 align-middle p-4">
                        $<?php echo $item['price']; ?>
                      </td>
                      <td class="align-middle p-4">
                        <form method="post" action="">
                          <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                          <input type="number" class="form-control text-center" value="<?php echo $item['quantity']; ?>" name="quantity">
                          <input type="submit" class="btn btn-primary" name="update_cart" value="Update">
                        </form>
                      </td>
                      <td class="text-center py-3 px-4 align-middle p-4">
                        <?php echo '$' . ($item['quantity']) * ($item['price']); ?>
                      </td>
                      <td class="text-center align-middle px-0">
                        <?php
                        $delete_link = '<a href="?action=add_2&id=' . $productId . '" class="shop-tooltip close float-none text-danger" title="" data-original-title="Remove" onclick="return confirm(\'Are you sure you want to delete?\')">×</a>';
                        echo $delete_link;
                        ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>

          </div>
          <!-- / Shopping cart table -->

          <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
            <div class="d-flex">
              <div class="text-right mt-4">
                <?php if (isset($_SESSION['cart_shop']) && !empty($_SESSION['cart_shop'])) : ?>
                  <label class="text-muted font-weight-normal m-0">Total price</label>
                  <div class="text-large"><strong>$<?php echo calculateTotal(); ?></strong></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <form method="post" action="">
            <div class="float-right">
              <button type="submit" class="btn btn-primary" name="checkout_action" value="checkout">Checkout</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main><!-- End #main -->



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