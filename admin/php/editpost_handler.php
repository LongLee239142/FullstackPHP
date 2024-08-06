<?php
include 'dbconnect.php';
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postId = $_POST['post_id'];
    $title = $_POST['title'];
    $shortDescription = $_POST['short_description'];
    $categoryId = $_POST['category'];
    $postDetail = $_POST['content'];
    $date = $_POST['date'];
    $approvalState = 1;

    // Handle file upload if a new image is provided
    $postImagePath = $_POST['post_image_path'];
    if (!empty($_FILES['post_file']['name'])) {
        $postImage = $_FILES['post_file'];
        $postImageName = 'post-' . time() . '.' . pathinfo($postImage['name'], PATHINFO_EXTENSION);
        $postImagePath = 'assets/img/post/' . $postImageName;
        move_uploaded_file($postImage['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/new/eproject/' . $postImagePath);
    }

    // Update post in the database
    $stmt = $conn->prepare("UPDATE posts SET title = ?, short_description = ?, category_id = ?, post_detail = ?, post_image = ?, approval_state = ? WHERE id = ?");
    $stmt->bind_param("ssisssi", $title, $shortDescription, $categoryId, $postDetail, $postImagePath, $approvalState, $postId);

    if ($stmt->execute()) {
        // Update post detail file if needed
        $postDetailPath = "assets/content/post/post-$postId.html";
        $postDetailFilePath = $_SERVER['DOCUMENT_ROOT'] . "/new/eproject/$postDetailPath";
        $postDetailTemplate = "
        <article class='mb-4'>
            <div class='container px-4 px-lg-5'>
                <div class='row gx-4 gx-lg-5 justify-content-center'>
                    <div class='col-md-10 col-lg-8 col-xl-7'>
                        $postDetail
                    </div>
                </div>
            </div>
        </article>";
        file_put_contents($postDetailFilePath, $postDetailTemplate);

        // Display success message and refresh the form
        echo json_encode(['success' => true, 'message' => 'Post updated successfully']);
    } else {
        // Display error message
        echo json_encode(['success' => false, 'message' => 'Failed to update post. Please try again.']);
    }
}
?>