<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>შემსრულებლის მიღებული სამუშაო</title>
    <link rel="stylesheet" href="../assets/css/performer_recivced_job.css">
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
$id = $_SESSION['user_id'];

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


<table id="client_task">
  <tr>
    <th>დამკვეთის სახელი / გვარი</th>
    <th>დამკვეთის Email</th>
    <th>ვინ მოითხოვება</th>
    <th>კლიენტის ბიუჯეტი</th>
    <th>შემსრულებელმა რამდენ დღეში დაასრულოს</th>
    <th>გამოქვეყნების თარიღი</th>
    <th>მოქმედება</th>
  </tr>
    <?php

    $select = "SELECT * FROM `chat_config` WHERE performer_id='$id'";
    $result = mysqli_query($conn, $select);
    date_default_timezone_set('Asia/Tbilisi');
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['client_first_name']." ".$row['client_last_name']. "</td>";
            echo "<td>" . $row['client_email'] . "</td>";
            echo "<td>" . $row['professions'] . "</td>";
            echo "<td>" . $row['client_budget']." ლარი ".$row['client_budget_type']."</td>";
            echo "<td>" . $row['days'] . "-დღეში</td>";
            echo "<td>" . $row['publish_time'] . "</td>";
            echo "<td><a href='performer_chat.php?performer_first_name=".$row['performer_first_name']."&&performer_last_name=".$row['performer_last_name']."&&client_id=".$row['client_id']."&&performer_id=".$row['performer_id']."'>კომუნიკაცია კლიენტთან</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<tr><td>არ მოიძებნა შედეგი.<td><tr>";
    }
    ?>
</table>

</body>
</html>
