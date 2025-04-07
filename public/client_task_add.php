<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>შეკვეთის დამატება</title>
    <link rel="stylesheet" href="../assets/css/client_task_add.css">
    <link rel="stylesheet" href="../assets/css/header.css">
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
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];


if(isset($_GET['logout'])){

    $update = "UPDATE `users` SET `online`='0' WHERE id='{$_SESSION['user_id']}'";
    mysqli_query($conn, $update);

    session_destroy();
    unset($_SESSION['user_id']);
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}


if(isset($_POST['task_add'])){
    $professions = $_POST['professions'];
    $days = $_POST['days'];
    $job_description = $_POST['job_description'];
    $budget = $_POST['budget'];
    $budget_type = $_POST['budget_type'];
    date_default_timezone_set('Asia/Tbilisi');
    $date  = date('d-m-Y h:i');

    if($professions != "" and $days != "" and $job_description != "" and $budget != "" and $budget_type != ""){
        $insert = "INSERT INTO `client_task` (`user_id`,`email`,`first_name`,`last_name`,`professions`,`days`,`job_description`,`publish_time`,`budget`,`budget_type`) VALUES ('$user_id','$email','$first_name','$last_name','$professions','$days','$job_description','$date','$budget','$budget_type')";
        if(mysqli_query($conn,$insert)){
            $success = "წარმატებით მოხდა შეკვეთის დამატება";
        }else{
            $error[] = "ვერ მოხდა შეკვეთის დამატება";
        }
    }else{
        $error[] = "ყველა ველები შევსებული უნდა იყოს";
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

<div class="add-container">
    <form action="client_task_add.php" method="POST" autocomplete="off">

        <div class="form-group">
            <label for="professions">ვინ გჭირდებათ აირჩიეთ კატეგორია</label>
            <select id="professions" name="professions" required>
                <option value="" hidden>აირჩიე</option>
                <?php
                
                
                $computer_professions = [
                    "პროგრამისტი",
                    "ვებ-დეველოპერი",
                    "მობილური აპლიკაციების დეველოპერი",
                    "დიზაინერი / ფრონტენდ დეველოპერი",
                    "ბექენდ დეველოპერი",
                    "Full-stack დეველოპერი",
                    "პროგრამული უზრუნველყოფის ინჟინერი",
                    "პროცესების ავტომატიზაციის პროგრამისტი",
                    "მონაცემთა ბაზების ადმინისტრატორი",
                    "სტარტაპ დეველოპერი",
                    "ინფორმაციული უსაფრთხოების ექსპერტი",
                    "ჰაკერი / ეთიკური ჰაკერი",
                    "ინფორმაციული უსაფრთხოების ანალიტიკოსი",
                    "უსაფრთხოების არქიტექტორი",
                    "უსაფრთხოების ინჟინერი",
                    "კრიპტოგრაფი",
                    "მონაცემთა მეცნიერი",
                    "მონაცემთა ანალიტიკოსი",
                    "მონაცემთა ინჟინერი",
                    "ხელოვნური ინტელექტის ინჟინერი",
                    "მეცნიერება ნეირომარკეტინგში / ხელოვნური ინტელექტი",
                    "AI Researcher",
                    "მაჩვენებლის სწავლების სპეციალისტი",
                    "Big Data Analyst",
                    "ბიზნეს ანალიტიკოსი",
                    "UI/UX დიზაინერი",
                    "გრაფიკული დიზაინერი",
                    "ვებ დიზაინერი",
                    "მრავალდადებითი დიზაინი",
                    "ინტერაქტიული დიზაინერი",
                    "UI/UX კვლევის სპეციალისტი",
                    "სისტემური ადმინისტრატორი",
                    "ვირტუალური მასივი სისტემების ადმინისტრატორი",
                    "ქლაუდ ინჟინერი",
                    "ტექნიკური მხარდაჭერის სპეციალისტი",
                    "ნეტვორკის ინჟინერი",
                    "სტრიმინგი / ვიდეოს დამუშავების ინჟინერი",
                    "ნეტვორკ არქიტექტორი",
                    "ვირტუალური ქსელის სპეციალისტი",
                    "წარმოების ინჟინერი",
                    "ქსელ-ადმინისტრატორი",
                    "VPN სპეციალისტი",
                    "ტესტირების სპეციალისტი",
                    "პროგრამული უზრუნველყოფის ტესტერი",
                    "ინტეგრაციის ტესტერი",
                    "ავტომატიზაციის ტესტერი",
                    "ტესტირების გუნდის ლიდერი",
                    "ტესტირების ანალიტიკოსი",
                    "პროექტის მენეჯერი",
                    "პროდუქტის მენეჯერი",
                    "ტექნიკური პროექტების მენეჯერი",
                    "Agile პროექტების მენეჯერი",
                    "Scrum Master",
                    "პროგრამული უზრუნველყოფის არქიტექტორი",
                    "ვებ არქიტექტორი",
                    "შესრულების არქიტექტორი",
                    "IT კონსულტანტი",
                    "ტექნიკური კონსულტანტი",
                    "ტექნიკური ველური მენეჯერი",
                    "VR/AR ინჟინერი",
                    "VR/AR დიზაინერი",
                    "მობილური აპლიკაციების დეველოპერი",
                    "IOS დეველოპერი",
                    "Android დეველოპერი",
                    "ბლოკჩეინ დეველოპერი",
                    "კრიპტო ანალიტიკოსი",
                    "ბლოკჩეინის არქიტექტორი",
                    "კომპიუტერული სისტემების ინჟინერი (Aerospace)",
                    "დროითი ანალიტიკოსი",
                    "DevOps ინჟინერი",
                    "Cloud Solutions Architect",
                    "CI/CD-ინჟინერი"
                ];
                    foreach($computer_professions as $cp){
                        echo "<option value='.$cp.'>".$cp."</option>";
                    }      
                    
                ?>
            </select>
        </div>


        <div class="form-group">
            <label for="days">რამდენ დღეში დაასრულოს შემსრულებელმა</label>
            <select id="days" name="days" required>
                <option value="" hidden>აირჩიე</option>
                <?php
                
                $days_of_year = ["1 დღე","2 დღე","3 დღე","4 დღე","5 დღე","6 დღე","7 დღე","8 დღე","9 დღე","10 დღე","11 დღე","12 დღე","13 დღე","14 დღე","15 დღე","16 დღე","17 დღე","18 დღე","19 დღე","20 დღე","21 დღე","22 დღე","23 დღე","24 დღე","25 დღე","26 დღე","27 დღე","28 დღე","29 დღე","30 დღე"];


                foreach($days_of_year as $day){
                    echo "<option value=".$day.">".$day."</option>";
                }   
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="budget">ბიუჯეტი ლარში</label>
            <input type="text" id="budget" name="budget" placeholder="შეიყვანეთ ბიუჯეტი" required>
        </div>

        <div class="form-group">
            <label for="budget_type">გადახდის ტიპი</label>
            <select id="budget_type" name="budget_type" required>
                <option value="" hidden>აირჩიე</option>
                <option value="საათში">საათში</option>
                <option value="პროექტის დასრულებისას">პროექტის დასრულებისას</option>
            </select>
        </div>

        <div class="form-group">
            <label for="days">დავალების მოკლე აღწერა</label>
            <textarea required name="job_description"></textarea>
        </div>
        

        <div class="form-group">
            <button type="submit" name="task_add" class="btn-submit">შეკვეთის დამატება</button>
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
    </form>
</div>

</body>
</html>
