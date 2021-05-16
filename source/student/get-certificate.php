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
						FROM	submitted_assignment a, assignment b
						WHERE	a.assignment_id='$assg_id' AND
								a.student_id='$person_id' AND
								a.grade >= b.assignment_threshold AND a.assignment_id = b.assignment_id";

		$student_result = mysqli_query($link, $student_sql);

		if ($student_result) {
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../student/home.php">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../student/course-market.php">Course Market</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/my-courses.php">My Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/myCertificates.php">My Certificates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="course-page.php">Course Page</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
	<div class="container">
        <button onclick="location.href='course-page.php'" style="margin-top: 50px;" class="text-center btn btn-primary">Back to Course Page</button>

        <?php

            $sql_cer = "SELECT certificate_id FROM earns WHERE student_id = '$person_id' AND course_id = '$course_id'";
            $exist = mysqli_query($link, $sql_cer);

            $sql_cc = "SELECT P.name, P.surname FROM person P, course C WHERE P.person_id = C.course_creator_id AND C.course_id = '$course_id'";
            $result_cc = mysqli_query($link, $sql_cc);
            $co = mysqli_num_rows($result_cc);
            $cc = mysqli_fetch_array($result_cc);

            $cc_name = $cc["name"] ." ". $cc['surname'];
            $count = mysqli_num_rows($exist);
            if($count){
                $cert = mysqli_fetch_array($exist);
                $c = $cert['certificate_id'];
                $sql_cer = "SELECT c.date, c.text FROM certificate c WHERE c.certificate_id = '$c'";
                $exist = mysqli_query($link, $sql_cer);
                $cert = mysqli_fetch_array($exist);
                $cert_text = $cert['text'];
                $date = $cert['date'];

                echo "<div class='card mt-4'>
                    <div class='card-header'>
                       <h3>Congratulations</h3>
                    </div>
                      <div class='card-body'>
                      <p style='text-align: right'> $date</p>
                      $cert_text
                      <p class = 'mt-4'>$cc_name - Course Teacher</p>
                  <p class='mt-4'>Cemre Biltekin - CEO of Coursemy</p>";

            }
            else if ($can_get_certificate) {
                //echo "<script>alert('$cc_name');</script>";

                $text = "";

                $text = $text . "
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
                $text .= "<p class = 'mt-4'>$cc_name - Course Teacher</p>";
                $text .= "<p class='mt-4'>Cemre Biltekin - CEO of Coursemy</p>";

                $text .= "</div>
                    </div>
                ";

                echo $text;

                $text = $name . " " . $surname . " by completing all lectures and assignments " . $course_name. ", you have right to earn this certificate.";

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
            }else{
                echo "<div>Requirements don't meet. Finish lectures and assignments to earn certificate!</div>";
            }

        ?>
	</div>


	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
