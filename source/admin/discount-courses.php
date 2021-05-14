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
                    <a class="nav-link" href="stats.php">Stats</a>
                </li>

			</ul>
			<ul class="nav navbar-nav navbar-right">
      			<li><a href="../logout.php">Logout</a></li>
    		</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
            <h3 class="display-5 mb-4">Courses with Discount</h3>
			<hr class="my-4">
			<?php 

            //Display applied discounts to courses
			$sql = "SELECT C.course_id, C.course_name, C.course_price, P.name, P.surname, D2.percentage, D2.start_date, D2.end_date
					FROM course C, discount D2, person P
					WHERE C.course_creator_id = P.person_id AND C.course_id IN (SELECT D.discounted_course_id
									  		  FROM discount D
											  WHERE D.is_allowed = 1 AND D.end_date > CURRENT_DATE)";

			$result = mysqli_query($link, $sql);

			if (!$result) {
				echo "There are no discounted courses found.";
			} else {
                $count = mysqli_num_rows($result);
				if ($count > 0) {
					echo "<table class='table'>
						<thead>
                        <tr>
                        <th>Course ID</th>
							<th>Course Name</th>
							<th>Instructor Name</th>
							<th>Price</th>
							<th>Discount</th>
							<th>Discounted Price</th>
							<th>From</th>
							<th>Until</th>
                        </tr>
						</thead>";

					while ($q_result = mysqli_fetch_array($result)) {

                        echo '<tbody><tr>';
						echo '<td>' . $q_result["course_id"] . '</td>';
                        echo '<td>' . $q_result["course_name"] . '</td>';
						echo '<td>' . $q_result["name"] . ' ' . $q_result["surname"] . '</td>';
						echo '<td>' . $q_result["course_price"] . '</td>';
						echo '<td>' . $q_result["percentage"] . '%' . '</td>';
						
						$discounted = (1-($q_result["percentage"])/100)*$q_result["course_price"];
						echo '<td>' . $discounted . '</td>';
						echo '<td>' . $q_result["start_date"] . '</td>';
						echo '<td>' . $q_result["end_date"] . '</td>';
					}

				} else {
					echo "<div style='float:left; width:1000px'>There are no discounted courses.</div>";
				}
			}
			echo '<tfoot align = "center"><tr><td colspan="8"><button type="button" button style = "float; margin:10px; margin-top:20px" 
				class="btn btn-success" data-toggle="modal" data-target="#exampleModal" id="submit">
				Make a New Offer</button><a href="pending-offers.php" class="btn btn-success" style = "float; margin:10px; margin-top:20px">
				Pending Offers</a></td></tr></tfoot>';
			?>
			<br></br>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">New Offer</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form action="send-offer.php" method="post">
		<div class="modal-body">
				<div style="width: 100px; float:left; height:30px; margin:5px">Select Course: </div>
				<div style= "width: 250px; float:left; height:30px; margin:5px">
				<datalist id="courses">
				<?php
					$sql = "SELECT course_id, course_name
							FROM course";

					$result = mysqli_query($link, $sql);

					while ($q_result = mysqli_fetch_array($result)) {
						echo '<option value=\''. $q_result["course_id"] . ' - ' . $q_result["course_name"] . '\'>';
					}
				?>
				</datalist>
				<input type="text" name="course" list="courses"/>
				</div>	
				<div style="width: 140px; float:left; height:40px; margin:5px">Specify Percentage: </div>
				<div style="width: 250px; float:left; height:40px; margin:5px"><input type="number" name ="discount" value="50" min="0" max="100" step="5"/></div>
				<label style="width: 50px; float:left; height:30px; margin:5px" for="start-date">From: </label>
				<div style="width: 350px; float:left; height:30px; margin:5px"><input type="date" id="start-date" name="start-date"></div>
				<label style="width: 50px; float:left; height:30px; margin:5px" for="end-date">Until: </label>
				<div style="width: 140px; float:left; height:30px; margin:5px"><input type="date" id="end-date" name="end-date"></div>
		</div>
		<div style="float:right; clear:right" class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<input value="Send Offer" name="submit" type="submit">
		</div>
		</form>
		</div>
	</div>
	</div>
    
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>