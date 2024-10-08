<?php
include("./db.php");
session_start();
$Error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usermail = $_POST['email'];
    $userpassword = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $usermail);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($userpassword, $password)) {
            $_SESSION["user_id"] = $id;
            setcookie("user_mail", $usermail, time() + (86400 * 30), "/");
            $_SESSION['mailId'] = $usermail;
            header("Location: dashboard.php");
            exit();
        } else {
            $Error = "Invalid password.";
        }
    } else {
        $Error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./indec.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
<div class='w-[98.90vw] h-screen bg-gray-200 dark:bg-gray-900 text-black dark:text-white flex pt-28 justify-center'>
    <div class="w-[500px] h-[410px] dark:bg-gray-800/40 bg-gray-100/50 rounded shadow-2xl dark:shadow-lg p-5">
        <h5 class='text-center font-semibold'>SIGN IN</h5>
        <form action="singin.php" method="post">
            <div class="flex flex-col gap-2 pt-4">
                <div class="flex items-center w-full h-[43px] px-3 gap-2 border-[3px] border-gray-300 hover:border-blue-600 dark:border-gray-300/50 transition-all duration-300 dark:bg-gray-800/40">
                    <input type="email" name="email" placeholder='Type your email...' class='w-full h-[38px] px-1 outline-none bg-gray-100 dark:bg-gray-800/40' required />
                </div>
                
                <div class="flex items-center w-full h-[43px] px-3 gap-2 border-[3px] border-gray-300 hover:border-blue-600 dark:border-gray-300/50 transition-all duration-300 dark:bg-gray-800/40">
                    <input type="password" name="password" placeholder='Type your password...' class='w-full h-[38px] px-1 outline-none bg-gray-100 dark:bg-gray-800/40' required />
                </div>

                <div class="flex items-center justify-center w-full h-[43px] px-3 gap-2 border-[3px] border-gray-300 hover:border-blue-600 hover:bg-blue-600/50 dark:hover:bg-blue-600/50 cursor-pointer dark:border-gray-300/50 transition-all duration-300 dark:bg-gray-800/40">
                    <input type="submit" name='Submit' class='h-[38px] px-1 outline-none' />
                </div>
                <p>Or</p>

                <div class="flex items-center justify-center w-full h-[43px] px-3 gap-2 border-[3px] border-gray-300 hover:border-blue-600 hover:bg-blue-600/50 dark:hover:bg-blue-600/50 cursor-pointer dark:border-gray-300/50 transition-all duration-300 dark:bg-gray-800/40">
                    <a href='/'>Create Your Account</a>
                </div>
                <?php echo htmlspecialchars($Error); ?>
            </div>
        </form>
    </div>
</div>
</body>
</html>
