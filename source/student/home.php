<?php 
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

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
					<a class="nav-link" href="course-market.php">Course Market <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="my-courses.php">My Courses</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="add-money.php">Add Money</a>
				</li>
                <li class="nav-item">
                    <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
                </li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
      			<li><a href="../logout.php">Logout</a></li>
    		</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
			<h1 class="display-4">Welcome <?php echo "$name $surname"?></h1>
			<p class="lead">You can see your wishlist, cart, and wallet below.</p>
			<hr class="my-4">
			<a href="">
				<p class="lead">
					<i class="fa fa-list fa-lg" aria-hidden="true"></i>
					My Wishlist
				</p>
			</a>
			<a href="">
				<p class="lead">
					<i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>
					My Cart
				</p>
			</a>
			<p class="lead">
				<i class="fa fa-usd fa-lg" aria-hidden="true"></i>
				<?php echo "$wallet" ?>
				<a class="btn btn-success btn-md" href="add-money.php" role="button">Add Money</a>
			</p>
			<p class="lead mt-4">
				<a class="btn btn-success btn-lg" href="#" role="button">Course Market</a>
				<a class="btn btn-success btn-lg" href="#" role="button">My Courses</a>
			</p>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
