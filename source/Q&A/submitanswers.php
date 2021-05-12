<?php
session_start();

include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
if(isset($_POST['question_id'])){
    $question_id = $_POST['question_id'];
    $question_text = $_POST['question_text'];
    $sql = "INSERT INTO answers VALUES('$question_id', '$person_id', '$question_text')";

    $result = mysqli_query($link, $sql);
}


?>