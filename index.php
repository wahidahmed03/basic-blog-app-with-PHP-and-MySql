<?php
session_start();
include("./db.php");

$user =false;
if(isset($_SESSION['user_id'])){
    $user = $_SESSION['user_id'];
}

$stmt = $conn->prepare("SELECT * FROM `posts` ORDER BY `id` ASC");
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
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
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Document</title>
</head>
<body>
<div class="w-screen h-[70px] bg-blue-200 flex items-center justify-between px-10">
    <a href="/">Blog App</a>
    <div class="flex gap-2 text-white">
        <?php echo $user ? '<a href="./dashboard.php" class="p-3 bg-blue-400 rounded">Dashbord</a>' : '<a href="./singup.php" class="p-3 bg-blue-400 rounded">Signup</a><a href="./singin.php" class="p-3 bg-blue-400 rounded">Signin</a>'; ?>
    </div>
</div>
<div class="p-10 bg-blue-100">
    

    
<div class="flex gap-2 flex-wrap p-5 item-center ">
    <?php foreach ($blog_data as $Blog): ?>
         <div class="w-[300px] h-[350px] bg-blue-200 p-4">
            <h4><?php echo htmlspecialchars($Blog['title']); ?></h4> 
            <div class="overflow-scroll h-[210px]">
                <p><?php echo htmlspecialchars($Blog['content']); ?></p>
            </div>
            <div class="p-2 flex gap-2">
                <a href="blog.php?id=<?php echo $Blog['id']; ?>"  class="bg-blue-600 border p-1">View</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>




</div>


</body>
</html>