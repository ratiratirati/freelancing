<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>დამკვეთის დამატებული შეკვეთები</title>
    <link rel="stylesheet" href="../assets/css/client_added_list.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php

include_once("../includes/db_conn.php");

session_start();

$success = "";
$error = [];

if($_SESSION['user_id'] == ""){
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}


$user_id = $_SESSION['user_id'];



if(isset($_GET['logout'])){

    $update = "UPDATE `users` SET `online`='0' WHERE id='{$_SESSION['user_id']}'";
    mysqli_query($conn, $update);

    session_destroy();
    unset($_SESSION['user_id']);
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}

if(isset($_POST['delete_post'])){
    $id = $_POST['delete_id'];
    $delete = "DELETE FROM `client_task` WHERE id='$id'";
    mysqli_query($conn,$delete);
}

if(isset($_POST['edit_post'])){
    $id = $_POST['delete_id'];
    header("location: client_task_edit.php?id=$id");
}


?>

<header>
    <nav>
        <ul>
            <li><a href="client_login.php">მთავარი გვერდი</a></li>
            <li><a href="client_task_add.php">შეკვეთის დამატება</a></li>
            <li><a href="client_added_list.php">დამატებული შეკვეთები</a></li>
            <li><a href="performer_request.php">შემსურლებლისგან მოთხოვნა სამუშაოზე</a></li>
            <li><a href="performer_workingjob.php">შეკვეთაზე მუშაობს</a></li>
            <li><a href="client_profil.php">დასრულებული შეკვეთა</a></li>
            <li><a href="client_profil.php">პროფილის შესწორება</a></li>
            <li><a href="client_login.php?logout=1">გამოსვლა</a></li>
        </ul>
    </nav>
</header>

<table id="client_task">
  <tr>
    <th>ვინ მოითხოვება</th>
    <th>კლიენტის ბიუჯეტი</th>
    <th>შემსრულებელმა რამდენ დღეში დაასრულოს</th>
    <th>დამკვეთის სახელი / გვარი</th>
    <th>დამკვეთის Email</th>
    <th>დავალების აღწერა</th>
    <th>გამოქვეყნების თარიღი</th>
    <th>მოქმედება</th>
  </tr>
    <?php
    $query = "SELECT * FROM `client_task` WHERE user_id='$user_id'";  
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['professions'] . "</td>";
            echo "<td>" . $row['budget']." ლარი ".$row['budget_type']."</td>";
            echo "<td>" . $row['days'] . "-დღეში</td>";
            echo "<td>" . $row['first_name']." ".$row['last_name']. "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['job_description'] . "</td>";
            echo "<td>" . $row['publish_time'] . "</td>";
            echo "<td>
                <form method='post' action='client_added_list.php'>
                <input type='hidden' value='".$row['id']."' name='delete_id'>
                <button class='delete_post' name='delete_post'><i class='fa-sharp fa-solid fa-trash'></i></button>
                </form>
            </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<tr><td>არ არის თქვენს მიერ დამატებული შეკვეთები.<td><tr>";
    }
    ?>
</table>

</body>
</html>
