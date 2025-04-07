<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>დამკვეთის პროფილი</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
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

$id = $_SESSION['user_id'];

if(isset($_GET['logout'])){

    $update = "UPDATE `users` SET `online`='0' WHERE id='{$_SESSION['user_id']}'";
    mysqli_query($conn, $update);

    session_destroy();
    unset($_SESSION['user_id']);
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}
$success = "";
$error = [];
if(isset($_POST['update_info'])){
    $update_option = $_POST['update_option'];
    $id = $_SESSION['user_id'];
    if ($update_option == 'all') {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $success = "პროფილი წარმატებით განახლდა.";
        $update_query = "UPDATE `users` SET `first_name`='$first_name', `last_name`='$last_name', `email`='$email', `city`='$city', `gender`='$gender', `description`='$description' WHERE id='$id'";
        mysqli_query($conn, $update_query);
    } elseif ($update_option == 'password') {
        $select = "SELECT `password` FROM `users` WHERE id='$id'";
        $result = mysqli_query($conn,$select);
        $row = mysqli_fetch_assoc($result);
        $old = $row['password'];
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
       if($old != $old_password){
            array_push($error , "თქვენს მიერ შეყვანილი ძველი პაროლი არ არის სწორი");
       }elseif($new_password != $confirm_password){
            array_push($error , "პაროლები არ ემთხვევა ერთმანეთს");
       }elseif(strlen($new_password) < 8){
            array_push($error ,"პაროლი მინიმუმალური სიგრზე უნდა შეაგნედეს 8-ს");
       }
       else{
        $update = "UPDATE `users` SET `password`='$new_password' WHERE id='$id'";
            if(mysqli_query($conn, $update)){
                $success =  "წარმატებით მოხდა პაროლის განახლება";
            }
       }
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
<div class="success">
        <?php echo $success; ?>
    </div>
<div class="error">
    <?php foreach($error as $errors){
        echo $errors;
    }; 
    ?>
</div>
<div class="profile-container">
    <div class="profile-info">
        <?php

            $select = "SELECT * FROM `users` WHERE id='$id'";
            $result = mysqli_query($conn,$select);

            while($row = mysqli_fetch_assoc($result)){
        ?>
            <h2>შემსრულებლის პროფილი</h2>
            <img class="performer_img" src="../assets/images/<?php echo $row['image']?>">
            <p><strong>სახელი / გვარი: </strong><?php echo $row['first_name']." ".$row['last_name'];?></p>
            <p><strong>ელ. ფოსტა: </strong><?php echo $row['email'];?></p>
            <p><strong>ქალაქი: </strong><?php echo $row['city'];?></p>
            <p><strong>სქესი: </strong><?php echo $row['gender'];?></p>
            <p><strong>მომხმარებლის ტიპი: </strong><?php echo $row['user_type'];?></p>
            <p><strong>მომხმარებლის რეგისტრაციის თარიღი: </strong><?php echo $row['created_at'];?></p>
            <p><strong>პროფილის აღწერა: </strong><?php echo $row['description'];?></p>
        <?php        
            }
        ?>
        
    <?php

    $select = "SELECT * FROM `users` WHERE id='$id'";
    $result = mysqli_query($conn,$select);

    $row = mysqli_fetch_assoc($result);
    ?>
        <form method="post" action="performer_profil.php">
    <div class="form-group">
        <label for="update_option">აირჩიეთ, თუ რა უნდა განახლდეს:</label>
        <select id="update_option" name="update_option" required>
            <option value="" hidden>აირჩიეთ</option>
            <option value="all">ყველა ინფორმაციის განახლება</option>
            <option value="password">პაროლის შეცვლა</option>
        </select>
    </div>

    <div class="all-info">
        <div class="form-group">
            <label for="last_name">სახელი</label>
            <input type="text" name="first_name" placeholder="სახელი" value="<?php echo $row['first_name']; ?>">
        </div>
        <div class="form-group">
            <label for="last_name">გვარი</label>
            <input type="text" name="last_name" placeholder="გვარი" value="<?php echo $row['last_name']; ?>">
        </div>
        <div class="form-group">
            <label for="last_name">ელ. ფოსტა</label>
            <input type="email" name="email" placeholder="ელ. ფოსტა" value="<?php echo $row['email']; ?>">
        </div>
        <div class="form-group">
            <label for="city">ქალაქი</label>
            <select name="city" required>
                <option value="<?php echo $row['city']; ?>" selected><?php echo $row['city']; ?></option>
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
            <label for="gender">სქესი</label>
            <input type="radio" id="male" name="gender" value="კაცი" <?php echo ($row['gender'] == 'კაცი') ? 'checked' : ''; ?>>
            <label for="male">კაცი</label>
            <input type="radio" id="female" name="gender" value="ქალი" <?php echo ($row['gender'] == 'ქალი') ? 'checked' : ''; ?>>
            <label for="female">ქალი</label>
        </div>
        <div class="form-group">
            <textarea name="description" placeholder="პროფილის აღწერა"><?php echo $row['description']; ?></textarea>
        </div>
    </div>

    <div class="password-info">
    <div class="form-group">
        <label for="old_password">ძველი პაროლი</label>
        <input type="password" id="old_password" name="old_password">
    </div>

    <div class="form-group">
        <label for="new_password">ახალი პაროლი</label>
        <input type="password" id="new_password" name="new_password">
    </div>

    <div class="form-group">
        <label for="confirm_password">პაროლის განმეორება</label>
        <input type="password" id="confirm_password" name="confirm_password">
    </div>
    </div>

    <div class="form-group">
        <button type="submit" name="update_info" class="btn-submit">რედაქტირება</button>
    </div>
</form>

    </div>
</div>

</body>
</html>
