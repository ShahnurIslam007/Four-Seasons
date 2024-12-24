<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$content = $_POST['content'];
$image_path = null;

// Handle image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../../uploads/'; // Ensure this directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
    }
    $file_name = time() . '_' . basename($_FILES['image']['name']); // Unique file name
    $image_path = $upload_dir . $file_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    $image_path = 'uploads/' . $file_name; // Relative path for displaying
}


// Insert blog
$stmt = $conn->prepare("INSERT INTO blogs (user_id, title, content, image_path) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $title, $content, $image_path);

if ($stmt->execute()) {
    header("Location: ../../blogs.php?success=1");
} else {
    header("Location: ../../blogs.php?error=1");
}

$stmt->close();
$conn->close();
?>
