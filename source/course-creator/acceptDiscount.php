<?php

session_start();

include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
if(isset($_POST['discount_id'])){
    $discount_id = $_POST['discount_id'];
    $sql = "UPDATE discount SET is_allowed = 1 WHERE discount_id = '$discount_id'";

    $result = mysqli_query($link, $sql);
}

?>