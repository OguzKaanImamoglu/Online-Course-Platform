<?php 
    session_start();
    include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
    $cid = $_GET['cid'];
    $aid = $_GET['aid'];
    $index = $_GET['index'];
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
                <a class="nav-link" href="course-market.php">Course Market<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="my-courses.php">My Courses<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
            </li>
            <li class="nav-item">
            <?php
                echo "<a href='course-page.php?cid=$cid' class='nav-link'>Course Page</a>";
            ?>
            </li>
            <li class="nav-item">
            <?php
                echo "<a href='assignments.php?cid=$cid' class='nav-link'>Assignments</a>";
            ?>
            </li>
            <li class="nav-item">
            <?php
                echo "<a href='see-attempts.php?cid=$cid&aid=$aid&index=$index' class='nav-link'>Attempts</a>";
            ?>
            </li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
      			<li><a href="../logout.php">Logout</a></li>
    		</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
            <?php 
                
                echo '<h3 class="display-5 mb-4">Assignment ' . $index . ' Submission</h3>';
                //Find course name
                $sql = "SELECT course_name
                        FROM course
                        WHERE course_id = '$cid'";
                $result = mysqli_query($link, $sql);
                $data = $result->fetch_assoc();
	            $cname = $data['course_name'];
                echo '<p class="lead"> Course Name: ' . $cname . '</p>';
            ?>
			<hr class="my-4">
            <form action="make-submission.php" method="post">
			<div class="form-group">
            <?php 

                //Find course name
                $sql = "SELECT assignment_question
                        FROM assignment
                        WHERE assignment_id = '$aid'";
                $result = mysqli_query($link, $sql);
                $data = $result->fetch_assoc();
	            $question = $data['assignment_question'];
                echo '<label for="exampleFormControlTextarea1">Assignment Question: ' . $question . '</label>';
            ?>
            <textarea class="form-control" id="answer" name ="answer" rows="10"></textarea>
            </div>
            <?php
                echo "<input type='hidden' id='aid' name='aid' value='$aid'/>";
                echo "<input type='hidden' id='cid' name='cid' value='$cid'/>";
                echo "<input type='hidden' id='index' name='index' value='$index'/>";
            ?>
            <input style="float: right" value="Send Assignment Submission" name="submit" type="submit">
            </form>
			<br></br>
		</div>
	</div>
    
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
<style>
</style>
</html>