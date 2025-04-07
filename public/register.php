<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>რეგისტრაცია</title>
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>
<?php
    include_once("../includes/db_conn.php");
    $error = [];
    $success = "";
    if(isset($_POST['register'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $gender = $_POST['gender'];
        $city = $_POST['city'];
        $user_type = $_POST['user_type'];

        date_default_timezone_set('Asia/Tbilisi');
        $date  = date('d-m-Y h:i');


        if($first_name != "" and $last_name != "" and $email != "" and $password != "" and $confirm_password != "" and $gender != "" and $gender != "" and $city != "" and $user_type != ""){
            $select = "SELECT * FROM `users` WHERE email='$email'";
            $result = mysqli_query($conn,$select);
            if(mysqli_num_rows($result)){
                array_push($error ,'ესეთი email ით მომხმარებელი უკვე არსებობს');
            }
            
            elseif($password != $confirm_password){
                array_push($error ,'პაროლი არემთხვევა ერთმანეთს');
            }
            
            elseif(strlen($password) < 8 ){
                array_push($error ,'პაროლი მინიმუმალური სიგრზე უნდა შეაგნედეს 8-ს');
            }
            
            else{

                //$hashed_password = md5($password);
                $insert = "INSERT INTO `users` (`first_name`,`last_name`,`email`,`password`,`gender`,`city`,`user_type`,`created_at`) VALUES ('$first_name','$last_name','$email','$password','$gender','$city','$user_type','$date')";
                if(mysqli_query($conn,$insert)){
                    $success = "რეგისტრაცია წარმატებით მოხდა<br><a href='login.php'>შესვლის ფორმაში გადასვლა</a>";
                }
            }

        }
    }
?>
<div class="container">
    <h2>რეგისტრაცია</h2>
    <form action="register.php" method="POST" autocomplete="off">

        <div class="form-group">
            <label for="first_name">სახელი</label>
            <input type="text" id="first_name" name="first_name" placeholder="შეიყვანეთ სახელი" required>
        </div>
        

        <div class="form-group">
            <label for="last_name">გვარი</label>
            <input type="text" id="last_name" name="last_name" placeholder="შეიყვანეთ გვარი" required>
        </div>
        

        <div class="form-group">
            <label for="email">ელ. ფოსტა</label>
            <input type="email" id="email" name="email" placeholder="შეიყვანეთ ელ. ფოსტა" required>
        </div>
        

        <div class="form-group">
            <label for="password">პაროლი</label>
            <input type="password" id="password" name="password" placeholder="შეიყვანეთ პაროლი" required>
        </div>
        

        <div class="form-group">
            <label for="confirm_password">პაროლის გადამოწმება</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="დაადასტურეთ პაროლი" required>
        </div>
        

        <div class="form-group">
            <label>სქესი</label>
            <input type="radio" id="male" name="gender" value="კაცი" required>
            <label for="კაცი">კაცი</label>
            <input type="radio" id="female" name="gender" value="ქალი" required>
            <label for="ქალი">ქალი</label>
        </div>
        
        <div class="form-group">
            <label for="city">ქალაქი</label>
            <select id="city" name="city" required>
                <option value="" hidden>აირჩიე</option>
                <option value="თბილისი">თბილისი</option>
                <option value="ბათუმი">ბათუმი</option>
                <option value="ქუთაისი">ქუთაისი</option>
                <option value="ზუგდიდი">ზუგდიდი</option>
                <option value="ჩხოროწყუ">ჩხოროწყუ</option>
                <option value="რუსთავი">რუსთავი</option>
                <option value="ზესტაფონი">ზესტაფონი</option>
                <option value="თელავი">თელავი</option>
                <option value="გორი">გორი</option>
                <option value="საგარეჯო">საგარეჯო</option>
                <option value="სოხუმი">სოხუმი</option>
                <option value="ბათუმი">ბათუმი</option>
                <option value="აჭარა">აჭარა</option>
                <option value="ჭიათურა">ჭიათურა</option>
                <option value="მარნეული">მარნეული</option>
                <option value="მცხეთა">მცხეთა</option>
                <option value="ხაშური">ხაშური</option>
                <option value="ტყიბული">ტყიბული</option>
                <option value="ამბროლაური">ამბროლაური</option>
                <option value="წყალტუბო">წყალტუბო</option>
                <option value="ბოლნისი">ბოლნისი</option>
                <option value="ქარელი">ქარელი</option>
                <option value="აჭარა">აჭარა</option>
            </select>
        </div>

        <div class="form-group">
            <label for="user_type">მომხმარებლის ტიპი</label>
            <select id="user_type" name="user_type" required>
                <option value="" hidden>აირჩიე</option>
                <option value="შემსრულებელი">შემსრულებელი</option>
                <option value="დამკვეთი">დამკვეთი</option>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit" name="register" class="btn-submit">რეგისტრაცია</button>
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
