<?php
include 'php/config.php';
session_start();

// Retrieve cart information from session
$cart_info = isset($_SESSION['cart_shop']) ? $_SESSION['cart_shop'] : [];

// Function to calculate total
function calculateTotal()
{
  $total = 0;
  foreach ($_SESSION['cart_shop'] as $item) {
    $total += $item['price'] * $item['quantity'];
  }
  return $total;
}
// Save order to database when pay button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pay"])) {
  // Retrieve form data
  $address = $_POST['address'];
  $city = $_POST['city'];
  $country = $_POST['country'];
  $zip_code = $_POST['zip'];
  $payment_method = $_POST['payment_method'];

  // Insert order information into the database
  $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
  $total_amount = calculateTotal(); // Assuming calculateTotal() is a function that calculates the total cart amount
  $order_query = "INSERT INTO order_info (user_id, total_amount, address, city, country, zip_code) VALUES ('$user_id', '$total_amount', '$address', '$city', '$country', '$zip_code')";
  mysqli_query($conn, $order_query);

  // Retrieve the order ID
  $order_id = mysqli_insert_id($conn);

  // Insert order details into the database
  foreach ($cart_info as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $order_detail_query = "INSERT INTO order_detail (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$price')";
    mysqli_query($conn, $order_detail_query);
  }

  // Redirect to a thank you page or display a success message
  // header("Location: thank_you.php");
  // exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Checkout </title>
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
  <style>
    .checkout {
      margin-top: 100px;
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
            <li><a href="shop_cart.php">Cart</a></li>
            <li>Checkout</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->
    <section class="inner-page">
      <div class="checkout">
        <div class="container">
          <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
              <!-- Your cart summary -->
              <?php
              // Display cart summary
              if (!empty($cart_info)) {
                echo '<h4 class="d-flex justify-content-between align-items-center mb-3">
                      <span class="text-muted">Your cart</span>
                      <span class="badge badge-secondary badge-pill">' . count($cart_info) . '</span>
                  </h4>
                  <ul class="list-group mb-3">';
                foreach ($cart_info as $productId => $item) {
                  echo '<li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">' . $item['product_name'] . '</h6>
                                <small class="text-muted">' . $item['quantity'] . '</small>
                            </div>
                            <span class="text-muted">$' . $item['price'] * $item['quantity'] . '</span>
                        </li>';
                }
                echo '<li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$' . calculateTotal() . '</strong>
                        </li>
                    </ul>';
              } else {
                echo '<p>Your cart is empty.</p>';
              }
              ?>
            </div>
            <div class="col-md-8 order-md-1">
              <!-- Checkout form -->
              <h4 class="mb-3">Address</h4>
              <form class="needs-validation" method="post" action="process_checkout.php" novalidate>
                <div class="row">
                  <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                    <div class="invalid-feedback">
                      Please enter your shipping address.
                    </div>
                  </div>
                  <div class="row">
                    <div class="mb-3 col-md-6">
                      <label for="country">Country</label>
                      <select class="custom-select d-block w-100" id="country" name="country" required>
                        <option value="Vietnam" selected>Vietnam</option>
                      </select>
                      <div class="invalid-feedback">
                        Please select a valid country.
                      </div>
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="city">City</label>
                      <select class="custom-select d-block w-100" id="city" name="city" required>
                        <option value="">Select a city</option>
                        <!-- Populate city options dynamically using JavaScript -->
                      </select>
                      <div class="invalid-feedback">
                        Please select a city.
                      </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="zip">Zip</label>
                      <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code" required>
                      <div class="invalid-feedback">
                        Zip code required.
                      </div>
                    </div>
                  </div>

                </div>
                <hr class="mb-4">
                <h4 class="mb-3">Payment Method</h4>
                <div class="d-block my-3">
                  <div class="custom-control custom-radio">
                    <input id="credit" name="payment_method" type="radio" class="custom-control-input" value="credit_card" checked required>
                    <label class="custom-control-label" for="credit">Credit card</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <input id="shipthenpay" name="payment_method" type="radio" class="custom-control-input" value="pay_when_shipped" required>
                    <label class="custom-control-label" for="shipthenpay">Pay when shipped</label>
                  </div>
                </div>
                <!-- Payment method fields -->
                <div id="creditCardFields">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="cc-name">Name on card</label>
                      <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required>
                      <small class="text-muted">Full name as displayed on card</small>
                      <div class="invalid-feedback">
                        Name on card is required
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="cc-number">Credit card number</label>
                      <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required>
                      <div class="invalid-feedback">
                        Credit card number is required
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 mb-3">
                      <label for="cc-expiration">Expiration</label>
                      <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="" required>
                      <div class="invalid-feedback">
                        Expiration date required
                      </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="cc-cvv">CVV</label>
                      <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required>
                      <div class="invalid-feedback">
                        Security code required
                      </div>
                    </div>
                  </div>
                  <hr class="mb-4">
                  <button class="btn btn-primary btn-lg btn-block" type="submit" name="pay">Pay</button>
              </form>
            </div>
          </div>

        </div>
      </div>
      </div>
      </div>
    </section>
  </main><!-- End #main -->

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
    // Array of cities in Vietnam
    var vietnamCities = ["Ho Chi Minh City", "Hanoi", "Da Nang", "Hai Phong", "Can Tho", "Bien Hoa", "Vung Tau", "Nha Trang", "Hue", "Buon Ma Thuot"];

    // Function to populate the city dropdown
    function populateCities() {
      var citySelect = document.getElementById("city");

      // Clear existing options
      citySelect.innerHTML = "";

      // Add default option
      var defaultOption = document.createElement("option");
      defaultOption.text = "Select a city";
      citySelect.add(defaultOption);

      // Add cities from the array
      for (var i = 0; i < vietnamCities.length; i++) {
        var cityOption = document.createElement("option");
        cityOption.value = vietnamCities[i];
        cityOption.text = vietnamCities[i];
        citySelect.add(cityOption);
      }
    }

    // Populate cities when the page loads
    window.onload = function() {
      populateCities();
    };
  </script>


</body>

</html>