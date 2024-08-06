<?php
include "php/config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}


// Include database connection
include "php/dbconnect.php";

// Fetch orders for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM order_info WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any orders found
if ($result->num_rows > 0) {
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Total Amount</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Output each order as a table row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['order_id']}</td>";
                                    echo "<td>{$row['total_amount']}</td>";
                                    echo "<td>{$row['address']}</td>";
                                    echo "<td>{$row['city']}</td>";
                                    echo "<td>{$row['country']}</td>";
                                    echo "<td>{$row['order_date']}</td>";
                                    echo "<td>";
                                    // View order details link
                                    echo "<a href='order_details.php?order_id={$row['order_id']}' class='btn btn-primary btn-sm'>View Details</a> ";
                                    // Cancel order link
                                    echo "<a href='cancel_order.php?order_id={$row['order_id']}' class='btn btn-danger btn-sm'>Cancel</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

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


    </body>

    </html>

<?php
} else {
    // No orders found for the user
    echo "<p>No orders found.</p>";
}

// Close database connection
$stmt->close();
$conn->close();
?>