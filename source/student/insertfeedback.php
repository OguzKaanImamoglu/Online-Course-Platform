<?php

session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];

if(isset($_POST['feedback_note']) && isset($_POST['rating'])){
    $comment = $_POST['feedback_note'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO feedback(feedback_note,rating) VALUES ('$comment', '$rating')";

    $result = mysqli_query($link, $sql);

    $total = 0;
    $f_id = $link->insert_id;


    $sql = "INSERT INTO student_feedbacks(feedback_id,student_id,course_id) VALUES('$f_id','$person_id','$course_id')";

    $result = mysqli_query($link, $sql);


}

?>