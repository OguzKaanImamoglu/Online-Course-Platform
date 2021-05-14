<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION["person_id"];

if(isset($_POST['drop_id'])){
    $id = $_POST['drop_id'];

    $sql = "DELETE FROM adds_to_wishlist WHERE student_id = '$person_id' AND course_id= '$id'";

    $result = mysqli_query($link,$sql);
}

?>