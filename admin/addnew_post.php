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
$sql = "SELECT  name, auth_permission, orders_access_permission, resources_access_permission FROM employee WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    // Extract permissions from the row
    $auth_permission = $row['auth_permission'];
    $orders_access_permission = $row['orders_access_permission'];
    $resources_access_permission = $row['resources_access_permission'];
    $name = $row['name'];

    // Check if user has resources_access_permission
    if (!$resources_access_permission) {
        // Redirect to 404 page if user doesn't have access
        header("Location: 404.php");
        exit(); // Stop execution of the script
    }
} else {
    // Handle error or redirect to login page
}

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

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/ta3a3nnxbrpfktvlpyz7pvwedc7wath13vpqg31gypmgg2sb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#texteditor',
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | link image | removeformat | help',
            setup: function(editor) {
                editor.on('init', function() {
                    editor.getBody().classList.add('bootstrap-content');
                });
            }
        });
    </script>

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
                            <a class="collapse-item" href="addnew_post.php">Add New Post</a>
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

                    <h1>Add new post</h1>

                    <form id="submitPostForm" action="php/addpost_handler.php" method="post" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" id="author" name="author" value="<?php echo $name; ?>" readonly>
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
                            <label for="texteditor" class="form-label">Content</label>
                            <textarea id="texteditor" name="content"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="post_file" class="form-label">Upload Image (Max. 3MB)</label>
                            <input class="form-control" type="file" id="post_file" name="post_file" accept="image/*" placeholder="Maximum file is 3mb">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <div id="alert-container" class="container mt-4"></div>
                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        document.getElementById('submitPostForm').addEventListener('submit', function(e) {
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
                fetch('php/addpost_handler.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success === 'true') {
                            displayAlert('success', 'Your post has been successfully added.</a>.');
                            form.reset();
                            tinymce.get('texteditor').setContent('');
                        } else {
                            displayAlert('danger', 'Something went wrong. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error during fetch operation:', error);
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