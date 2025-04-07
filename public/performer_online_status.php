<?php 

    include_once("../includes/db_conn.php");

    $performer_id = $_GET['performer_id'];
    $select = "SELECT * FROM `users` WHERE id='$performer_id'";
    $result = mysqli_query($conn,$select);
    $row = mysqli_fetch_assoc($result);
    if ($row['online'] == 1 ){
        echo "<p style='color:blue;'>შემსრულებელი: Online</p>";
    }else{
        echo "<p style='color:red;'>შემსრულებელი: Offline</p>";
    }
    
?>