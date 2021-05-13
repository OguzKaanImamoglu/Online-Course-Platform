<?php 
session_start();
include('../sign-up/database.php');

$selected_course_id = $_GET['course_id'];

$_SESSION["selected_course_id"] = $selected_course_id;

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
		<a class="navbar-brand" href="">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="discount-offers.php">Discount Offers<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="publish-course.php">Publish New Course</a>
				</li>
				<li class="nav-item">
            	<?php
                	echo "<a href='course-page.php?course_id=$selected_course_id' class='nav-link'>Course Page</a>";
            	?>
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

	<div class="row mt-4">
		<div class="col-md-3" style="padding-left: 50px; padding-right: 50px;">
			<h3 class="text-center mb-4">Announcements</h3>

			<?php 
				$sql = "SELECT 	text
						FROM 		announcement
						WHERE 	course_id = '$selected_course_id'
						ORDER BY	announcement_id DESC";

				if (!$result = mysqli_query($link,$sql)) {
					echo "There is no course found.";
					echo " " . $link -> error;
				} else {
					$count = mysqli_num_rows($result);

					if ($count > 0) {

						$i = 1;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							echo "<p>" . $i . ". " . $row["text"] . "</p>";
							echo "<hr></hr>";
							$i = $i + 1;
						}



					} else {
						echo "<p>There is no announcement in this course.";
					}



				}
			 ?>
		</div>
		<div class="col-md-6">
			<h3 class="text-center mb-4">Lectures</h3>

			<?php 
				$sql = "SELECT 	lecture_name, description, duration
						FROM 		lecture
						WHERE 	course_id='$selected_course_id'";

				$result = mysqli_query($link, $sql);

				if (!$result) {
					echo "There is no course found.";
					echo " " . $link -> error;
				} else {
					$count = mysqli_num_rows($result);

					if ($count > 0) {
						echo "<table class='table table-striped'>
							<thead>
								<th scope='col'>Lecture Name</th>
								<th scope='col'>Description</th>
								<th scope='col'>Duration</th>
							</thead>
						<tbody>
						";

						while ($q_result = mysqli_fetch_array($result)) {
							echo "<tr><th scope='row'>" . $q_result["lecture_name"] .
							"</th><td>" . $q_result["description"] .
							"</td><td>" . $q_result["duration"];
							echo "</td></tr>";
						}
						echo "</tbody>";
						echo "</table>";
					} else {
						echo "<p class='text-center'>There is no lecture in this course.</p>";
					}
				}

				echo '<a href="assignments.php?cid=' . $selected_course_id . '" class="btn btn-success mt-2">View Assignments</a>';
			 ?>

			<button type="button" class="btn btn-success mt-2 float-right">Q&A Page</button>

		</div>
		<div class="col-md-3" style="padding-right: 50px;">
			<form action="announce.php" method="post">
				<div class="input-group">
				  <textarea class="form-control" name="announcement" maxlength="500" aria-label="With textarea" placeholder="Create a new announcement..."></textarea>
				</div>
				<button type="submit" class="btn btn-success mt-2">Announce</button>
			</form>
		</div>
	</div>

	<div class="row">

	</div>
	


	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
