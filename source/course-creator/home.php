<?php 
session_start();
include('../sign-up/database.php');

$_SESSION["lecture_array"] = array();
$_SESSION["assignment_array"] = array();

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$sql = "SELECT wallet FROM course_creator WHERE course_creator_id='$person_id'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$wallet = $row["wallet"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>  
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="#">Discount Offers<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="publish-course.php">Publish New Course</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
			<h1 class="display-4">Welcome <?php echo "$name $surname"?></h1>
			<hr class="my-4">
			<p class="lead">
				My Wallet: 
				<i class="fa fa-usd fa-lg" aria-hidden="true"></i>
				<?php echo "$wallet" ?>
			</p>
			<h3 class="display-5 mb-4">My Courses</h3>
			<?php 

			$sql = "SELECT 	C.course_id, C.course_name, C.average_rating, total_student, 
			D.percentage, (CASE WHEN CURRENT_DATE >= D.start_date AND 
			CURRENT_DATE < D.end_date AND D.is_allowed
			THEN C.course_price * (( 100 - D.percentage ) / 100)
			ELSE c.course_price END) as price
			FROM		course C LEFT OUTER JOIN discount D ON 
			C.course_id = D.discounted_course_id, 
			(SELECT 	course_id, COUNT(student_id) AS total_student
			FROM 		enrolls
			WHERE 	course_id IN (SELECT course_id
			FROM course
			WHERE course_creator_id = @course_creator_id)
			GROUP BY 	course_id) course_student
			WHERE 	course_student.course_id = C.course_id";

			$result2 = mysqli_query($link, $sql);

			if (!$result2) {
				echo "There is no course found.";
			} else {
				$count2 = mysqli_num_rows($result);
	 			echo "$count2";

				if ($count2 > 0) {
					echo "<table class='table'>
						<thead>
							<th scope='col'>Course Id</th>
							<th scope='col'>Course Name</th>
							<th scope='col'>Price</th>
							<th scope='col'>Rating</th>
							<th scope='col'>Students</th>
							<th scope='col'>Discount</th>
						</thead>
					</table>
					</tbody>
					";

					while ($q_result = mysqli_fetch_array($result2)) {
						echo "<tr><th scope='row'>" . $q_result["course_id"] .
							"</th><td>" . $q_result["course_name"] .
							"</td><td>" . $q_result["price"] . 
							"</td><td>" . $q_result["average_rating"] .
							"</td><td>" . $q_result["total_student"].
							"</td><td>" . $q_result['percentage'] .
							"</td></tr>";
					}
				} else {
					echo "There is no course found.";
				}
			}
			?>
			<br></br>
			<a class="btn btn-success btn-lg" href="publish-course.php" role="button">Publish New Course</a>
			<a class="btn btn-success btn-lg ml-4" href="#" role="button">See Discount Offers</a>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
