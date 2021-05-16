<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];

if(isset($_POST['course_id'])){
    $_SESSION['course_id'] = $_POST['course_id'];
}
?>