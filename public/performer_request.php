<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>შემსურლებლისგან მოთხოვნა სამუშაოზე</title>
    <link rel="stylesheet" href="../assets/css/performer_request.css">
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

$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];


if(isset($_GET['logout'])){

    $update = "UPDATE `users` SET `online`='0' WHERE id='{$_SESSION['user_id']}'";
    mysqli_query($conn, $update);

    session_destroy();
    unset($_SESSION['user_id']);
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}


if(isset($_POST['accept_request'])){
    $performer_id = $_POST['performer_id'];
    $professions = $_POST['professions'];
    $update = "UPDATE `user_jobrequests` SET accepted='1' WHERE user_id='$performer_id' and professions='$professions'";
    if(mysqli_query($conn,$update)){
        $query = "SELECT * FROM `user_jobrequests` WHERE user_id='$performer_id' and professions='$professions'";  
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $client_id = $row['client_id'];
        $performer_id = $row['user_id'];
        $performer_first_name = $row['first_name'];
        $performer_last_name = $row['last_name'];
        $performer_email = $row['email'];
        $client_first_name = $row['client_first_name'];
        $client_last_name = $row['client_last_name'];
        $client_email = $row['client_email'];
        $professions = $row['professions'];
        $days = $row['days'];
        $client_job_descriptions = $row['client_job_description'];
        $publish_time = $row['publish_time'];
        $client_budget = $row['client_budget'];
        $client_budget_type = $row['budget_type'];
        $image = $row['image'];

        $select = "SELECT * FROM `chat_config` WHERE performer_id='$performer_id' and professions='$professions'";
        $result = mysqli_query($conn,$select);
        if(!mysqli_num_rows($result)){
            $insert = "INSERT INTO `chat_config` (`image`,`client_first_name`,`client_last_name`,`client_id`,`performer_first_name`,`performer_last_name`,`performer_email`,`performer_id`,`professions`,`days`,`client_email`,`client_job_descriptions`,`publish_time`,`client_budget`,`client_budget_type`) VALUES ('$image','$client_first_name','$client_last_name','$client_id','$performer_first_name','$performer_last_name','$performer_email','$performer_id','$professions','$days','$client_email','$client_job_descriptions','$publish_time','$client_budget','$client_budget_type')";
            if(mysqli_query($conn,$insert)){
                $success = "თქვენ დაეთანხმეთ შემსრულებელს თქვენს მიერ გამოცხადებული სამუშაოს შესრულებაზე";
            }
        }else{
            array_push($error,"თქვენ უკვე დათანხმებული ხართ შემსრულებელზე ამ სამუშაოზე");
        }

    }
}

if(isset($_POST['cancel_request'])){
    $performer_id = $_POST['performer_id'];
    $professions = $_POST['professions'];
    $update = "UPDATE `user_jobrequests` SET accepted='0' WHERE user_id='$performer_id' and professions='$professions'";
    if(mysqli_query($conn,$update)){
        $delete = "DELETE FROM `chat_config` WHERE client_id='$user_id' and professions='$professions'";
        if(mysqli_query($conn,$delete)){
            $success = "თქვენ გააუქმეთ შემსრულებელს თქვენს მიერ გამოცხადებულ სამუშაოზე მუშაობის უფლება";
        }
    }
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
<div class="success">
<?php echo $success;?>
</div>
<div class="error">
<?php foreach ($error as $err){
    echo $err;
} ?>
</div>
<table id="client_task">
  <tr>
    <th>ფოტო</th>
    <th>შემსრულებლის სახელი / გვარი</th>
    <th>თქვენგან ვინ მოითხოვება</th>
    <th>შემსრულებლის Email</th>
    <th>გენდერი</th>
    <th>საცხოვრებელი ქალაქი</th>
    <th>ექაუნთის შექმნის თარიღი</th>
    <th>აღწერა</th>
    <th>მოთხოვნა სამსახურზე</th>
    <th>ნებართბა</th>
    <th>მოქმედებები</th>
  </tr>
    <?php

    $query = "SELECT * FROM `user_jobrequests` WHERE client_id='$user_id'";  
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
           if($row['accepted'] == 1){
            echo "<tr>";
            echo "<td><img class='performer_img' src='../assets/images/{$row['image']}'></td>";
            echo "<td>" . $row['first_name']." ".$row['last_name']."</td>";
            echo "<td>" . $row['professions']."</td>";
            echo "<td>" . $row['email']."</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['city']."</td>";
            echo "<td>" . $row['user_created_at'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['request_created_at'] . "</td>";
            echo "<td>" . "თქვენ უფლება მიეცით ამ სამუშაოს შესრულებაზე" . "</td>";
            echo "<td>
            <form method='post' action='performer_request.php'>
            <input type='hidden' value='".$row['user_id']."' name='performer_id'>
            <input type='hidden' value='".$row['professions']."' name='professions'>
            <button class='accept_request' name='accept_request' title='დათანხმება'><i class='fa-duotone fa-solid fa-check'></i></button>
            <button class='cancel_request' name='cancel_request' title='გაუქმება'><i class='fa-solid fa-xmark'></i></button>
            </form>
            </td>";
            echo "</tr>";
           }else{
            echo "<tr>";
            echo "<td><img class='performer_img' src='../assets/images/{$row['image']}'></td>";
            echo "<td>" . $row['first_name']." ".$row['last_name']."</td>";
            echo "<td>" . $row['professions']."</td>";
            echo "<td>" . $row['email']."</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['city']."</td>";
            echo "<td>" . $row['user_created_at'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['request_created_at'] . "</td>";
            echo "<td>" . "თქვენ ჯერ არ მიგიციათ უფლება სამუშაოს შესრულებაზე" . "</td>";
            echo "<td>
            <form method='post' action='performer_request.php'>
            <input type='hidden' value='".$row['user_id']."' name='performer_id'>
            <input type='hidden' value='".$row['professions']."' name='professions'>
            <button class='accept_request' name='accept_request' title='დათანხმება'><i class='fa-duotone fa-solid fa-check'></i></button>
            <button class='cancel_request' name='cancel_request' title='გაუქმება'><i class='fa-solid fa-xmark'></i></button>
            </form>
            </td>";
            echo "</tr>";
           }
        }
        echo "</table>";
    } else {
        echo "<tr><td>არ მოიძებნა შედეგი.<td><tr>";
    }
    ?>
</table>


</body>
</html>
