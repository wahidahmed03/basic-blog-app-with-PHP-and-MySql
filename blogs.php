<?php 

include("./db.php");

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($user_id) {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ?");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }
    $stmt->bind_param("s", $user_id);
} else {
    $stmt = $conn->prepare("SELECT * FROM `posts` ORDER BY `user_id` ASC");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch all posts instead of a single one
$blog_data = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class='w-screen h-screen flex items-center flex-col gap-10'>
    
<div class="flex gap-2 flex-wrap p-5 item-center ">
    <?php foreach ($blog_data as $Blog): ?>
         <div class="w-[300px] h-[350px] bg-blue-200 p-4">
            <h4><?php echo htmlspecialchars($Blog['title']); ?></h4> 
            <div class="overflow-scroll h-[210px]">
                <p><?php echo htmlspecialchars($Blog['content']); ?></p>
            </div>
            <div class="p-2 flex gap-2">
                <a href="Edit_blog.php?id=<?php echo $Blog['id']; ?>"  class="bg-blue-600 border p-1">EDIT</a>
                <a href="delete_blog.php?id=<?php echo $Blog['id']; ?>"  class="bg-red-600 border p-1">DELETE</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</div>
</body>
</html>
