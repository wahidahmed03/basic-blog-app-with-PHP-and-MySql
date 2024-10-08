<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Validate and sanitize user inputs
    $title = htmlspecialchars($title);
    $content = htmlspecialchars($content);

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $content);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error publishing post: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow-md">
        <h2 class="text-3xl mb-6">Write a New Blog Post</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Title" required class="block w-full p-2 border border-gray-300 mb-4 rounded">
            <textarea name="content" placeholder="Content" required class="block w-full p-2 border border-gray-300 mb-4 h-[100px] rounded"></textarea>
            <button type="submit" class="w-full p-2 bg-green-500 text-white rounded">Publish</button>
        </form>
        <a href="dashboard.php" class="block mt-4 text-blue-500">Back to Dashboard</a>
    </div>
</body>
</html>
