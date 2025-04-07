<?php 

    include_once("../includes/db_conn.php");

    $client_id = $_GET['client_id'];
    $select = "SELECT * FROM `users` WHERE id='$client_id'";
    $result = mysqli_query($conn,$select);
    $row = mysqli_fetch_assoc($result);
    if ($row['online'] == 1 ){
        echo "<p style='color:blue;'>კლიენტი: Online</p>";
    }else{
        echo "<p style='color:red;'>კლიენტი: Offline</p>";
    }
    
?>