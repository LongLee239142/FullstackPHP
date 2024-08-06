<?php
include 'php/config.php';
include 'php/config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Submit Post</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/ta3a3nnxbrpfktvlpyz7pvwedc7wath13vpqg31gypmgg2sb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | link image | removeformat | help',
            setup: function (editor) {
                editor.on('init', function () {
                    editor.getBody().classList.add('bootstrap-content');
                });
            }
        });
    </script>

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
              $query = "SELECT  username  FROM users WHERE user_id = $user_id";
              $result = mysqli_query($conn, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // $user_image = $row['user_image'];
                $username = $row['username'];
              }
              echo '<div class="dropdown">';
              echo '<div class="avatar dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">';
              echo '<i class="fa-solid fa-home"></i>'; // Link to user's image
              echo '</div>';
              echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
              echo '<li><a class="dropdown-item" href="shop_cart.php">Cart</a></li>';
              echo '<li><a class="dropdown-item" href="ChangePassword.php">Repassword</a></li>';
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
                    <h2>Submit Post</h2>
                    <ol>
                        <li><a href="home.php">Home</a></li>
                        <li>Submit Post</li>
                    </ol>
                </div>
            </div>
        </section><!-- End Breadcrumbs -->

        

        <!-- ======= Post form ======= -->
        <section class="inner-page">
            <div class="container">
                <form id="submitPostForm" action="php/post_handler.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <input type="text" class="form-control" id="short_description" name="short_description" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo '<input type="text" class="form-control" id="author" name="author" value="' . $username . '" readonly>';
                        } else {
                            echo '<input type="text" class="form-control" id="author" name="author" required>';
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <?php
                            $category_query = "SELECT * FROM categories_posts";
                            $category_result = mysqli_query($conn, $category_query);
                            while ($category = mysqli_fetch_assoc($category_result)) {
                                echo '<option value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea id="content" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="post_file" class="form-label">Upload Image (Max. 3MB)</label>
                        <input class="form-control" type="file" id="post_file" name="post_file" accept="image/*" placeholder="Maximum file is 3mb">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div id="alert-container" class="container mt-4"></div>
            </div>


            </form>
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

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script>
         document.getElementById('submitPostForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const fileInput = document.getElementById('post_file');
            const file = fileInput.files[0];

            if (file && file.size > 3 * 1024 * 1024) { // 3MB in bytes
                displayAlert('danger', 'File size exceeds 3MB. Please upload a smaller file.');
                return;
            }

            if (validateForm(formData)) {
                fetch('php/post_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success === 'true') {
                        displayAlert('success', 'Your post has been successfully added. Please wait for our approval. Make sure that your content is in line with our <a href="policy.php">policy</a>.');
                        form.reset();
                        tinymce.get('content').setContent('');
                    } else {
                        displayAlert('danger', 'Something went wrong. Please try again.');
                    }
                })
                .catch(() => {
                    displayAlert('danger', 'Something went wrong. Please try again.');
                });
            } else {
                displayAlert('danger', 'All fields except for the image must be filled out.');
            }
        });

        function validateForm(formData) {
            for (const [key, value] of formData.entries()) {
                if (key !== 'post_file' && !value.trim()) {
                    return false;
                }
            }
            return true;
        }

        function displayAlert(type, message) {
            const alertContainer = document.getElementById('alert-container');
            alertContainer.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 7000);
        }
    </script>

</body>

</html>