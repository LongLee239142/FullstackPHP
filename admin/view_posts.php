<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop execution of the script
}
include 'php/dbconnect.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT auth_permission, orders_access_permission, resources_access_permission FROM employee WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    // Extract permissions from the row
    $auth_permission = $row['auth_permission'];
    $orders_access_permission = $row['orders_access_permission'];
    $resources_access_permission = $row['resources_access_permission'];

    // Check if user has resources_access_permission
    if (!$resources_access_permission) {
        // Redirect to 404 page if user doesn't have access
        header("Location: 404.php");
        exit(); // Stop execution of the script
    }
} else {
    // Handle error or redirect to login page
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OPM ADMIN Page Index</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* Popup form styles */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
            overflow-y: auto;
            /* Enable scrolling for the popup */
        }

        .popup-content {
            background-color: white;
            margin: 5% auto;
            /* Reduced margin to better fit the content on the screen */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            max-height: 90%;
            /* Limit the height of the popup */
            overflow-y: auto;
            /* Enable scrolling for the content */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="sidebar-brand-text mx-3">OPM Admin </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <?php if ($auth_permission) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
            <?php endif; ?>
            <?php if ($orders_access_permission) : ?>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Orders
                </div>


                <!-- Nav Item - Orders -->
                <li class="nav-item">
                    <a class="nav-link" href="orders.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span></a>
                </li>
            <?php endif; ?>
            <?php if ($resources_access_permission) : ?>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Resources
                </div>


                <!-- Nav Item - Posts -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postsCollapse" aria-expanded="true" aria-controls="postsCollapse">
                        <i class="fas fa-file-alt"></i>
                        <span>Posts</span>
                    </a>
                    <div id="postsCollapse" class="collapse" aria-labelledby="headingPosts" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Posts Options:</h6>
                            <a class="collapse-item" href="view_posts.php">View Posts</a>
                            <a class="collapse-item" href="add_post.php">Add New Post</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Products -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productsCollapse" aria-expanded="true" aria-controls="productsCollapse">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                    <div id="productsCollapse" class="collapse" aria-labelledby="headingProducts" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Products Options:</h6>
                            <a class="collapse-item" href="view_products.php">View Products</a>
                            <a class="collapse-item" href="add_product.php">Add New Product</a>
                            <a class="collapse-item" href="add_category.php">Add New Category</a>

                        </div>
                    </div>
                </li>

            <?php endif; ?>
            <?php if ($auth_permission) : ?>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Accounts
                </div>


                <!-- Nav Item - Users -->
                <li class="nav-item">
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users"></i>
                        <span>Users</span></a>
                </li>

                <!-- Nav Item - Employees -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employeesCollapse" aria-expanded="true" aria-controls="employeesCollapse">
                        <i class="fas fa-user-tie"></i>
                        <span>Employees</span>
                    </a>
                    <div id="employeesCollapse" class="collapse" aria-labelledby="headingEmployees" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Employees Options:</h6>
                            <a class="collapse-item" href="view_employees.php">View Employees</a>
                            <a class="collapse-item" href="add_employee.php">Add New Employee</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Action
            </div>

            <?php if ($auth_permission) : ?>
                <!-- Nav Item - Settings -->
                <li class="nav-item">
                    <a class="nav-link" href="setting.php">
                        <i class="fas fa-cogs"></i>
                        <span>Settings</span></a>
                </li>

                <!-- Nav Item - Profile -->
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">
                        <i class="fas fa-user"></i>
                        <span>Profile</span></a>
                </li>
            <?php endif; ?>

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline mt-3">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Blank Page</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                </div>
                                <div class="col-lg-6">
                                    <select id="categoryFilter" class="form-control">
                                        <option value="">Filter by Category</option>
                                        <?php
                                        // Include database connection
                                        include 'php/dbconnect.php';

                                        // Fetch categories from the database
                                        $sql = "SELECT * FROM categories_posts";
                                        $result = $conn->query($sql);

                                        // Output categories as options
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row["category_id"] . '">' . $row["category_name"] . '</option>';
                                        }

                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <?php
                            // Include database connection
                            include 'php/dbconnect.php';

                            // Pagination variables
                            $results_per_page = 10;
                            $sql = "SELECT COUNT(*) AS total FROM posts";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $total_posts = $row['total'];
                            $total_pages = ceil($total_posts / $results_per_page);

                            // Check if page number is set
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start_index = ($current_page - 1) * $results_per_page;

                            // Fetch posts for the current page
                            $sql = "SELECT p.id, p.title, p.short_description, p.post_detail, p.post_image, p.date, p.approval_state, p.author, c.category_name
                            FROM posts p
                            INNER JOIN categories_posts c ON p.category_id = c.category_id
                            LIMIT $start_index, $results_per_page";
                            $result = $conn->query($sql);

                            // Check if there are any posts
                            if ($result->num_rows > 0) {
                                echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Title</th>';
                                echo '<th>Short Description</th>';
                                echo '<th>Post Detail</th>';
                                echo '<th>Post Image</th>';
                                echo '<th>Date</th>';
                                echo '<th>Category</th>';
                                echo '<th>Approval State</th>';
                                echo '<th>Author</th>';
                                echo '<th>Actions</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';

                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row["title"] . '</td>';
                                    echo '<td>' . $row["short_description"] . '</td>';
                                    echo '<td><a href="#" onclick="showContentPopup(\'/new/eproject/' . $row["post_detail"] . '\')">View</a></td>';
                                    echo '<td><a href="#" onclick="showImagePopup(\'/new/eproject/' . $row["post_image"] . '\')">View</a></td>';
                                    echo '<td>' . $row["date"] . '</td>';
                                    echo '<td>' . $row["category_name"] . '</td>';
                                    echo '<td><button id="approvalBtn_' . $row["id"] . '" class="btn btn-' . ($row["approval_state"] == 1 ? "success" : "danger") . '" onclick="changeApprovalState(' . $row["id"] . ', ' . $row["approval_state"] . ')">' . ($row["approval_state"] == 1 ? "Approved" : "Not Approved") . '</button></td>';
                                    echo '<td>' . $row["author"] . '</td>';
                                    echo '<td>
                                          <a href="editpost.php?id=' . $row["id"] . '" class="btn btn-primary">Edit</a>
                                          <button class="btn btn-danger" onclick="deletePost(' . $row["id"] . ')">Delete</button>
                                          </td>';
                                    echo '</tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';

                                // Display pagination links
                                echo '<div class="text-center">';
                                echo '<ul class="pagination">';
                                for ($page = 1; $page <= $total_pages; $page++) {
                                    echo '<li class="page-item ' . ($page == $current_page ? "active" : "") . '"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
                                }
                                echo '</ul>';
                                echo '</div>';
                            } else {
                                echo "0 results";
                            }

                            $conn->close();
                            ?>
                        </div>

                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; OPM</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="php/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Popup -->
    <div id="imagePopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup('imagePopup')">&times;</span>
            <div id="popupImageContainer">
                <img id="popupImage" src="" alt="Post Image" style="width: 100%; max-width: 600px;">
            </div>
        </div>
    </div>

    <!-- Content Popup -->
    <div id="contentPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup('contentPopup')">&times;</span>
            <div id="popupContentContainer">
                <!-- The content of the post will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Function to filter table rows based on category
        function filterByCategory() {
            var categoryFilter = document.getElementById("categoryFilter").value;
            var tableRows = document.querySelectorAll("#dataTable tbody tr");

            tableRows.forEach(function(row) {
                var categoryCell = row.cells[5].textContent.trim();
                if (categoryFilter === "" || categoryCell === categoryFilter) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Function to search table rows based on input text
        function searchTable() {
            var searchText = document.getElementById("searchInput").value.toLowerCase();
            var tableRows = document.querySelectorAll("#dataTable tbody tr");

            tableRows.forEach(function(row) {
                var titleCell = row.cells[0].textContent.trim().toLowerCase();
                var descriptionCell = row.cells[1].textContent.trim().toLowerCase();
                if (titleCell.includes(searchText) || descriptionCell.includes(searchText)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Call filter and search functions when inputs change
        document.getElementById("categoryFilter").addEventListener("change", filterByCategory);
        document.getElementById("searchInput").addEventListener("input", searchTable);
    </script>

    <script>
        // Function to show the image popup
        function showImagePopup(imagePath) {
            // Set the image source
            document.getElementById('popupImage').src = imagePath;

            // Display the image popup
            document.getElementById('imagePopup').style.display = 'block';
        }

        // Function to show the content popup
        function showContentPopup(contentPath) {
            // Load the content into the container
            fetch(contentPath)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('popupContentContainer').innerHTML = data;
                });

            // Display the content popup
            document.getElementById('contentPopup').style.display = 'block';
        }

        // Function to close the popup
        function closePopup(popupId) {
            document.getElementById(popupId).style.display = 'none';
        }
    </script>


    <script>
        // Function to show the image popup
        function showImagePopup(imagePath) {
            // Set the image source
            document.getElementById('popupImage').src = imagePath;

            // Display the image popup
            document.getElementById('imagePopup').style.display = 'block';
        }

        // Function to show the content popup
        function showContentPopup(contentPath) {
            // Load the content into the container
            fetch(contentPath)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('popupContentContainer').innerHTML = data;
                });

            // Display the content popup
            document.getElementById('contentPopup').style.display = 'block';
        }

        // Function to close the popup
        function closePopup(popupId) {
            document.getElementById(popupId).style.display = 'none';
        }
    </script>


</body>

</html>