<?php
include 'db.php';
session_start();


$post_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("s", $post_id,);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: not_found.php");
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
<body class="flex  flex-col gap-2  h-screen bg-gray-100 p-10">
        <h2 class="text-2xl mb-4"><?php echo htmlspecialchars($post['title']); ?></h2>
        <p name="content" required class="block w-full p-2  border-gray-300 mb-4 rounded"><?php echo htmlspecialchars($post['content']); ?></p>
    </form>
</body>
</html>


