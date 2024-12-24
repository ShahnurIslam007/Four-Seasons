<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/auth/login.php");
    exit;
}

include 'php/connect.php';

$user_id = $_SESSION['user_id'];

// Fetch todos
$stmt = $conn->prepare("SELECT id, task, status FROM todos WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$todos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - FOUR SEASONS</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="todos-page">
    <!-- Navbar -->
    <header class="navbar-todos">
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

    <!-- Add To-Do Form -->
    <section class="add-todo">
        <h1>Add a New Task</h1>
        <form action="php/actions/add_todo.php" method="POST" class="todo-form">
            <div class="form-group">
                <label for="task">Task:</label>
                <input type="text" id="task" name="task" placeholder="Enter a task" required>
            </div>
            <button type="submit" class="btn btn-primary-todo">Add Task</button>
        </form>
    </section>

    <!-- To-Do List -->
    <section class="view-todos">
        <h1>Bucket Lists</h1>
        <ul class="todo-list">
            <?php foreach ($todos as $todo): ?>
            <li class="todo-item <?php echo $todo['status']; ?>">
                <span><?php echo htmlspecialchars($todo['task']); ?></span>
                <div class="todo-actions">
                    <?php if ($todo['status'] == 'incomplete'): ?>
                        <a href="php/actions/mark_todo.php?id=<?php echo $todo['id']; ?>&status=completed" 
                        class="btn btn-complete" title="Mark as Completed">
                        <i class="fas fa-check-circle"></i>
                    </a>
                    <a href="php/actions/mark_todo.php?id=<?php echo $todo['id']; ?>&status=not_completed" 
                    class="btn btn-not-complete" title="Mark as Not Completed">
                    <i class="fas fa-times-circle"></i>
                </a>
                <?php endif; ?>
                <a href="php/actions/delete_todo.php?id=<?php echo $todo['id']; ?>" 
                class="btn btn-danger-todo" title="Delete">
                <i class="fas fa-trash"></i>
            </a>
        </div>

            </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <footer class="footer-todos">
        <p>© 2024 FOUR SEASONS. All rights reserved.</p>
    </footer>
</body>
</html>
