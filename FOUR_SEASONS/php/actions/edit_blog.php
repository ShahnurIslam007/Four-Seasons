<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$blog_id = $_GET['id'];

// Fetch blog details
$stmt = $conn->prepare("SELECT title, content, image_path FROM blogs WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $blog_id, $user_id);
$stmt->execute();
$stmt->bind_result($title, $content, $image_path);
$stmt->fetch();
$stmt->close();

if (!$title) {
    header("Location: ../../blogs.php?error=not_found");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - FOUR SEASONS</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="edit-blog-page">
    <section class="edit-blog">
        <h1>Edit Blog</h1>
        <form action="update_blog.php" method="POST" enctype="multipart/form-data" class="blog-edit-form">
            <!-- Hidden Input to Pass Blog ID -->
            <input type="hidden" name="blog_id" value="<?php echo htmlspecialchars($blog_id); ?>">

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="5" required><?php echo htmlspecialchars($content); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Change Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if (!empty($image_path)): ?>
                    <p>Current Image:</p>
                    <img src="../../<?php echo htmlspecialchars($image_path); ?>" alt="Current Blog Image" class="blog-edit-image">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary-blog-edit">Update Blog</button>
        </form>
    </section>
</body>
</html>
