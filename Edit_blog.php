<?php
include 'db.php';
session_start();

// if (!isset($_SESSION['user_id'])) {
//     header("Location: signin.php");
//     exit();
// }

// if (!isset($_GET['id'])) {
//     header("Location: dashboard.php");
//     exit();
// }

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $content, $post_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating post: " . $stmt->error;
    }

    $stmt->close();
}

$stmt = $conn->prepare("SELECT title, content FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ss", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: dashboard.php");
    exit();
}

$post = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <form method="POST" class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl mb-4">Edit Post</h2>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required class="block w-full p-2 border border-gray-300 mb-4 rounded">
        <textarea name="content" required class="block w-full p-2 border border-gray-300 mb-4 rounded"><?php echo htmlspecialchars($post['content']); ?></textarea>
        <button type="submit" class="w-full p-2 bg-blue-500 text-white rounded">Update Post</button>
    </form>
</body>
</html>