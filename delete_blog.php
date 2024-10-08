<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: signin.php");
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);

if ($stmt->execute()) {
    header("Location: dashboard.php");
} else {
    echo "Error deleting post: " . $stmt->error;
}

$stmt->close();
?>
