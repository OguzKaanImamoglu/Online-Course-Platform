<?php 
    session_start();
    include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
					<a class="nav-link" href="refund-requests.php">Refund Requests<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="discount-courses.php">Discounts</a>
				</li>
                <li class="nav-item">
					<a class="nav-link" href="pending-offers.php">Pending Offers</a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
      			<li><a href="../logout.php">Logout</a></li>
    		</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
            <h3 class="display-5 mb-4">Pending Discount Offers</h3>
			<hr class="my-4">
			<?php 

            //Display discount offers not yet approved by course creators
			$sql = "SELECT D.discount_id, D.start_date, D.end_date, D.percentage, C.course_price, C.course_name, P.name, P.surname
            FROM discount D, course C, person P
            WHERE C.course_id = D.discounted_course_id AND P.person_id = C.course_creator_id AND D.is_allowed = FALSE";

			$result = mysqli_query($link, $sql);

			if (!$result) {
				echo "There are no offerings found.";
			} else {
                $count = mysqli_num_rows($result);
				if ($count > 0) {
					echo "<table class='table'>
						<thead>
                        <tr>
                        <th>Discount ID</th>
							<th>Course Name</th>
							<th>Instructor Name</th>
							<th>Price</th>
							<th>Discount</th>
							<th>Discounted Price</th>
							<th>From</th>
							<th>Until</th>
                            <th>Cancel Discount</th>

                        </tr>
						</thead>";

					while ($q_result = mysqli_fetch_array($result)) {

                        echo '<tbody><tr>';
						echo '<td>' . $q_result["discount_id"] . '</td>';
                        echo '<td>' . $q_result["course_name"] . '</td>';
						echo '<td>' . $q_result["name"] . ' ' . $q_result["surname"] . '</td>';
						echo '<td>' . $q_result["course_price"] . '</td>';
						echo '<td>' . $q_result["percentage"] . '%' . '</td>';
						
						$discounted = (1-($q_result["percentage"])/100)*$q_result["course_price"];
						echo '<td>' . $discounted . '</td>';
						echo '<td>' . $q_result["start_date"] . '</td>';
						echo '<td>' . $q_result["end_date"] . '</td>';
                        echo "<td>" . "<a href='cancel-discount.php?did=" . $q_result["discount_id"] . "'>Cancel</a>";
					}

				} else {
					echo "<div style='float:left; width:1000px'>There are no offerings found.</div>";
				}
			}
			?>
			<br></br>
		</div>
	</div>
    
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>