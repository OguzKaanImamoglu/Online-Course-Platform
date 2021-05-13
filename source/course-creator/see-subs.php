<?php 
    session_start();
    include('../sign-up/database.php');

	$person_id = $_SESSION['person_id'];

    //Get assignment id
    $aid = $_GET['aid'];
    $cid = $_GET['cid'];
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
					<a class="nav-link" href="discount-offers.php">Discount Offers<span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
					<a class="nav-link" href="publish-course.php">Publish New Course</a>
			</li>
            <li class="nav-item">
            <?php
                echo "<a href='course-page.php?course_id=$cid' class='nav-link'>Course Page</a>";
            ?>
            </li>
            <li class="nav-item">
            <?php
                echo "<a href='assignments.php?cid=$cid' class='nav-link'>Assignments</a>";
            ?>
            </li>
            <li class="nav-item">
            <?php
                echo "<a href='see-subs.php?cid=$cid&aid=$aid&index=$index' class='nav-link'>Ungraded Assignments</a>";
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
                $sql = "SELECT course_name
                        FROM course
                        WHERE course_id = '$cid'";
                $result = mysqli_query($link, $sql);
                $data = $result->fetch_assoc();
	            $course_name = $data['course_name'];
                echo '<h3 class="display-5 mb-4">Ungraded Assignment Submissions for Assignment ' . $index . '</h3>';
            ?>
			<hr class="my-4">
			<?php 

            //Display assignments of the course for student
			$sql = "SELECT assignment_threshold
                    FROM assignment
                    WHERE assignment_id = '$aid'";
			$result = mysqli_query($link, $sql);
            $data = $result->fetch_assoc();
            $threshold = $data['assignment_threshold'];
            echo "<div>Threshold: " . $threshold . "</div>";

            $sql = "SELECT G.student_id, P.name, P.surname, G.submission_time, G.assignment_answer, A.assignment_question
                    FROM submitted_assignment G, person P, assignment A
                    WHERE A.assignment_id = G.assignment_id AND G.is_graded = FALSE AND G.assignment_id = '$aid' AND P.person_id = G.student_id";
			$result = mysqli_query($link, $sql);

			if (!$result) {
				echo "There are no ungraded submissions.";
			} else {
                $count = mysqli_num_rows($result);
				if ($count > 0) {
					echo "<table class='table'>
						<thead>
                        <tr>
                        <th>Student ID</th>
							<th>Student Name</th>
							<th>Submission Time</th>
							<th>Submissions</th>
                        </tr>
						</thead>";

					while ($q_result = mysqli_fetch_array($result)) {

                        echo '<tbody><tr>';
						echo '<td>' . $q_result["student_id"] . '</td>';
                        echo '<td>' . $q_result["name"] . " " . $q_result["surname"] . '</td>';
						echo '<td>' . $q_result["submission_time"] . '</td>';
                        
                        //Send hidden inputs to modal via button
                        echo '<td>' . "
                        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>

                            <input type='hidden' id='aid' name='aid' value='{$aid}' />
                            <input type='hidden' id='sid' name='sid' value='{$q_result["student_id"]}' />
                            <input type='hidden' id='time' name='time' value='{$q_result["submission_time"]}' />
                            <input type='hidden' id='index' name='index' value='{$index}' />
                            <input type='hidden' id='cid' name='cid' value='{$cid}' />
                            <input type='hidden' id='question' name='question' value='{$q_result["assignment_question"]}' />  
                            <input type='hidden' id='answer' name='answer' value='{$q_result["assignment_answer"]}' />                       

                            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' id='submit'>
                                See submission details
                            </button>
                        </form>" . '</td>';
						echo '</tr>';
                        echo '</tbody></table>';
					}

				} else {
					echo "<div style='float:left; width:1000px'>There are no ungraded submissions.</div>";
				}
			}
			?>
			<br></br>
		</div>
	</div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" 
            tabindex="-1" 
            aria-labelledby="exampleModalLabel" 
            aria-hidden="true">
              
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" 
                            id="exampleModalLabel">
                        </h5>
                          
                        <button type="button" 
                            class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                            <span aria-hidden="true">
                                ×
                            </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 id="modal_body"></h6>
                    </div>
                </div>
            </div>
        </div>
    
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $("#submit").click(function () {
            var index = $("#index").val();
            var str = "Submission for Assignment " + index;


            var sid = $("#sid").val();
            var aid = $("#aid").val();
            var cid = $("#cid").val();
            var time = $("#time").val();
            var question = $("#question").val();
            var answer = $("#answer").val();
            
            var s = "Assignment Question: " + question;
            var c = "Answer: " + answer;

            $("#exampleModalLabel").html(str);
            $("#modal_body").html("<br>" + s + "</br><br>" + c + "</br><br>" 
            + "Enter Grade: " + "<form action='submit-grade.php' method='post'>" +
            "<input type='number' name ='grade_awarded' id='grade_awarded' value='50' min='0' max='100' step='1'/>" + 
            "<input type='hidden' id='aid' name='aid' value='"+ aid + "' />" + 
            "<input type='hidden' id='index' name='index' value='"+ index + "' />" +
            "<input type='hidden' id='sid' name='sid' value='"+ sid + "' />" +
            "<input type='hidden' id='cid' name='cid' value='"+ cid + "' />" +
            "<input type='hidden' id='time' name='time' value='"+ time + "' />" +
            "<input style='margin:10px' value='Send Grade' name='submit' type='submit'></form>");
        });
    </script>

</body>
<style>
</style>
</html>