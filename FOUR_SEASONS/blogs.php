<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/auth/login.php");
    exit;
}

include 'php/connect.php';

$user_id = $_SESSION['user_id'];

// Fetch blogs
$stmt = $conn->prepare("SELECT id, title, created_at FROM blogs WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$blogs = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - FOUR SEASONS</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="blogs-page">
    <!-- Navbar -->
    <header class="navbar-blogs">
        <div class="logo">FOUR SEASONS</div>
        
        <nav>
            <a href="home.php">Home</a>
            <a href="blogs.php">Journals</a>
            <a href="expense_tracker.php">Expense Tracker</a>
            <a href="todos.php">Bucket List</a>
            <a href="profile.php">Profile</a>
            <a href="php/auth/logout.php" class="logout-btn">Log Out</a>
        </nav>
    </header>

    <!-- Add Blog Form -->
    <section class="add-blog">
        <h1>Add a New Journal</h1>
        <form action="php/actions/add_blog.php" method="POST" enctype="multipart/form-data" class="blog-form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Enter journal title" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="5" placeholder="Write your journal content here" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Add an Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary-blog">Add Journal</button>
        </form>
    </section>

    <!-- Blog Titles and Dates -->
    <section class="your-blogs">
    <h1>Journals</h1>
    <div class="blog-list">
        <?php foreach ($blogs as $blog): ?>
        <div class="blog-card">
            <a href="blog_details.php?id=<?php echo $blog['id']; ?>" class="blog-card-link">
                <div class="blog-card-header">
                    <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                    <p class="blog-date">Posted on: <?php echo htmlspecialchars($blog['created_at']); ?></p>
                </div>
            </a>
            <div class="blog-card-actions">
                <a href="php/actions/edit_blog.php?id=<?php echo $blog['id']; ?>" class="btn-edit" title="Edit Blog">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="php/actions/delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn-delete" title="Delete Blog">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>


    <footer class="footer-blogs">
        <p>© 2024 FOUR SEASONS. All rights reserved.</p>
    </footer>
</body>
</html>
