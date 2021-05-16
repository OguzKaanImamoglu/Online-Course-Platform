<?php

session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];

if(isset($_POST['feedback_id'])){
    $_SESSION['feedback_id'] = $_POST['feedback_id'];


    $id = $_SESSION['feedback_id'];
    $note = $_POST['feedback_note'];
    $rating = $_POST['rating'];


    $sql = "UPDATE feedback SET feedback_note='$note', rating='$rating' WHERE feedback_id = '$id'";
    $result = mysqli_query($link,$sql);

}

?>