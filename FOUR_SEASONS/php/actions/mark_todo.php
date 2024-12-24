<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$todo_id = $_GET['id'];
$status = $_GET['status'];

// Update todo status
$stmt = $conn->prepare("UPDATE todos SET status = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("sii", $status, $todo_id, $user_id);

if ($stmt->execute()) {
    header("Location: ../../todos.php?success=updated");
} else {
    header("Location: ../../todos.php?error=update_failed");
}

$stmt->close();
$conn->close();
?>
