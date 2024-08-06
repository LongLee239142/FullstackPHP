<?php
include 'php/config.php';
include 'php/Functionshopingcart.php';
$active_page = basename($_SERVER['SCRIPT_NAME']);
if (isset($_GET['action']) && $_GET['action'] == 'add_1' && isset($_GET['id']) && isset($_GET['category'])) {
    if (isset($_SESSION['user_id'])) {
        $productId = $_GET['id'];
        addToCart($productId);
        $message = "Add to cart successfully!";
    } else {
        $message1 = "You can need login!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>List Product</title>
    <!-- Favicon-->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap)-->
    <!-- <link href="assets/css/styles1.css" rel="stylesheet" /> -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style2.css" rel="stylesheet">
    <link href="assets/css/index1.css" rel="stylesheet">
</head>
<style>
     .h3-animate {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                display: none;
            }

            100% {
                opacity: 1;
                display: block;
            }
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .hidden {
            animation: fadeOut 5s forwards;
        }
</style>
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
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Produtct List</h2>
                <ol>
                    <li> <?php if (isset($message)) { ?>
                            <h3 class="h3-animate hidden" style="color: green; background-color: #ADD8E6;padding: 20px;border: 1px solid #CCCCCC;  border-radius: 5px;  margin: 0 auto;  max-width: 800px;">
                            <?php echo $message; ?></h3>
                        <?php }  ?>
                        <?php if (isset($message1)) { ?>
                            <h3 class="h3-animate hidden" style="color: red; background-color: #ADD8E6;padding: 20px;border: 1px solid #CCCCCC;  border-radius: 5px;  margin: 0 auto;  max-width: 800px;">
                            <?php echo $message1; ?></h3>
                        <?php }  ?>
                    </li>
                </ol>
                <ol>
                    <li><a href="home.php">Home</a></li>
                </ol>
            </div>

        </div>
    </section>
    <div class="container">
        <div class="row">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {

                $category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
                if (!empty($category_id)) {
                    if (!isset($_GET['price-filter'])) {
                        $pageno = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
                        $no_of_records_per_page = 9;
                        $offset = ($pageno - 1) * $no_of_records_per_page;

                        $total_pages_sql = "SELECT COUNT(*) FROM products WHERE category_id = ?";
                        $stmt = $conn->prepare($total_pages_sql);
                        $stmt->bind_param("i", $category_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $total_rows = $result->fetch_row()[0];
                        $total_pages = ceil($total_rows / $no_of_records_per_page);

                        $sql = "SELECT * FROM products WHERE category_id = ? LIMIT ?, ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("iii", $category_id, $offset, $no_of_records_per_page);
                        $stmt->execute();
                        $res_data = $stmt->get_result();
                    } else {
                        if ($_GET['price-filter'] === 'true') {
                            $pageno = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
                            $no_of_records_per_page = 9;
                            $offset = ($pageno - 1) * $no_of_records_per_page;

                            $total_pages_sql = "SELECT COUNT(*) FROM products WHERE category_id = ? ORDER BY price ASC";
                            $stmt = $conn->prepare($total_pages_sql);
                            $stmt->bind_param("i", $category_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $total_rows = $result->fetch_row()[0];
                            $total_pages = ceil($total_rows / $no_of_records_per_page);

                            $sql = "SELECT * FROM products WHERE category_id = ?  ORDER BY price ASC LIMIT ?, ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("iii", $category_id, $offset, $no_of_records_per_page);
                            $stmt->execute();
                            $res_data = $stmt->get_result();
                        }
                    }
            ?>

                    <div class="col-lg-4">
                        <!-- Side widget-->
                        <div class="card mb-4">
                            <div class="card-header">Side Widget</div>
                            <div class="card-body">
                                <form method="GET">
                                    <label for="category">
                                        <h6>Select Category:</h6>
                                    </label>
                                    <div class="form-group">
                                        <select name="category" id="category" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                            <option value="">All Categories</option>
                                            <?php
                                            // Get list data base
                                            include 'php/config.php';
                                            $sql = "SELECT category_name , category_id FROM categories";
                                            $result = $conn->query($sql);

                                            // Display list
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row["category_id"] . '" ' . ($_GET['category'] == $row["category_id"] ? 'selected' : '') . '>' .  ucfirst($row["category_name"]) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="FIlter">
                                        <input type="submit" class="btn btn-outline-dark mt-auto FiL btt" value="Filter">
                                    </div>
                                </form>
                                <!-- Search widget-->
                                <div class="card mb-4">
                                    <div class="card-header">Search</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <form method="get">
                                                <div class="input-group">
                                                    <input class="form-control" id="search" name="search" type="text" value="<?php if (isset($_GET['search'])) {
                                                                                                                                    echo htmlspecialchars($_GET['search']);
                                                                                                                                } ?>" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                                    <input type="submit" class="btn btn-primary btt" value="Go!">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-header">Price</div>
                                    <div class="card-body sortpr">
                                        <div class="row">
                                            <form method="get">
                                                <div class="pricesort">
                                                    <ul class="">
                                                        <a href="?sort=asc">Low to High</a>
                                                    </ul>
                                                    <ul class="">
                                                        <a href="?sort=desc">High to Low</a>
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 justify-content-center">
                            <?php
                            while ($data = mysqli_fetch_array($res_data)) {
                            ?>
                                <div class="col mb-4">
                                    <div class="card prd">
                                        <!-- Product image-->
                                        <img class="card-img-top" src="<?php echo $data['image']; ?>" alt="..." />
                                        <!-- Product details-->
                                        <div class="card-body">
                                            <div class="text-center">
                                                <!-- Product name-->
                                                <?php echo '<h4 class="card-title" ><a href="product-details.php?product_id=' . $data['product_id'] . '">' . $data['product_name'] . '</a></h4>'; ?>
                                                <!-- Product reviews-->
                                                <div class="card-text">
                                                    <p id="Review"><?php echo $data['description']; ?></p>
                                                </div>
                                                <!-- Product price-->
                                                $<?php echo $data['price']; ?>.00
                                            </div>
                                        </div>
                                        <!-- Product actions-->
                                        <div class="card-footer">
                                            <div class="text-center"><a class="btn btn-outline-dark mt-auto btt" value="<?php echo $product['id']; ?>" href="?action=add_1&id=<?php echo $data['product_id']; ?>&category=<?php echo urlencode($category_id); ?>&pageno=<?php echo $pageno; ?>">Add to cart</a></div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            mysqli_close($conn); ?>

                        </div>

                        <div id="page">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item <?php if ($pageno <= 1) {
                                                                echo 'disabled';
                                                            } ?>">
                                        <a class="page-link" href="<?php if ($pageno <= 1) {
                                                                        echo "?category=" . urlencode($category_id) . "&pageno=" . ($pageno - 1);
                                                                    } else {
                                                                        echo "?category=" . urlencode($category_id) . "&pageno=" . ($pageno - 1);
                                                                    } ?>">Previous</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages - 1; $i++) : ?>
                                        <?php if ($pageno == $i) { ?>
                                            <li class="page-item active"><a class="page-link" href="?category=<?php echo urlencode($category_id); ?>&pageno=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php } else { ?>
                                            <li class="page-item"><a class="page-link" href="?category=<?php echo urlencode($category_id); ?>&pageno=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php } ?>
                                    <?php endfor; ?>
                                    <?php if ($pageno == $total_pages) { ?>
                                        <li class="page-item active"><a class="page-link" href="?category=<?php echo urlencode($category_id); ?>&pageno=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a></li>
                                    <?php } else { ?>
                                        <li class="page-item"><a class="page-link" href="?category=<?php echo urlencode($category_id); ?>&pageno=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a></li>
                                    <?php } ?>
                                    <li class="page-item"><a class="page-link" href="<?php if ($pageno >= $total_pages) {
                                                                                            echo "?category=" . urlencode($category_id) . "&pageno=" . ($pageno + 1);
                                                                                        } else {
                                                                                            echo "?category=" . urlencode($category_id) . "&pageno=" . ($pageno + 1);
                                                                                        } ?>">Next</a></li>
                                </ul>
                            </nav>
                        </div><br><br>
                    </div>
                <?php
                } else {
                ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-header">Side Widget</div>
                                    <div class="card-body">
                                        <form method="GET">
                                            <label for="category">
                                                <h6>Select Category:</h6>
                                            </label>
                                            <div class="form-group">
                                                <select name="category" id="category" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value="">All Categories</option>
                                                    <?php
                                                    // Get list data base
                                                    include 'php/config.php';
                                                    $sql = "SELECT category_name , category_id FROM categories";
                                                    $result = $conn->query($sql);

                                                    // Display list
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . $row["category_id"] . '" ' . ($_GET['category'] == $row["category_id"] ? 'selected' : '') . '>' .  ucfirst($row["category_name"]) . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="FIlter">
                                                <input type="submit" class="btn btn-outline-dark mt-auto FiL btt" value="Filter">
                                            </div>
                                        </form>
                                        <div class="card mb-4">
                                            <div class="card-header">Search</div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <form method="get">
                                                        <div class="input-group">
                                                            <input class="form-control" id="search" name="search" type="text" value="<?php if (isset($_GET['search'])) {
                                                                                                                                            echo htmlspecialchars($_GET['search']);
                                                                                                                                        } ?>" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                                            <input type="submit" class="btn btn-primary btt" value="Go!">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-4">
                                            <div class="card-header">Price</div>
                                            <div class="card-body sortpr">
                                                <div class="row">
                                                    <form method="get">
                                                        <div class="pricesort">
                                                            <ul class="">
                                                                <a href="?sort=asc">Low to High</a>
                                                            </ul>
                                                            <ul class="">
                                                                <a href="?sort=desc">High to Low</a>
                                                            </ul>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $pageno = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
                            if (isset($_GET['sort'])) {
                                $sort = $_GET['sort'];
                                if ($sort === 'asc') {

                                    $no_of_records_per_page = 9;
                                    $offset = ($pageno - 1) * $no_of_records_per_page;

                                    $total_pages_sql = "SELECT COUNT(*) FROM products ORDER BY price ASC";
                                    $result = mysqli_query($conn, $total_pages_sql);
                                    $total_rows = mysqli_fetch_array($result)[0];
                                    $total_pages = ceil($total_rows / $no_of_records_per_page);
                                    $sql = "SELECT * FROM products ORDER BY price ASC LIMIT $offset, $no_of_records_per_page";
                                    $res_data = mysqli_query($conn, $sql);
                                }
                                if ($sort === 'desc') {

                                    $no_of_records_per_page = 9;
                                    $offset = ($pageno - 1) * $no_of_records_per_page;

                                    $total_pages_sql = "SELECT COUNT(*) FROM products ORDER BY price DESC";
                                    $result = mysqli_query($conn, $total_pages_sql);
                                    $total_rows = mysqli_fetch_array($result)[0];
                                    $total_pages = ceil($total_rows / $no_of_records_per_page);
                                    $sql = "SELECT * FROM products ORDER BY price DESC LIMIT $offset, $no_of_records_per_page";
                                    $res_data = mysqli_query($conn, $sql);
                                }
                            } elseif (isset($_GET['search'])) {

                                $search = filter_var($_GET['search']);
                                $no_of_records_per_page = 9;
                                $offset = ($pageno - 1) * $no_of_records_per_page;
                                $total_pages_sql = "SELECT COUNT(*) FROM products WHERE product_name LIKE '%$search%'";
                                $result = mysqli_query($conn, $total_pages_sql);
                                $total_rows = mysqli_fetch_array($result)[0];
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $sql = "SELECT* FROM products WHERE product_name LIKE '%$search%' LIMIT $offset, $no_of_records_per_page";
                                $res_data = mysqli_query($conn, $sql);
                            } else {
                                $no_of_records_per_page = 9;
                                $offset = ($pageno - 1) * $no_of_records_per_page;

                                $total_pages_sql = "SELECT COUNT(*) FROM products ";
                                $result = mysqli_query($conn, $total_pages_sql);
                                $total_rows = mysqli_fetch_array($result)[0];
                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                $sql = "SELECT* FROM products LIMIT $offset, $no_of_records_per_page";
                                $res_data = mysqli_query($conn, $sql);
                            }
                            ?>
                            <div class="col-lg-8">
                                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 justify-content-center">
                                    <?php
                                    while ($data = mysqli_fetch_array($res_data)) {
                                    ?>
                                        <div class="col mb-4">
                                            <div class="card prd">
                                                <!-- Product image-->
                                                <img class="card-img-top" src="<?php echo $data['image']; ?>" alt="..." />
                                                <!-- Product details-->
                                                <div class="card-body">
                                                    <div class="text-center">
                                                        <!-- Product name-->
                                                        <?php echo '<h4 class="card-title" ><a href="product-details.php?product_id=' . $data['product_id'] . '">' . $data['product_name'] . '</a></h4>'; ?>
                                                        <!-- Product reviews-->
                                                        <div class="card-text">
                                                            <p id="Review"><?php echo $data['description']; ?></p>
                                                        </div>
                                                        <!-- Product price-->
                                                        $<?php echo $data['price']; ?>.00
                                                    </div>
                                                </div>
                                                <!-- Product actions-->
                                                <div class="card-footer">
                                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto btt" value="<?php echo $product['id']; ?>" href="?action=add_1&id=<?php echo $data['product_id']; ?>&category=<?php echo urlencode($category_id); ?>&pageno=<?php echo $pageno; ?>">Add to cart</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    mysqli_close($conn); ?>

                                </div>
                                <?php if (isset($_GET['sort'])) { ?>
                                    <div id="page">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?php echo $pageno <= 1 ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="<?php echo $pageno <= 1 ? '#' : "?pageno=" . ($pageno - 1) . "&sort=" . $sort ?>">Prev</a>
                                                </li>
                                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                                    <li class="page-item <?php echo $pageno == $i ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?pageno=<?php echo $i; ?>&sort=<?php echo $sort ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                                <li class="page-item <?php echo $pageno >= $total_pages ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="<?php echo $pageno >= $total_pages ? '#' : "?pageno=" . ($pageno + 1) . "&sort=" . $sort ?>">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div><br><br>
                                <?php } elseif (isset($_GET['search'])) { ?>
                                    <div id="page">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?php echo $pageno <= 1 ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="<?php echo $pageno <= 1 ? '#' : "?pageno=" . ($pageno - 1) . "&search=" . $search ?>">Prev</a>
                                                </li>
                                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                                    <li class="page-item <?php echo $pageno == $i ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?pageno=<?php echo $i; ?>&search=<?php echo $search ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                                <li class="page-item <?php echo $pageno >= $total_pages ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="<?php echo $pageno >= $total_pages ? '#' : "?pageno=" . ($pageno + 1) . "&search=" . $search ?>">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div><br><br>
                                <?php } else { ?>
                                    <div id="page">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item <?php echo $pageno <= 1 ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="<?php echo $pageno <= 1 ? '#' : "?pageno=" . ($pageno - 1)  ?>">Prev</a>
                                                </li>
                                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                                    <li class="page-item <?php echo $pageno == $i ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?pageno=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                                <li class="page-item <?php echo $pageno >= $total_pages ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="<?php echo $pageno >= $total_pages ? '#' : "?pageno=" . ($pageno + 1) ?>">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div><br><br>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
            <!-- Footer-->
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