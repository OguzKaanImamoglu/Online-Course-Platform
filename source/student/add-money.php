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

if (isset($_POST['save'])) {
	$quantity = $_POST['quantity'];
	$sql = "UPDATE student SET wallet = wallet + '$quantity' WHERE student_id='$person_id'";	

	$result = mysqli_query($link,$sql);

	header("Location: home.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>  
	<div class="container">
		<div class="jumbotron mt-4">
			<form action="" method="post">
				<h1 class="display-4">Welcome <?php echo "$name $surname"?></h1>
				<p class="lead">You can add money to your wallet below.</p>
				<hr class="my-4">
				<p class="lead">
					<i class="fa fa-usd fa-lg" aria-hidden="true"></i>
					<?php echo "Current Money: " . "$wallet" ?>
				</p>
				<label for="quantity">Quantity (between 1 and 250):</label>
				<input type="number" id="quantity" name="quantity" min="1" max="250" value="1">
				<p>
                    <button type="submit" name="save" class="btn btn-success btn-md mt-4">Add Money to Your Wallet</button>
				</p>
			</form>	
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>