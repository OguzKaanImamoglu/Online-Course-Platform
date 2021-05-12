<?php 
session_start();
include('../sign-up/database.php');

$student_id = $_SESSION["person_id"];
$courses = $_SESSION["courses_in_cart"];

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

		if(!mysqli_query($link, $sql)) {
			echo "could not enroll.";
			die();
		}

		$sql = "UPDATE 	student
				SET 	wallet = wallet - " . $purchased_price . "
				WHERE	student_id='$student_id'";

		if (!mysqli_query($link, $sql)) {
			echo "could not decrease wallet";
			die();
		}

		$sql = "SELECT 	course_creator_id
				FROM	course
				WHERE	course_id='$course_id'";


		if(!mysqli_query($link, $sql)) {
			echo "course_creator_id not found";
			die();
		}

		$result = mysqli_query($link, $sql);

		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		$course_creator_id = $row["course_creator_id"];

		$sql = "UPDATE	course_creator
				SET		wallet = wallet + '$purchased_price'
				WHERE	course_creator_id = '$course_creator_id'";

		if (!mysqli_query($link, $sql)) {
			echo "Course creator's wallet not increased.";
			die();
		}

		$sql = "DELETE FROM adds_to_wishlist
				WHERE		student_id='$student_id' AND course_id='$course_id'";

		if (!mysqli_query($link, $sql)) {
			echo "course could not be added from wishlist";
		}

		$sql = "DELETE FROM	adds_to_cart
				WHERE 		student_id='$student_id' AND course_id='$course_id'";

		if (!mysqli_query($link, $sql)) {
			echo "course could not be deleted from cart";
			die();
		}
	}
}

?>