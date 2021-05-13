<?php
session_start();

include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];
$lecture_id = $_SESSION['lecture_id'];

$sql1 = "SELECT lecture_id FROM	lecture WHERE course_id='$course_id' AND lecture_id > '$lecture_id'  ORDER BY lecture_id ASC LIMIT 1;";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

$_SESSION['lecture_id'] = $row1['lecture_id'];


?>
<!DOCTYPE html>
<script>
window.location.replace("watch-lecture.php");
</script>
</html>
