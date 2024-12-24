<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/auth/login.php");
    exit;
}

include 'php/connect.php';

$user_id = $_SESSION['user_id'];
$folder_id = $_GET['id'];

// Fetch folder details
$stmt = $conn->prepare("SELECT name FROM expense_folders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $folder_id, $user_id);
$stmt->execute();
$stmt->bind_result($folder_name);
$stmt->fetch();
$stmt->close();

if (!$folder_name) {
    header("Location: expense_tracker.php?error=folder_not_found");
    exit;
}

// Fetch expenses for the folder
$stmt = $conn->prepare("SELECT id, category, amount, expense_date FROM expenses WHERE folder_id = ?");
$stmt->bind_param("i", $folder_id);
$stmt->execute();
$result = $stmt->get_result();
$expenses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($folder_name); ?> - Expenses</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="folder-expenses-page">
    <!-- Navbar -->
    <header class="navbar-expense">
        <div class="logo">FOUR SEASONS</div>
        <nav>
            <a href="expense_tracker.php">Back to Expenses</a>
        </nav>
    </header>



    <!-- Add Expense Form -->
    <section class="add-expense">
        <h2>Add a New Expense</h2>
        <form action="php/actions/add_expense.php" method="POST" class="expense-form">
            <input type="hidden" name="folder_id" value="<?php echo $folder_id; ?>">
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" placeholder="Enter category" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" step="0.01" placeholder="Enter amount" required>
            </div>
            <div class="form-group">
                <label for="expense_date">Date:</label>
                <input type="date" id="expense_date" name="expense_date" required>
            </div>
            <button type="submit" class="btn btn-primary-expense">Add Expense</button>
        </form>
    </section>

    <!-- Expense List -->
    <section class="view-expenses">
        <h2>Expenses</h2>
        <table class="expense-table">
    <thead>
        <tr>
            <th>Category</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($expenses as $expense): ?>
    <tr>
        <td><?php echo htmlspecialchars($expense['category']); ?></td>
        <td><?php echo htmlspecialchars($expense['amount']); ?></td>
        <td><?php echo htmlspecialchars($expense['expense_date']); ?></td>
        
    </tr>
    <?php endforeach; ?>
</tbody>

</table>

    </section>



    



    <footer class="footer-expenses">
        <p>© 2024 FOUR SEASONS. All rights reserved.</p>
    </footer>
</body>
</html>
