<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$folder_name = $_POST['folder_name'];

// Insert folder
$stmt = $conn->prepare("INSERT INTO expense_folders (user_id, name) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $folder_name);

if ($stmt->execute()) {
    header("Location: ../../expense_tracker.php?success=folder_added");
} else {
    header("Location: ../../expense_tracker.php?error=folder_failed");
}

$stmt->close();
$conn->close();
?>
