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

    $total = 0.0;

    $sql = "SELECT f.rating FROM feedback f, student_feedbacks  sf 
            WHERE sf.feedback_id = f.feedback_id AND sf.course_id = '$course_id'";


    $result = mysqli_query($link, $sql);

    if(!$result){
        echo "ERROR " . $link->error;
    }else{
        $count = mysqli_num_rows($result);

        if($count == 0){
            echo "Error! No feedback found";
        }else{

            while($q_result = mysqli_fetch_array($result)){
                $total += $q_result['rating'];
            }
            $rate = $total / (float) $count;
            $sql = "UPDATE course SET average_rating = '$rate' WHERE course_id = '$course_id'";

            $result = mysqli_query($link, $sql);
        }
    }
}

?>