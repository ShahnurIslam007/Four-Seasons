<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/auth/login.php");
    exit;
}

include 'php/connect.php';

$user_id = $_SESSION['user_id'];
$blog_id = $_GET['id'];

// Fetch the blog details
$stmt = $conn->prepare("SELECT title, content, image_path, created_at FROM blogs WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $blog_id, $user_id);
$stmt->execute();
$stmt->bind_result($title, $content, $image_path, $created_at);
$stmt->fetch();
$stmt->close();

if (!$title) {
    header("Location: blogs.php?error=not_found");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Blog Details</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="blog-details-page">
    <!-- Navbar -->
    <header class="navbar-blogs">
        <div class="logo">FOUR SEASONS</div>
        <nav>
            <a href="blogs.php">Back to Blogs</a>
        </nav>
    </header>

    <!-- Blog Details -->
    <section class="blog-details">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <p class="blog-date">Posted on: <?php echo htmlspecialchars($created_at); ?></p>
        <?php if (!empty($image_path)): ?>
            <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Blog Image" class="blog-image">
        <?php endif; ?>
        <p class="blog-content"><?php echo nl2br(htmlspecialchars($content)); ?></p>
    </section>

    <footer class="footer-blogs">
        <p>© 2024 FOUR SEASONS. All rights reserved.</p>
    </footer>
</body>
</html>
