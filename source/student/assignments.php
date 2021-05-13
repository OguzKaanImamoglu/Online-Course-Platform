<?php 
    session_start();
    include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];
    $cid = $_GET['cid'];
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
			</ul>
			<ul class="nav navbar-nav navbar-right">
      			<li><a href="../logout.php">Logout</a></li>
    		</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
            <h3 class="display-5 mb-4">Assignments Status</h3>
			<hr class="my-4">
			<?php 

            //Display assignments of the course for student
			$sql = "SELECT A.assignment_id, A.assignment_threshold, S.attempts
                    FROM (SELECT assignment_id, student_id, COUNT(submission_time) AS attempts
                    FROM submitted_assignment
                    GROUP BY assignment_id, student_id
                    HAVING student_id = '$person_id') AS S RIGHT OUTER JOIN assignment A ON A.assignment_id = S.assignment_id
                    WHERE 	A.course_id = '$cid'";
			$result = mysqli_query($link, $sql);

			if (!$result) {
				echo "There are no assignments found for the course.";
			} else {
                $count = mysqli_num_rows($result);
				if ($count > 0) {
					echo "<table class='table'>
						<thead>
                        <tr>
                        <th>Assignment ID</th>
							<th>Assignment</th>
							<th>Threshold</th>
							<th>Status</th>
							<th>Attempt Count</th>
                            <th>See Attempts</th>
                        </tr>
						</thead>";
                    
                    $iter = 1;
					while ($q_result = mysqli_fetch_array($result)) {

                        echo '<tbody><tr>';
						echo '<td>' . $q_result["assignment_id"] . '</td>';
                        echo '<td>' . 'Assignment ' . $iter . '</td>';
						echo '<td>' . $q_result["assignment_threshold"] . '</td>';

                        $aid = $q_result["assignment_id"];
                        $sql2 = "SELECT	*
                                FROM submitted_assignment S, assignment A
                                WHERE S.assignment_id = '$aid' AND A.assignment_id = S.assignment_id AND S.student_id = '$person_id' 
                                AND S.grade >= A.assignment_threshold AND S.is_graded = TRUE";
                        $result2 = mysqli_query($link, $sql2);
                        $count2 = mysqli_num_rows($result2);

                        if ($count2 > 0){
                            $msg = "Successful";
                        } else {
                            $msg = "Not successful";
                        }
                        echo '<td>'. $msg . '</td>';

                        if ($q_result["attempts"]==NULL){$attempts = 0;}
                        else {$attempts = $q_result["attempts"];}
                        echo '<td>' . $attempts . '</td>';
                        if($attempts == 0){
                            echo "<td>" . "<a class = 'disabled' href='see-attempts.php?aid=" . $q_result["assignment_id"] . "'>See attempts</a>";
                        } else {
                            echo "<td>" . "<a href='see-attempts.php?aid=" . $q_result["assignment_id"] . "'>See attempts</a>";
                        }
                        
                        $iter = $iter + 1;
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
<style>
    a.disabled{
        pointer-events: none;
        color: gray;
    }
</style>
</html>