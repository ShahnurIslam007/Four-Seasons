<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$folder_id = $_POST['folder_id'];
$category = $_POST['category'];
$amount = $_POST['amount'];
$expense_date = $_POST['expense_date'];

// Insert expense
$stmt = $conn->prepare("INSERT INTO expenses (folder_id, category, amount, expense_date) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isds", $folder_id, $category, $amount, $expense_date);

if ($stmt->execute()) {
    header("Location: ../../folder_expenses.php?id=$folder_id&success=expense_added");
} else {
    header("Location: ../../folder_expenses.php?id=$folder_id&error=expense_failed");
}

$stmt->close();
$conn->close();
?>
