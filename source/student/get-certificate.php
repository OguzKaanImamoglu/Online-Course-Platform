<?php 
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$course_id = $_SESSION['course_id'];

$course_sql = "SELECT course_name FROM course WHERE course_id='$course_id'";

$course_result = mysqli_query($link, $course_sql);
$res = mysqli_fetch_array($course_result);
$course_name = $res["course_name"];

$assignment_sql = "SELECT 	assignment_id
	FROM		assignment
	WHERE	course_id='$course_id'";

$can_get_certificate = 0;

$assignment_result = mysqli_query($link, $assignment_sql);
$assignment_id_array = array();
if (!$assignment_result) {
	echo $link -> error;
	die();
} else {
	$total_assignment_count = mysqli_num_rows($assignment_result);
	if ($total_assignment_count > 0) {
		while ($result = mysqli_fetch_array($assignment_result)) {
			array_push($assignment_id_array, $result["assignment_id"]);
		}
	}

	$passed_assignment = 0;

	for ($i = 0; $i < $total_assignment_count; $i++) {
		$assg_id = $assignment_id_array[$i];

		$student_sql = "SELECT	*
						FROM	submitted_assignments
						WHERE	assignment_id='$assg_id' AND
								student_id='$person_id' AND
								grade >= threshold";

		$student_result = mysqli_query($link, $student_sql);

		if (!$student_result) {
			if (mysqli_num_rows($student_result) > 0) {
				$passed_assignment = $passed_assignment + 1;
			}
		} else {
			echo $link -> error;
			die();
		}
	}

	if ($passed_assignment == $total_assignment_count) {
		$can_get_certificate = 1;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>  

	<div class="container">
		<button onclick="location.href='home.php'" style="margin-top: 50px;" class="text-center btn btn-primary">Back to Home</button>
		<button onclick="location.href='../logout.php'" style="margin-top: 50px;" class="text-center btn btn-primary float-right">Logout</button>
		<?php 

			if ($can_get_certificate) {

				$text = "";

				$text .= "
					<div class='card mt-4'>
					<div class='card-header'>
					   <h3>Congratulations</h3>
					</div>
					  <div class='card-body'>" ;

				$text .= "<p style='text-align: right'>" . date("Y/m/d") . "</p>";

				$text .= $name . " " . $surname . "
				by completing all lectures and assignments of 
				"; 
				$text .= $course_name . ", you have right to earn this certificate.";
				$text .= "<p class='mt-4'>Cemre Biltekin - CEO of Coursemy</p>";

					  $text .= "</div>
					</div>
				";

				echo $text;

				$text = $name . " " . $surname . " Congratulations. " . $course_name . " " . date("Y/m/d");
 
				$sql = "INSERT INTO 	certificate(date, text)
						VALUES (CURDATE(), '$text')";

				$result = mysqli_query($link, $sql);

				if (!$result) {
					echo $link->error;
					die();
				} else {
					$id = mysqli_insert_id($link);

					$sql = "INSERT INTO earns(student_id, course_id, certificate_id)
							VALUES ('$person_id', '$course_id', '$id')";

					if (!mysqli_query($link, $sql)) {
						echo $link->error;
						die();
					}
				}
			}
		 ?>
	</div>
		

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
