<?php 
    session_start();
	include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
	$name = $_SESSION['name'];
	$surname = $_SESSION['surname'];
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
                <li class="nav-item">
                    <a class="nav-link" href="complaints.php">Complaints</a>
                </li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
      			<li><a href="../logout.php">Logout</a></li>
    		</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
			<h1 class="display-4">Welcome Admin <?php echo "$name $surname"?></h1>
			<p class="lead">You can check refund requests, offer discounts, see complaints and stats below.</p>
			
			<p class="lead mt-4">
				<a class="btn btn-success btn-lg" href="refund-requests.php" role="button">Refund Requests</a>
				<a class="btn btn-success btn-lg" href="discount-courses.php" role="button">Discounts</a>
                <a class="btn btn-success btn-lg" href="stats.php" role="button">Stats</a>
                <a class="btn btn-danger btn-lg" href="complaints.php" role="button">Complaints</a>
			</p>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
