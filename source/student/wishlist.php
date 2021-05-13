<?php 
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION["person_id"];

$sql = "SELECT wallet FROM student WHERE student_id='$person_id'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$wallet = $row["wallet"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript">
		function btnclick() {
			window.location.href = "buy-all-in-wishlist.php";
		}
	</script>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link active" href="course-market.php">Course Market<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="my-courses.php">Your Courses</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="add-money.php">Add Money</a>
				</li>
				<li class="nav-item">
                    <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
                </li>
			</ul>
		</div>
	</nav>

	<h1 class="text-center mt-4 mb-4">Your Wishlist</h1>

	<div class="container">
		<?php 
		$sql = "SELECT C.course_id, C.course_name, C.course_price, C.average_rating,
		P.name, P.surname, D.percentage,
		(CASE WHEN CURRENT_DATE <= D.end_date AND
		CURRENT_DATE >= D.start_date AND D.is_allowed
		THEN C.course_price * (( 100 - D.percentage ) / 100)
		ELSE C.course_price END) as price
		FROM course C LEFT OUTER JOIN discount D ON
		C.course_id = D.discounted_course_id LEFT JOIN person P ON C.course_creator_id = P.person_id LEFT JOIN adds_to_wishlist AC
		ON AC.student_id='$person_id'
		WHERE C.course_id=AC.course_id";

		$courses_in_cart = array();
		$total_price = 0;

		$result = mysqli_query($link, $sql);

		if (!$result) {
			echo "There is no course found.";
			echo " " . $link -> error;
		} else {
			$count = mysqli_num_rows($result);

			if ($count > 0) {
				echo "<table class='table table-striped table-hover'>
				<thead>
				<th scope='col'>Course Name</th>
				<th scope='col'>Price</th>
				<th scope='col'>Rating</th>
				<th scope='col'>Instructor Name</th>
				<th scope='col'>Discount</th>
				<th scope='col'></th>
				</thead>
				<tbody>
				";

				while ($q_result = mysqli_fetch_array($result)) {
					echo "<tr class='clickable-row'>" . "<td>" . $q_result["course_name"] .
					"</td><td>" . number_format($q_result["price"], 2) . 
					"</td><td>" . $q_result["average_rating"] . 
					"</td><td>" . $q_result["name"] . " " . $q_result["surname"];

					if (is_null($q_result["percentage"]) || $q_result["percentage"] == "") {
						echo "</td><td> 0";
					} else {
						echo "</td><td>" . $q_result["percentage"];
					}

					echo "</td><td>";

					if ($wallet < $q_result["price"]) {
						echo "Not purchasable.";
					} else {
						echo "<a href='buy-course-from-wl.php?course_id=";
						echo $q_result["course_id"];
						echo "'>Buy Course</a>";
					}
					echo "</td></tr>";

					array_push($courses_in_cart, $q_result["course_id"]);
					$total_price += $q_result["price"];
				}
				echo "</tbody>";
				echo "</table>";

				if ($wallet < $total_price) {
					echo "<div class='d-grid gap-2 d-md-block'>
						  <button onclick='btnclick()' disabled class='btn btn-success float-right mr-4' type='button'>Buy All</button>
					</div>";
				} else {
					echo "<div class='d-grid gap-2 d-md-block'>
						  <button onclick='btnclick()' class='btn btn-success float-right mr-4' type='button'>Buy All</button>
					</div>";
				}
			} else {
				echo "<p>There is no course in your wishlist.</p>";
			}

			
			$_SESSION["courses_in_cart"] = $courses_in_cart;
			echo "<p>Wallet: " . $wallet . "</p>";
		}
		?>

	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
