<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/auth/login.php"); // Redirect to login if not logged in
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - FOUR SEASONS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="home-page">
    <!-- Navbar -->
    <header class="navbar-home">
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

    <!-- Hero Section -->
    <section class="hero-home">
        <div class="hero-home-content">
            <h1>Welcome to FOUR SEASONS</h1>
            <p>Capture Every Moment, Plan Every Step, Relive Every Journey.            </p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-home">
        <div class="feature-home">
            <h2>Travel Blogs</h2>
            <p>Document your travel experiences and share your stories with the world.</p>
            <a href="blogs.php" class="btn btn-primary-home">View Blogs</a>
        </div>
        <div class="feature-home">
            <h2>Expense Tracker</h2>
            <p>Track your spending and budget to make the most of your travels.</p>
            <a href="expense.php" class="btn btn-primary-home">Manage Expenses</a>
        </div>
        <div class="feature-home">
            <h2>Bucket List</h2>
            <p>Plan your itinerary and organize tasks for a seamless journey.</p>
            <a href="todos.php" class="btn btn-primary-home">Create Bucket List</a>
        </div>
    </section>

    <footer class="footer-home">
        <p>© 2024 FOUR SEASONS. All rights reserved.</p>
    </footer>
</body>
</html>
