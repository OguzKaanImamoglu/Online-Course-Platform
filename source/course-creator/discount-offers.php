<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];


$accepted_id = "#";
$rejected_id = "#";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head><body>
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
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h3 class="display-4 text-center mt-5">Discount Offers for Your Courses</h3>
    <div class="jumbotron mt-4">
        <h3 class="display-5 mb-4">Discount Offers</h3>
        <hr class="my-4">
        <?php

        //Display refund requests query
        $sql = "SELECT D.discount_id, D.start_date, D.end_date, D.percentage, D.is_allowed, C.course_id, C.course_name, C.course_price
                FROM discount D, course C
                WHERE D.allower_course_creator_id = '$person_id' AND D.discounted_course_id = C.course_id";

        $result = mysqli_query($link, $sql);

        if (!$result) {
            echo "There is no discount offers found.";
        } else {
            $count = mysqli_num_rows($result);
            if ($count > 0) {
                echo "<table class='table'>
						<thead>
                        <tr>
                            <th>Course ID</th>
							<th>Course Name</th>
							<th>Current Price</th>
							<th>Percentage</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Approve Status</th>							
                        </tr>
						</thead>";
                echo '<tbody>';
                while ($q_result = mysqli_fetch_array($result)) {
                    echo '<tr>';
                    echo '<td>' . $q_result["course_id"] . '</td>';
                    echo '<td>' . $q_result["course_name"]. '</td>';
                    echo '<td>' . $q_result["course_price"]. '</td>';
                    echo '<td>' . $q_result["percentage"]. '</td>';
                    echo '<td>' . $q_result["start_date"] . '</td>';
                    echo '<td>' . $q_result["end_date"] . '</td>';
                    if($q_result["is_allowed"] == 0)    echo '<td>Not approved</td>';
                    else    echo'<td>Approved</td>';
                    $search = $q_result['discount_id'];


                    //Send hidden inputs to modal via button
                    if($q_result["is_allowed"] == 0){//Blue button
                        if($accepted_id == "#")     $accepted_id = $accepted_id . $search;
                        else        $accepted_id = $accepted_id . ",#" . $search;

                        echo '<td>' . "
                        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>
<button type='button' class='btn btn-success' data-toggle='modal' id = '$search' value='$search'>Accept</button>

                        </form>" . '</td>';
                    }
                    else{//Red button
                        if($rejected_id == "#")     $rejected_id = $rejected_id . $search;
                        else        $rejected_id = $rejected_id . ",#" . $search;

                        echo '<td>' . "
                        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>
<button type='button' class='btn btn-success' data-toggle='modal' id = '$search' value='$search'>Reject</button>

                        </form>" . '</td>';

                    }

                    echo '</tr>';
                }
                echo '</tbody></table>';

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>

<script>
    var total_id = "<?php Print( $accepted_id); ?>";
    var change_id = "<?php Print($rejected_id);?>";

    $(total_id).click(function(e) {
        $id = $(this).val();
        //alert(document.getElementById($text).value);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "acceptDiscount.php",
            data: {
                discount_id: $id
            },
            success: function(result) {
                //alert('Approved');
                location.reload();
            },
            error: function(result) {
                alert("Accept error");
            }
        });
    });

    $(change_id).click(function(e){

        $changed = $(this).val();
        //alert($(this).val());
        $.ajax({
            type:"POST",
            url:"rejectDiscount.php",
            data:{discount_id: $changed},

            success: function(result){
                //alert('Rejected');
                location.reload();
            },
            error: function(result) {
                alert("Reject Error");
            }
        });
    });

</script>
</body>
<style>.button-class {
        border: 2px solid;
        background-color: white;
        text-decoration: none;
    }</style>
</html>
