<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>შემსრულებლის მთავარი გვერდი</title>
    <link rel="stylesheet" href="../assets/css/header.css">
</head>
<body>
<?php

include_once("../includes/db_conn.php");
session_start();


if($_SESSION['user_id'] == ""){
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}

$email = $_SESSION['email'];

if(isset($_GET['logout'])){

    $update = "UPDATE `users` SET `online`='0' WHERE id='{$_SESSION['user_id']}'";
    mysqli_query($conn, $update);

    session_destroy();
    unset($_SESSION['user_id']);
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}

?>
<header>
    <nav>
        <ul>
            <li><a href="performer_login.php">მთავარი გვერდი</a></li>
            <li><a href="performer_searchtask.php">შეკვეთის ძიება</a></li>
            <li><a href="performer_recivced_job.php">მიღებული შეკვეთები</a></li>
            <li><a href="performer_profil.php">პროფილის შესწორება</a></li>
            <li><a href="performer_login.php?logout=1">გამოსვლა</a></li>
        </ul>
    </nav>
</header>


</body>
</html>
