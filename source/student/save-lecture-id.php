<?php
session_start();

include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];

if(isset($_POST['lecture_id'])){
    $_SESSION['lecture_id'] = $_POST['lecture_id'];
}

?>