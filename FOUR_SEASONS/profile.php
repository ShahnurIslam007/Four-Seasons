<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/auth/login.php"); // Redirect to login if not logged in
    exit;
}

// Include database connection
include 'php/connect.php';

// Fetch user information
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - FOUR SEASONS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="profile-page">
    <!-- Navbar -->
    <header class="navbar-profile">
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

    <!-- Profile Section -->
    <section class="profile-section">
        <div class="profile-container">
            <h1>Profile</h1>

            <?php if (isset($_GET['success'])): ?>
                <p class="success-message">Profile updated successfully!</p>
                <?php elseif (isset($_GET['error'])): ?>
                    <p class="error-message">Error updating profile. Please try again.</p>
                    <?php endif; ?>


            <form action="php/auth/update_profile.php" method="POST" class="profile-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
                </div>
                <button type="submit" class="btn btn-primary-profile">Update Profile</button>
            </form>
        </div>
    </section>

    <footer class="footer-profile">
        <p>© 2024 FOUR SEASONS. All rights reserved.</p>
    </footer>
</body>
</html>
