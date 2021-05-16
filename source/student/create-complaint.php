<?php

session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$course_id = $_SESSION['course_id'];

if (isset($_POST['make-complaint'])) {
	$complaint = $_POST['complaint'];
	$sql = "INSERT INTO complaint(complaint_note, complaint_date) VALUES ('$complaint', CURDATE())";

	$result = mysqli_query($link, $sql);

	if (!$result) {
		echo $link->error;
	} else {
		$inserted_id = mysqli_insert_id($link);

		$sql = "INSERT INTO student_complaints VALUES ('$inserted_id', '$person_id', '$course_id')";

		if (!mysqli_query($link, $sql)) {
			echo $link -> error;
		}
	}
	header("Location: course-page.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container">
	<div class="text-center" style="margin-top: 100px;">
    	<a class="btn btn-success btn-md text-center" href="course-page.php" role="button">Go Back to Your Course</a>
	</div>

	<form method="post">
		<label class="mt-4" for="complaint">Please explain with details why you are creating a complaint about this course.</label>
	  	<textarea class="form-control"
	  			 id="complaint" 
	  			 name="complaint" 
	  			 rows="3" placeholder="Enter Lecture Description" maxlength="500" minlength="10"></textarea>
	  	<button type="submit" name="make-complaint" id="make-complaint" class="btn btn-danger mt-4">Make a Complaint</button>
	</form>

</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
