<?php
    session_start();
	include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
	$name = $_SESSION['name'];
	$surname = $_SESSION['surname'];

    //get refund request id
    $rid = $_GET['rid'];

    $sql = "SELECT student_id, course_id
            FROM refund_requests
            WHERE refund_id = '$rid'";
    $result = mysqli_query($link, $sql);
    $data = $result->fetch_assoc();
	$sid = $data['student_id'];
    $cid = $data['course_id'];

    $sql = "SELECT course_creator_id
            FROM course
            WHERE course_id = '$cid'";
    $result = mysqli_query($link, $sql);
    $data = $result->fetch_assoc();
	$ccid = $data['course_creator_id'];

    $sql = "SELECT E.purchased_price
            FROM enrolls E
            WHERE E.course_id = '$cid' AND E.student_id = '$sid'";
   
    $result = mysqli_query($link, $sql);
    $data = $result->fetch_assoc();
	$fee = $data['purchased_price'];

    $sql = "UPDATE student
            SET wallet = '$fee' + wallet
            WHERE student_id = '$sid'";
    mysqli_query($link, $sql);

    $sql = "UPDATE course_creator
            SET wallet = wallet - '$fee'
            WHERE course_creator_id = '$ccid'";
    mysqli_query($link, $sql);

    $sql = "DELETE FROM	enrolls
            WHERE student_id = '$sid' AND course_id = '$cid'";
    mysqli_query($link, $sql);

    $sql = "UPDATE refund
            SET is_assessed = TRUE, is_approved = TRUE
            WHERE refund_id = '$rid'";
    $result = mysqli_query($link, $sql);

    if(!$result){
		echo '<script>alert("Refund rejection failed.");</script>';
	}
	else {
		echo '<script>alert("Refund request is accepted.");';
		echo 'document.location = "refund-requests.php";</script>';
	}
    mysqli_close($link);
?>