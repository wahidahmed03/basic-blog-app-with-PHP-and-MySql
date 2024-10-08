<?php 
include("./db.php");
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}
$stmt->bind_param("s", $user_id);
$stmt->execute();
$user = $stmt->get_result();

$user_data = $user->fetch_assoc(); 
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
    <div class='w-screen h-screen flex items-center flex-col gap-10 '>
        <div class="w-[300px] h-[200px] bg-blue-200 shadow-lg py-4 px-4">
            <h1>YOUR NAME: <?php echo $user_data['username'] ?></h1>
            <p>YOUR MAIL:<?php echo $user_data['email'] ?></p>
            <div class="pt-24 flex gap-2" >
                <a href="./write_blog.php" class="bg-blue-600 border p-1">ADD BLOG</a>
                <a href="/" class="bg-blue-600 border p-1">Home</a>

            </div>
        </div>
        <?php 
        include("./blogs.php")
        ?>
    </div>
</body>
</html>
