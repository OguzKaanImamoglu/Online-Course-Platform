<?php 
session_start();
include('../sign-up/database.php');

//$_SESSION['selected_course_id'] = $_POST['selected_course_id'];
$selected_course_id = $_GET['course_id'];

$student_id = $_SESSION["person_id"];

$sql = "INSERT INTO 	adds_to_wishlist(student_id, course_id)
VALUES ('$student_id', '$selected_course_id')";

mysqli_query($link, $sql);

header("Location: home.php");
?>