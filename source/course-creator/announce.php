<?php 
session_start();
include('../sign-up/database.php');


$selected_course_id = $_SESSION["course_id"];

$text = $_POST["announcement"];

$sql = "INSERT INTO announcement(text, date, course_id) 
		VALUES ('$text', CURDATE(), '$selected_course_id')";

if (!$result = mysqli_query($link,$sql)) {
	echo "Could not be announced.";
	echo " " . $link -> error;
}

header("Location: course-page.php?course_id=" . $selected_course_id);
?>