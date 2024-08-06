<?php
include 'dbconnect.php';
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $shortDescription = $_POST['short_description'];
    $categoryId = $_POST['category'];
    $author = $_POST['author'];
    $postDetail = $_POST['content'];
    $date = date("Y-m-d", time() + 7 * 3600); // Adjust for GMT+7
    $approvalState = 1;

    // Handle file upload
    $postImagePath = 'assets/img/post/post-default.jpg';
    if (!empty($_FILES['post_file']['name'])) {
        $postImage = $_FILES['post_file'];
        $postImageName = 'post-' . time() . '.' . pathinfo($postImage['name'], PATHINFO_EXTENSION);
        $postImagePath = 'assets/img/post/' . $postImageName;
        move_uploaded_file($postImage['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/new/eproject/' . $postImagePath);
    }

    // Insert post into the database
    $stmt = $conn->prepare("INSERT INTO posts (title, short_description, category_id, author, post_detail, post_image, date, approval_state) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssi", $title, $shortDescription, $categoryId, $author, $postDetail, $postImagePath, $date, $approvalState);

    if ($stmt->execute()) {
        $postId = $stmt->insert_id;
        $postDetailPath = "assets/content/post/post-$postId.html";
        $stmt->prepare("UPDATE posts SET post_detail = ? WHERE id = ?");
        $stmt->bind_param("si", $postDetailPath, $postId);
        $stmt->execute();

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

        echo json_encode(['success' => 'true']);
    } else {
        echo json_encode(['success' => 'false']);
    }
}