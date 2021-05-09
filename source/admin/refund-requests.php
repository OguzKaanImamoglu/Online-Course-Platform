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
					<a class="nav-link" href="#">Discounts</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<div class="jumbotron mt-4">
            <h3 class="display-5 mb-4">Refund Requests</h3>
			<hr class="my-4">
			<?php 

            //Display refund requests query
			$sql = "SELECT R.refund_id, R.reason, C.course_name, P.name, P.surname, R.reason, P2.name AS creator_name, P2.surname AS creator_surname, C.course_price
                    FROM refund R, refund_requests RR, course C, person P, person P2
                    WHERE R.is_assessed = 0 AND RR.refund_id = R.refund_id AND C.course_id = RR.course_id AND P.person_id = RR.student_id
                    AND P2.person_id = C.course_creator_id";

			$result = mysqli_query($link, $sql);

			if (!$result) {
				echo "There is no refund requests found.";
			} else {
                $count = mysqli_num_rows($result);
				if ($count > 0) {
					echo "<table class='table'>
						<thead>
                        <tr>
                        <th>Refund ID</th>
							<th>Student Name</th>
							<th>Course Name</th>
							<th>Details</th>
                        </tr>
						</thead>";

					while ($q_result = mysqli_fetch_array($result)) {

                        echo '<tbody><tr>';
						echo '<td>' . $q_result["refund_id"] . '</td>';
                        echo '<td>' . $q_result["name"] . " " . $q_result["surname"] . '</td>';
						echo '<td>' . $q_result["course_name"] . '</td>';
						
                        //Send hidden inputs to modal via button
                        echo '<td>' . "
                        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>

                            <input type='hidden' id='rid' name='rid' value='{$q_result["refund_id"]}' />
                            <input type='hidden' id='sname' name='sname' value='{$q_result["name"]} {$q_result["surname"]}' />
                            <input type='hidden' id='cname' name='cname' value='{$q_result["course_name"]}' />
                            <input type='hidden' id='creator-name' name='creator-name' value='{$q_result["creator_name"]} {$q_result["creator_surname"]}' />
                            <input type='hidden' id='price' name='price' value='{$q_result["course_price"]}' />
                            <input type='hidden' id='reason' name='reason' value='{$q_result["reason"]}' />                            

                            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#exampleModal' id='submit'>
                                See details
                            </button>
                        </form>" . '</td>';
						echo '</tr>';
                        echo '</tbody></table>';
					}
				} else {
					echo "There are no refund requests.";
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
                        <div class="modal-footer" id ="modal_footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $("#submit").click(function () {
            var rid = $("#rid").val();
            var str = "Request " + rid;


            var sname = $("#sname").val();
            var cname = $("#cname").val();
            var creatorname = $("#creator-name").val();
            var price = $("#price").val();
            var reason = $("#reason").val();
            var s = "Student Name: " + sname;
            var c = "Course Name: " + cname;
            var ccname = "Instructor Name: " + creatorname;
            var fee = "Fee: " + price;
            var reas = "Reason: " + reason;

            $("#exampleModalLabel").html(str);
            $("#modal_footer").html(
                "<a href='reject-refund.php?rid=" + rid + "' class='button-class'>Reject</a><a href='accept-refund.php?rid=" + rid + "' class='button-class'>Accept</a>"
            );
            $("#modal_body").html("<br>" + s + "</br><br>" + c + "</br><br>" + ccname + "</br><br>" + fee + "</br><br>" + reas + "</br><br>");
        });
    </script>
</body>
<style>.button-class {
        border: 2px solid;
        background-color: white;
        text-decoration: none;
    }</style>
</html>