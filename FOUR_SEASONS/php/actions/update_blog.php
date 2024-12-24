<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$blog_id = $_POST['blog_id'];
$title = $_POST['title'];
$content = $_POST['content'];

// Handle Image Upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $file_name = time() . '_' . basename($_FILES['image']['name']);
    $image_path = $upload_dir . $file_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    $image_path = 'uploads/' . $file_name; // Save relative path
}

// Update Blog
if ($image_path) {
    // Update title, content, and image
    $stmt = $conn->prepare("UPDATE blogs SET title = ?, content = ?, image_path = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssii", $title, $content, $image_path, $blog_id, $user_id);
} else {
    // Update title and content only
    $stmt = $conn->prepare("UPDATE blogs SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $content, $blog_id, $user_id);
}

if ($stmt->execute()) {
    header("Location: ../../blogs.php?success=updated");
} else {
    header("Location: ../../blogs.php?error=update_failed");
}

$stmt->close();
$conn->close();
?>
