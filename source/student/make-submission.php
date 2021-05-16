<?php
    session_start();
	include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
	$name = $_SESSION['name'];
	$surname = $_SESSION['surname'];

    //Get assignment ID
    $aid = $_POST["aid"];
    $cid = $_POST["cid"];
    $answer = $_POST["answer"];
    $index = $_POST["index"];

    echo $answer;
    echo $cid;
    echo $aid;

    $sql = "INSERT INTO submitted_assignment(assignment_id, student_id, submission_time, assignment_answer)
            VALUES ('$aid', '$person_id', CURRENT_TIMESTAMP, '$answer')";
    $result = mysqli_query($link, $sql);

    if(!$result){
		echo '<script>alert("Submission failed.");</script>';
	}
	else {
		echo '<script>';
		echo 'document.location = "see-attempts.php?cid=' . $cid . '&aid=' . $aid . '&index=' . $index .'";</script>';
	}
    mysqli_close($link);

?>