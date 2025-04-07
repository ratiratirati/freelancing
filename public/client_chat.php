<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>კომუნიკაცია შემსრულებელთან</title>
    <link rel="stylesheet" href="../assets/css/chat.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <script src="../assets/js/jquery.js"></script>
    <link rel="stylesheet" href="../assets/css/emojionearea.min.css">
    <script src="../assets/js/emojionearea.min.js"></script>
</head>
<body>
<?php

include_once("../includes/db_conn.php");

session_start();


if($_SESSION['user_id'] == ""){
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['logout'])){

    $update = "UPDATE `users` SET `online`='0' WHERE id='{$_SESSION['user_id']}'";
    mysqli_query($conn, $update);

    session_destroy();
    unset($_SESSION['user_id']);
    header('location: http://127.0.0.1/freelancing/public/login.php');
    exit;
}

date_default_timezone_set('Asia/Tbilisi');
$date = date('d-m-Y h:i');


$client_first_name = $_GET['client_first_name'];
$client_last_name = $_GET['client_last_name'];
$performer_id = $_GET['performer_id'];
$client_id = $_GET['client_id'];


if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $insert = "INSERT INTO `chat` (`first_name`, `last_name`, `performer_id`,`client_id`, `date`, `message`) 
               VALUES ('$client_first_name', '$client_last_name', '$performer_id','$client_id', '$date', '$message')";
    if (mysqli_query($conn, $insert)) {
        echo 'მესიჯი წარმატებით ჩაიწერა';
    } else {
        echo 'შეცდომა მონაცემთა ბაზაში: ' . mysqli_error($conn);
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


<div id="chat">
    <div id="online_status"> 
    </div>
    <div id="messages"></div>
    <textarea id="messageInput" placeholder='დაწერე შეტყობინება...'></textarea>
    <button id="sendMessage">გაგზავნა</button>
</div>

<script>
$(document).ready(function(){
    var client_first_name = "<?php echo $client_first_name; ?>";
    var client_last_name = "<?php echo $client_last_name; ?>";
    var performer_id = "<?php echo $performer_id; ?>";
    var client_id = "<?php echo $client_id; ?>";

    
    $("#messageInput").emojioneArea({
        pickerPosition: "bottom",
        filtersPosition: "top",
        search: true
    });

     function loadMessages() {
        $.ajax({
            url: 'chat_client.php',
            method: 'GET',
            data: {
                client_id: client_id,
                performer_id: performer_id,
            },
            success: function(response) {
                $('#messages').html(response);
                var messagesDiv = $('#messages');
                messagesDiv.scrollTop(messagesDiv[0].scrollHeight);
            }
        });

        $.ajax({
            url: 'performer_online_status.php',
            method: 'GET',
            data: {
                performer_id: performer_id,
            },
            success: function(response) {
                $('#online_status').html(response);
            }
        });
    }


    loadMessages();

    setInterval(loadMessages, 1000);

    $('#sendMessage').click(function(){
        var message = $('#messageInput').val();
        if(message) {
            $.ajax({
                url: 'client_chat.php?client_first_name=' + client_first_name + '&&client_last_name=' + client_last_name + '&&performer_id=' + performer_id + '&&client_id=' + client_id,
                method: 'POST',
                data: {
                    message: message,
                    client_first_name: client_first_name,
                    client_last_name: client_last_name,
                    client_id: client_id,
                    performer_id: performer_id,
                },
                success: function(response) {
                    $("#messageInput").data("emojioneArea").setText('');
                }
            });
        }
    });
    
});
</script>


</body>
</html>
