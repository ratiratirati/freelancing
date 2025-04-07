<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>პაროლის აღდგენა</title>
    <link rel="stylesheet" href="../assets/css/passwordreset.css">
</head>
<body>
<?php

include_once("../includes/db_conn.php");
$success = "";
$error = [];
if(isset($_POST['send_reset_request'])){
    $email = $_POST['email'];
    if ($email != ""){
        $select = "SELECT * FROM `users` WHERE email='$email'";
        $result = mysqli_query($conn,$select);
        if(!mysqli_num_rows($result)){
            array_push($error ,'თქვენს მიერ მითითებული email ით მომხმარებელი ვერ მოიძებნა');
        }else{
            $pass = rand(10000000,20000000);
            $update = "UPDATE `users` SET `password`='$pass' WHERE email='$email'";
            if(mysqli_query($conn,$update)){

        $api_key = 'e0d0cc05d0f8bc7715f144f64722966f';
        $url = 'https://send.api.mailtrap.io/api/send';

        $data = array(
            "from" => array(
                "email" => "hello@demomailtrap.com",
                "name" => "პაროლის აღდგენა"
            ),
            "to" => array(
                array("email" => $email)
            ),
            "subject" => "პაროლის აღდგენა",
            "text" => "შენი ერთჯერადი პაროლი არის: {$pass}",
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }else{
            $success = 'წარმატებით მოხდა ერთჯერადი პაროლის გაგზავნა მითითებულ მეილზე გთხოვთ გადაამოწმოთ მეილი';
        }

        curl_close($ch);


            }
            

        }
    }
}

?>
<div class="container">
    <h2>პაროლის აღდგენა</h2>
    <form action="password_reset.php" method="POST">
        <div class="form-group">
            <label for="email">თქვენი ელ. ფოსტა</label>
            <input type="email" id="email" name="email" placeholder="შეიყვანეთ თქვენი ელ. ფოსტა" required>
        </div>
        <div class="form-group">
            <button type="submit" name="send_reset_request" class="btn-submit">პაროლის აღდგენა</button>
        </div>
        <div class="form-footer">
            <p><a href="login.php">შესვლის ფორმაში დაბრუნება</a></p>
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
