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
                    <a class="nav-link" href="Notifications.php">Notifications</a>
                </li>
            <li class="nav-item">
                <a class="nav-link" href="my-courses.php">Your Courses<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">Your Questions</a>
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

            echo '<h3 class="display-5 mb-4">Attempts for Assignment ' . $index .  '</h3>';
            echo '<hr class="my-4">';
            //Display attempts of the assignment for student
			$sql = "SELECT submission_time, grade, is_graded
                    FROM submitted_assignment
                    WHERE student_id = '$person_id' AND assignment_id = '$aid'";
			$result = mysqli_query($link, $sql);

            $sql2 = "SELECT assignment_threshold
                    FROM assignment
                    WHERE assignment_id = '$aid'";
			$result2 = mysqli_query($link, $sql2);
            $data = $result2->fetch_assoc();
            $threshold = $data['assignment_threshold'];
            echo "<div>Threshold: " . $threshold . "</div>";

            $indicator = FALSE;
            $processind = FALSE;

			if (!$result) {
				echo "<div style='float:left; width:1000px'>There are no attempts found for the assignment.</div>";
			} else {
                $count = mysqli_num_rows($result);
				if ($count > 0) {
					echo "<table class='table'>
						<thead>
                        <tr>
							<th>Attempt</th>
							<th>Grade</th>
							<th>Status</th>
                            <th>Submission Time</th>
                        </tr>
						</thead>";
                    
                    $iter = 1;
					while ($q_result = mysqli_fetch_array($result)) {

                        echo '<tbody><tr>';
						echo '<td>' . $iter . '</td>';
                        echo '<td>' . $q_result["grade"] . '</td>';

                        if($q_result["grade"] >= $threshold && $q_result["is_graded"]){
                            $msg = "Successful";
                            $indicator = TRUE;
                        } else if ($q_result["grade"] < $threshold && $q_result["is_graded"]){
                            $msg = "Not successful";
                        } else if($q_result["is_graded"] == FALSE){
                            $msg = "Not graded";
                            $processind = TRUE;
                        }

                        echo '<td>'. $msg . '</td>';
                        echo '<td>' . $q_result["submission_time"] . '</td>';

                        $iter = $iter + 1;
					}
				} else {
					echo "<div style='float:left; width:1000px'>There are no attempts found for the assignment.</div>";
				}
			}
            if($indicator == FALSE && $processind == FALSE){
                echo "<div style='float:left; width:1000px; margin-left: auto; margin-right: auto; padding-bottom:20px'>You have not yet passed the assignment.</div>";
                echo '<tfoot align = "center"><tr><td colspan ="4">
                <center><a style = "float; margin:100px" href="submit-asgn.php?cid=' . $cid . '&aid=' . $aid . '&index=' . $index .'" class="button-class">Make Submission</a></center>
                </td></tr></tfoot>';
            } else if ($indicator == TRUE && $processind == FALSE) {
                echo "You have passed the assignment.";
                echo '<tfoot align = "center"><tr><td colspan="4">
                <a style = "float; margin:10px; margin-top:20px" href="submit-asgn.php?cid=' . $cid . '&aid=' . $aid . '&index=' . $index .'" class="disabled">Make Submission</a>
                </td></tr></tfoot>';
            } else if ($indicator == FALSE && $processind == TRUE) {
                echo "Please wait for instructor for grading.";
                echo '<tfoot align = "center"><tr><td colspan="4">
                <a style = "float; margin:10px; margin-top:20px" href="submit-asgn.php?cid=' . $cid . '&aid=' . $aid . '&index=' . $index .'" class="disabled">Make Submission</a>
                </td></tr></tfoot>';
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
        border: 2px solid;
        background-color: gray;
        text-decoration: none;
        pointer-events: none;
        color: white;
        margin-top: 20px;
        padding-left: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
        display: inline;
        padding-right: 9px;
        clear: both;
    }
    .button-class {
        border: 2px solid;
        background-color: green;
        text-decoration: none;
        color: white;
        margin-top: 20px;
        padding-left: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
        display: inline;
        padding-right: 9px;
        clear: both;
    }
</style>
</html>