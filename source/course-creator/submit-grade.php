<?php
    session_start();
	include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
	$name = $_SESSION['name'];
	$surname = $_SESSION['surname'];

    //Get inputs
    $grade = $_POST['grade_awarded'];
    $aid = $_POST['aid'];
    $sid = $_POST['sid'];
    $cid = $_POST['cid'];
    $time = $_POST['time'];
    $index = $_POST['index'];

    $sql = "UPDATE submitted_assignment
	        SET grade = $grade, is_graded = TRUE
	        WHERE assignment_id = '$aid' AND student_id = '$sid' 
            AND submission_time = '$time' AND is_graded = FALSE";
    $result = mysqli_query($link, $sql);

    if(!$result){
		echo '<script>alert("Grading failed.");</script>';
	}
	else {
		echo '<script>alert("Grading is successful.");';
		echo 'document.location = "see-subs.php?cid=' . $cid . '&aid=' . $aid . '&index=' . $index .'";</script>';
	}
    mysqli_close($link);

?>