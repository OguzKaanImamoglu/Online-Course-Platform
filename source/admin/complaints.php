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
        <?php 
            $sql = "SELECT * FROM complaint_view WHERE 
                C.complaint_id=SC.complaint_id AND P.person_id=SC.student_id AND
                SC.course_id=Co.course_id
            ";

            $result = mysqli_query($link, $sql);
            if (!$result) {
                echo $link->error;
            } else {
                $count = mysqli_num_rows($result);
                if ($count > 0) {
                    while ($q_result = mysqli_fetch_array($result)) {
                        $student_name = $q_result["name"] . " " . $q_result["surname"];
                        $complaint_date = $q_result["complaint_date"];
                        $complaint = $q_result["complaint_note"];
                        $course_name = $q_result["course_name"];

                        echo "
                            <div class='card mt-4 mb-4'>
                                <div class='card-body'>
                                <h5 class='card-title'>";
                        echo "Student: " . $student_name . " - Course: " . $course_name;
                        echo "<h6 class='card-subtitle mb-2 text-muted'>";
                        echo $complaint_date;
                        echo "<p class='card-text'>";
                        echo $complaint;
                        echo "</p></div></div>";
                    }
                } else {
                    echo "<h3 class='mt-4'>There are no complaints.</h3>";
                }
            }
         ?>
    </div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>