<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>შესვლა</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<?php
    session_start();
    include_once("../includes/db_conn.php");
    $success = "";
    $error = [];
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        if($email != "" and $password != "") {
            $select = "SELECT * FROM `users` WHERE `email`='$email'";
            $result = mysqli_query($conn, $select);
            $row = mysqli_fetch_assoc($result);
    
            if(mysqli_num_rows($result)) {
                if($row['password'] != $password) {
                    $error[] = "პაროლი არასწორია.";
                } else {
                    if($row["user_type"] == "შემსრულებელი") {
                        $_SESSION['email'] = $email;
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        header('location: http://127.0.0.1/freelancing/public/performer_login.php');

                        $update = "UPDATE `users` SET `online`='1' WHERE id='{$_SESSION['user_id']}'";
                        mysqli_query($conn, $update);

                    } else if($row["user_type"] == "დამკვეთი") {
                        $_SESSION['email'] = $email;
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        header('location: http://127.0.0.1/freelancing/public/client_login.php');

                        $update = "UPDATE `users` SET `online`='1' WHERE id='{$_SESSION['user_id']}'";
                        mysqli_query($conn, $update);
                    }
                }
            } else {
                $error[] = "ესეთი მომხმარებელი ბაზაში არ არსებობს.";
            }
        } else {
            $error[] = "ელ. ფოსტა ან პაროლი არ უნდა იყოს ცარიელი.";
        }
    }
    

?>

<div class="login-container">
    <h2>შესვლა</h2>
    <form action="login.php" method="POST" autocomplete="off">

        <div class="form-group">
            <label for="email">ელ. ფოსტა</label>
            <input type="email" id="email" name="email" placeholder="შეიყვანეთ თქვენი ელ. ფოსტა" required>
        </div>


        <div class="form-group">
            <label for="password">პაროლი</label>
            <input type="password" id="password" name="password" placeholder="შეიყვანეთ პაროლი" required>
        </div>


        <div class="form-group">
            <button type="submit" name="login" class="btn-submit">შესვლა</button>
        </div>


        <div class="form-footer">
            <p>არ გაქვთ ანგარიში? <a href="register.php">დარეგისტრირდით</a></p>
            <p><a href="password_reset.php">დავივიწყე პაროლი</a></p>
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
