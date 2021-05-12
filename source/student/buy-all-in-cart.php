<?php 
session_start();
include('../sign-up/database.php');

$student_id = $_SESSION["person_id"];
$courses = $_SESSION["courses_in_cart"];

print_r($courses);

foreach ($courses as $key => $value) {
	$course_id = $value;

	$sql =  "SELECT C.course_id, C.course_name, C.course_price, C.average_rating,
		P.name, P.surname, D.percentage,
		(CASE WHEN CURRENT_DATE <= D.end_date AND
		CURRENT_DATE >= D.start_date AND D.is_allowed
		THEN C.course_price * (( 100 - D.percentage ) / 100)
		ELSE C.course_price END) as price
		FROM course C LEFT OUTER JOIN discount D ON
		C.course_id = D.discounted_course_id LEFT JOIN person P ON C.course_creator_id = P.person_id LEFT JOIN adds_to_cart AC
		ON AC.student_id='$student_id'
		WHERE C.course_id=AC.course_id AND C.course_id='$course_id'";

	$result = mysqli_query($link, $sql);

	if (!$result) {
		echo "There is no course found.";
		echo " " . $link -> error;
	} else {
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$purchased_price = $row["price"];

		$sql = "INSERT INTO enrolls(student_id, course_id, purchased_price, purchase_date)
				VALUES ('$student_id', '$course_id', '$purchased_price', CURDATE())";

		
	}
}

?>