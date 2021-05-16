<?php 
session_start();
include('../sign-up/database.php');

$selected_course_id = $_GET['course_id'];

$sql = "SELECT 	C.course_name, C.course_price, C.create_date, C.language,
C.course_description, C.average_rating, P.name, P.surname
FROM 		course C, person P
WHERE 	C.course_creator_id = P.person_id AND C.course_id = '$selected_course_id'";


if (!$result = mysqli_query($link,$sql)) {
	echo "There is no course found.";
	echo " " . $link -> error;
} else {
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$course_name = $row["course_name"];
	$course_price = $row["course_price"];
	$create_date = $row["create_date"];
	$language = $row["language"];
	$course_description = $row["course_description"];
	$average_rating = $row["average_rating"];
	$creator_name = $row["name"];
	$creator_surname = $row["surname"];
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
                <a class="nav-link" href="../student/my-courses.php">Your Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/myCertificates.php">Your Certificates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">Your Questions</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

	<div class="container text-center mb-4 mt-4">
		<h3 class="display-4">
			<?php echo $course_name ?>
		</h3>
	</div>

	<div class="container">
		<div class="row">
			<?php 

			$student_id = $_SESSION["person_id"];
			$sql = "SELECT * 
			FROM enrolls
			WHERE course_id='$selected_course_id' AND student_id='$student_id'";

			$cart_sql = "SELECT * 
			FROM adds_to_cart
			WHERE course_id='$selected_course_id' AND student_id='$student_id'";

			if (!$cart_result = mysqli_query($link, $cart_sql)) {
				echo $link.error;
				die();
			} else {
				$cart_count = mysqli_num_rows($cart_result);

				if ($cart_count > 0) {
					echo "
					<div class='col-md-2 text-center'>
					<i class='fa fa-cart-plus fa-5x' style='margin-top: 20%'></i>
					<p>This course is already in your cart.</p>
					</div>
					";
				} else {
					if (!$result = mysqli_query($link, $sql)) {
						echo " " . $link -> error;
						die();
					} else {
						$count = mysqli_num_rows($result);

						if ($count > 0) {
							echo "
							<div class='col-md-2 text-center'>
							<i class='fa fa-cart-plus fa-5x' style='margin-top: 20%'></i>
							<p>You have already enrolled in this course.</p>
							</div>
							";
						} else {
							echo "
							<div class='col-md-2 text-center'>
							<a href='add-cart.php?course_id=$selected_course_id'>
							<i class='fa fa-cart-plus fa-5x' style='margin-top: 20%'></i>
							<br></br>
							<label>Add to Cart</label>
							</a>
							</div>
							";
						}
					}	
				}
			}
			?>
			<div class="col-md-8" style="background-color: #dadada;">
				<dl class="row">
					<dt class="col-sm-3 mt-4">Course Instructor</dt>
					<dd class="col-sm-9 mt-4"><?php echo $creator_name . " " . $creator_surname; ?></dd>

					<dt class="col-sm-3 mt-4">Language</dt>
					<dd class="col-sm-9 mt-4"><?php echo $language; ?></dd>

					<dt class="col-sm-3 mt-4">Course Description</dt>
					<dd class="col-sm-9 mt-4"><?php echo $course_description; ?></dd>

					<dt class="col-sm-3 mt-4">Average Rating</dt>
					<dd class="col-sm-9 mt-4"><?php echo $average_rating; ?></dd>

					<?php 
					$sql = "SELECT 	C.course_id, C.course_name, C.language, C.average_rating, C.category,\n"

					. "P.name, P.surname, D.percentage, D.start_date, D.end_date, \n"

					. "D.is_allowed, (CASE WHEN CURRENT_DATE <= D.end_date AND \n"

					. "CURRENT_DATE >= D.start_date AND D.is_allowed\n"

					. "           				THEN C.course_price * (( 100 - D.percentage ) / 100)\n"

					. "           				ELSE C.course_price END) as price\n"

					. "FROM 		course C LEFT OUTER JOIN discount D ON \n"

					. "C.course_id = D.discounted_course_id LEFT JOIN person P ON C.course_creator_id = P.person_id WHERE C.course_id='$selected_course_id'";




					if (!$result = mysqli_query($link,$sql)) {
						echo "There is no course found.";
						echo " " . $link -> error;
					} else {
						$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

						if ($row["is_allowed"] == 0 || $row["is_allowed"] == "" || is_null($row["is_allowed"])) {
							echo "
							<dt class='col-sm-3 mt-4'>Price</dt>
							<dd class='col-sm-9 mt-4'>" . number_format($row["price"], 2) . "$</dd>
							";

							echo "
							<dt class='col-sm-3 mt-4'>Discount</dt>
							<dd class='col-sm-9 mt-4'> There is no discount on this course. </dd>
							";
						} else {
							echo "
							<dt class='col-sm-3 mt-4'>Price</dt>
							<dd class='col-sm-9 mt-4'>" . number_format($row["price"], 2) . "$</dd>
							";

							echo "
							<dt class='col-sm-3 mt-4'>Discount</dt>
							<dd class='col-sm-9 mt-4'>" . $row["percentage"] . " </dd>
							";
						}
					}

					?>


				</dl>
			</div>
			<?php 

			$student_id = $_SESSION["person_id"];
			$sql = "SELECT * 
			FROM enrolls
			WHERE course_id='$selected_course_id' AND student_id='$student_id'";

			$wishlist_sql = "SELECT * 
			FROM adds_to_wishlist
			WHERE course_id='$selected_course_id' AND $student_id='$student_id'";

			if (!$wishlist_result = mysqli_query($link, $wishlist_sql)) {
				echo $link -> error;
				die();
			} else {
				$wishlist_count = mysqli_num_rows($wishlist_result);

				if ($wishlist_count > 0) {
					echo "
					<div class='col-md-2 text-center'>
					<i class='fa fa-list fa-5x' style='margin-top: 20%'></i>
					<p>This course is already in your wishlist.</p>
					</div>
					";
				} else {
					if (!$result = mysqli_query($link, $sql)) {
						echo " " . $link -> error;
						die();
					} else {
						$count = mysqli_num_rows($result);

						if ($count > 0) {
							echo "
							<div class='col-md-2 text-center'>
							<i class='fa fa-list fa-5x' style='margin-top: 20%'></i>
							<p>You have already enrolled in this course.</p>
							</div>
							";
						} else {
							echo "
							<div class='col-md-2 text-center'>
							<a href='add-wishlist.php?course_id=$selected_course_id'>
							<i class='fa fa-list fa-5x' style='margin-top: 20%'></i>
							<br></br>
							<label>Add to Wishlist</label>
							</a>
							</div>
							";
						}
					}	
				}
			}

			
			?>

		</div>

		<div class="row" style="margin-top: 40px;">
			<div class="col-md-8 mx-auto">
				<h3>Comments</h3>
			</div>			
		</div>


		<div class="row text-center" style="margin-top: 20px;">
			<div class="col-md-8 mx-auto" style="background-color: #dadada;">
				<?php 
				$sql = "SELECT	P.name, P.surname, F.feedback_note, F.rating
				FROM	student_feedbacks SF, feedback F, person P
				WHERE	SF.student_id=P.person_id AND
				SF.course_id='$selected_course_id' AND
				SF.feedback_id=F.feedback_id";

				if (!$result = mysqli_query($link,$sql)) {
					echo "There is comments in this course.";
					echo " " . $link -> error;
				} else {

					$count = mysqli_num_rows($result);

					if (!$count) {
						echo "There is no comment in this course.";
					} else {

                        echo "<table class='table'>
                                    <thead>
                                    <th scope='col'>Name Surname</th>
                                    <th scope='col'>Comment</th>
                                    <th scope='col'>Rate/5</th>                                    
                                    </thead>
                            <tbody>";

                        while($q_result = mysqli_fetch_array($result)){
                            $name = $q_result['name'] . " " . $q_result['surname'];
                            $comment = $q_result['feedback_note'];
                            $rate = $q_result['rating'];
                            echo "<tr><td>$name</td><td>$comment</td><td>$rate</td></tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
					}
				}
				?>
			</div>
		</div>

	</div>



	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
