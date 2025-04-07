<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>დეტალურად ნახვა</title>
    <link rel="stylesheet" href="../assets/css/performer_detailjob.css">
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
$client_id = $_GET['user_id'];
$professions = $_GET['professions'];
$days = $_GET['days'];
$job_description = $_GET['job_description'];
$publish_time = $_GET['publish_time'];
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$em = $_GET['email'];
$budget = $_GET['budget'];
$budget_type = $_GET['budget_type'];

$order_id = $_GET['order_id'];

if(isset($_GET['logout'])){

    $update = "UPDATE `users` SET `online`='0' WHERE id='{$_SESSION['user_id']}'";
    mysqli_query($conn, $update);

    session_destroy();
    unset($_SESSION['user_id']);
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}


$success = '';
$error = [];

if(isset($_POST['request_job'])){

    $select = "SELECT * FROM `users` WHERE id='$id'";
    $result = mysqli_query($conn,$select);
    $row = mysqli_fetch_assoc($result);
    if($row['description'] != "'თქვენ ჯერ არ გაქვთ თქვენი პროფილი აღწერილი'"){
        $select = "SELECT * FROM `user_jobrequests` WHERE user_id='$id' and professions='$professions'";
        $result = mysqli_query($conn,$select);
        if(!mysqli_num_rows($result)){
            $select = "SELECT * FROM `users` WHERE id='$id'";
            $result = mysqli_query($conn,$select);
        
            $row = mysqli_fetch_assoc($result);
        
            $user_id = $id;
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $email = $row['email'];
            $gender = $row['gender'];
            $city = $row['city'];
            $user_type = $row['user_type'];
            $user_created_at = $row['created_at'];
            $description = $row['description'];
            $image = $row['image'];
            
            $client_id = $_GET['user_id'];
            $professions = $_GET['professions'];
            $days = $_GET['days'];
            $job_description = $_GET['job_description'];
            $publish_time = $_GET['publish_time'];
            $user_first_name = $_GET['first_name'];
            $user_last_name = $_GET['last_name'];
            $em = $_GET['email'];
            $budget = $_GET['budget'];
            $budget_type = $_GET['budget_type'];
            
            
        
            date_default_timezone_set('Asia/Tbilisi');
            $date  = date('d-m-Y h:i');
        
            $insert = "INSERT INTO `user_jobrequests` (`client_id`,`user_id`,`professions`,`first_name`,`last_name`,`email`,`gender`,`city`,`user_type`,`user_created_at`,`description`,`image`,`request_created_at`,`days`,`client_job_description`,`publish_time`,`client_first_name`,`client_last_name`,`client_email`,`client_budget`,`budget_type`) VALUES ('$client_id','$user_id','$professions','$first_name','$last_name','$email','$gender','$city','$user_type','$user_created_at','$description','$image','$date','$days','$job_description','$publish_time','$user_first_name','$user_last_name','$em','$budget','$budget_type')";
            if(mysqli_query($conn,$insert)){
                $success =  "მადლობა წარმატებით მოხდა დამკვეთისთვის სამუშაოზე მოთხოვნის გაგზავნა ის განიხილავს და თუ თქვენი კანდიდატურა აირჩევა გამოგიჩნდებათ მიღებულ შეკვეთებში";
            }
        }else{
             array_push($error,'თქვენ უკვე გაგზავნილი გაქვთ ამ სამსახურზე დამკვეთისთვის შეთავაზება');
        }
    }else{
        array_push($error,'სანამ გააკეთებთ კლიენტისთვის სამსახურზე შეთავაზებას გთხოვთ შეავსოთ შემსრულებლის პროფილი');
    }

    

    
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


<div class="task-container">
    <div class="task-info">
        <?php

            $select = "SELECT * FROM `client_task` WHERE id='$order_id'";
            $result = mysqli_query($conn,$select);

            $row = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($result)){
        ?>
            <h2>სამუშაოს შესახებ დეტალები</h2>
            <p><strong>კლიენტის სახელი / გვარი: </strong><?php echo $row['first_name']." ".$row['last_name'];?></p>
            <p><strong>კლიენტის ელ. ფოსტა: </strong><?php echo $row['email'];?></p>
            <p><strong>მოითხოვება: </strong><?php echo $row['professions'];?></p>
            <p><strong>შემსრულებელმა რამდენ დღეში დაასრულოს: </strong><?php echo $row['days']."-დღეში";?></p>
            <p><strong>კლიენტის ბიუჯეტი: </strong><?php echo $row['budget']." ლარი ".$row['budget_type'];?></p>
            <p><strong>სამუშაოს დეტალუტი აღწერა: </strong><?php echo $row['job_description'];?></p>
            <p><strong>გამოქვეყნების თარიღი: </strong><?php echo $row['publish_time'];?></p>
            
            <div class="form-group">
                <form method="post" action="<?php echo "performer_detailjob.php?professions=$professions&&days=$days&&job_description=$job_description&&publish_time=$publish_time&&first_name=$first_name&&last_name=$last_name&&email=$em&&budget=$budget&&budget_type=$budget_type&&user_id=$client_id&&order_id=$order_id"?>">
                    <button type="submit" name="request_job" class="btn-submit">დავალების აღება</button>
                </form>
            </div>
            <div class="success">
        <?php echo $success; ?>
    </div>
<div class="error">
    <?php foreach($error as $errors){
        echo $errors;
    }; 
    ?>
</div>
    <?php  }else{
        echo 'ამ ID ით ვერ მოიძებნა ვერაფერი';
    }
    
    ?>
    </div>
</div>

</body>
</html>
