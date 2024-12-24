<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$task = $_POST['task'];

// Insert todo
$stmt = $conn->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $task);

if ($stmt->execute()) {
    header("Location: ../../todos.php?success=added");
} else {
    header("Location: ../../todos.php?error=add_failed");
}

$stmt->close();
$conn->close();
?>
