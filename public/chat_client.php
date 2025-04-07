<?php


include_once("../includes/db_conn.php");


$performer_id = $_GET['performer_id'];
$client_id = $_GET['client_id'];


$sql = "SELECT * FROM `chat` WHERE `performer_id` = '$performer_id' and `client_id` = '$client_id'  ORDER BY `date` ASC";
$result = mysqli_query($conn, $sql);


$messages = '';
while ($row = mysqli_fetch_assoc($result)) {
    $messages .= '<div class="message">';
    $messages .= '<strong>' . $row['first_name'] . ' ' . $row['last_name'] . ':</strong> ' . $row['message'];
    $messages .= '</div>';
}
?>

<div id="messages">
    <?php echo $messages; ?>
</div>