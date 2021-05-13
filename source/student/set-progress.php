<?php
session_start();

include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];
echo $person_id;


if(isset($_POST['lecture_watch'])){
    $lecture_watch = $_POST['lecture_watch'];
    $sql1 =  "INSERT INTO progresses(student_id, course_id, lecture_id) VALUES ('$person_id', '$course_id', '$lecture_watch');";

    if (!mysqli_query($link, $sql1)) {
        echo "ERROR : COULD NOT BE ADDED" . mysqli_error($link);
    }
}

?>



