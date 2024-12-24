<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/auth/login.php");
    exit;
}

include 'php/connect.php';

$user_id = $_SESSION['user_id'];

// Fetch folders
$stmt = $conn->prepare("SELECT id, name, created_at FROM expense_folders WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$folders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - FOUR SEASONS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="expense-tracker-page">
    <!-- Navbar -->
    <header class="navbar-expense">
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
    <!-- Add Folder Section -->
    <section class="add-folder">
        <h1>Add a New Folder</h1>
        <form action="php/actions/add_folder.php" method="POST" class="folder-form">
            <div class="form-group">
                <label for="folder_name">Folder Name:</label>
                <input type="text" id="folder_name" name="folder_name" placeholder="Enter folder name" required>
            </div>
            <button type="submit" class="btn btn-primary-folder">Add Folder</button>
        </form>
    </section>

    <!-- Folder List -->
    <section class="folder-list">
        <h1>Folders</h1>
        <ul class="folder-items">
            <?php foreach ($folders as $folder): ?>
            <li class="folder-item">
                <a href="folder_expenses.php?id=<?php echo $folder['id']; ?>" class="folder-link">
                    <h2><?php echo htmlspecialchars($folder['name']); ?></h2>
                    <p>Created on: <?php echo htmlspecialchars($folder['created_at']); ?></p>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <footer class="footer-expenses">
        <p>© 2024 FOUR SEASONS. All rights reserved.</p>
    </footer>
</body>
</html>
