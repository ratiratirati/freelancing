<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>შემსრულებლის ძიების გვერდი</title>
    <link rel="stylesheet" href="../assets/css/performer_searchtask.css">
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


if(isset($_POST['search'])){
    $professions_search = urlencode($_POST['professions_search']);
    if($professions_search != ""){
        $cookie_name = "filter";
        $cookie_value = $professions_search;
        setcookie($cookie_name, $cookie_value, time() + (60 * 60 * 24 * 365), "/");
        header('location: performer_searchtask.php');
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
<div class="container">
<div class="form-group">
    <form method="post" action="performer_searchtask.php">
            <select id="professions_search" name="professions_search">
                <option value="" hidden>ძიება პროფესიის მიხედვით</option>
                <option value="1">ყველა პროფესია</option>
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
        <button name="search">ძიება</button>
        </form>
        </div>
    </div>
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

    if(isset($_COOKIE['filter'])){
        if($_COOKIE['filter'] == 1){
            $query = "SELECT * FROM `client_task`";  
        }else{
            $x = urldecode($_COOKIE['filter']);
            $query = "SELECT * FROM `client_task` WHERE professions='$x'";  
        }
    }
    else{
        $query = "SELECT * FROM `client_task`";  
    }

    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['first_name']." ".$row['last_name']. "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['professions'] . "</td>";
            echo "<td>" . $row['budget']." ლარი ".$row['budget_type']."</td>";
            echo "<td>" . $row['days'] . "-დღეში</td>";
            echo "<td>" . $row['publish_time'] . "</td>";
            echo "<td><a href='performer_detailjob.php?professions=". $row['professions']."&&user_id=" . $row['user_id'] . "&&order_id=" . $row['id']."&&job_description=" . $row['job_description']."&&publish_time=" . $row['publish_time']."&&first_name=" . $row['first_name']."&&last_name=" . $row['last_name']."&&email=" . $row['email']."&&budget=" . $row['budget']."&&budget_type=" . $row['budget_type']."&&days=" . $row['days'] ."'>დეტალურად ნახვა</a></td>";
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
