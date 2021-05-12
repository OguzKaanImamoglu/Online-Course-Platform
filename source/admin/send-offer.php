<?php 
    session_start();
    include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];

    $course = $_POST["course"];

    //Get course id
    $cid = substr($course, 0, strpos($course, ' '));
    $discount = $_POST["discount"];
    $startdate = $_POST["start-date"];
    $enddate = $_POST["end-date"];

    $start = date("Y-m-d H:i:s",strtotime($startdate));

    $sql = "SELECT course_creator_id
            FROM course
            WHERE course_id = $cid";
    $result = mysqli_query($link, $sql);
    $data = $result->fetch_assoc();
	$ccid = $data['course_creator_id'];

    $sql = "INSERT INTO	discount(discounted_course_id, allower_course_creator_id, start_date, end_date, percentage) 
            VALUES ('$cid', '$ccid', '$startdate', '$enddate', '$discount')";
    $result = mysqli_query($link, $sql);

    if(!$result){
		echo '<script>alert("Discount insertion failed.");</script>';
	}
	else {
		echo '<script>alert("Discount insertion is successful.");';
		echo 'document.location = "discount-courses.php";</script>';
	}
    mysqli_close($link);
 ?>