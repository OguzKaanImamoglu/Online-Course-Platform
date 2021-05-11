<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$course_id = $_SESSION['course_id'];

$course_id = 4;

$sql = "SELECT course_name FROM course WHERE course_id = '$course_id'";

$result = mysqli_query($link,$sql);

$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$course_name = $row['course_name'];

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
                <a class="nav-link" href="../student/course-market.php">Course Market <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/my-courses.php">My Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/add-money.php">Add Money</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">My Questions</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="jumbotron mt-4">
        <h3 class="display-5 mb-4"><?php echo "$course_name"?> Questions</h3>
        <hr class="my-4">
        <?php

        //Display refund requests query
        $sql = "SELECT A.question_id, Q.question_text FROM asks A, question Q 
                WHERE A.question_id = Q.question_id AND A.course_id = '$course_id'";

        $result = mysqli_query($link, $sql);

        if (!$result) {
            echo "Error on dataset, try again later";
        } else {
            $count = mysqli_num_rows($result);
            if ($count > 0) {
                echo "<div class='container-fluid'>
  <table class='table table-condensed table-bordered' style='border-collapse:collapse;' data-toggle='table' data-pagination='true' data-search='true' data-show-pagination-switch='true'>";
                $i = 0;

                while ($q_result = mysqli_fetch_array($result)) {

                    $html = "<td colspan='12' class='hiddenRow'>
                            <div class='accordion-body collapse container-fluid' id='collapsedRow_$i'>";
                    $cid = $q_result['question_id'];

                    $sql = "SELECT ans.answer_text FROM answers ans WHERE ans.question_id = '$cid'";

                    $result2 = mysqli_query($link, $sql);

                    if(!$result2){
                        echo "Error on dataset, try again later";
                    }else{
                        $count = mysqli_num_rows($result2);
                        if($count == 0){
                            $html = $html . "No response for the question";
                        }else{
                            $q_result2 = mysqli_fetch_array($result2);
                            $html = $html . $q_result2['answer_text'];
                        }
                    }

                    $html = $html . "</div></td>";

                    echo "<tbody><tr data-toggle='collapse' data-target='#collapsedRow_$i' class='accordion-toggle'>";
                    echo '<td>' . $q_result['question_text'] . '</td>';

                    echo '<td>' .
"<a class='btn btn-primary' data-toggle='collapse' href='#collapsedRow_$i' role='button' aria-expanded='false' aria-controls='collapseExample'>Answer</a>" . '</td>';
                    $i++;
                    echo '</tr>';
                    echo $html;
                }

                echo '</tbody></table></div>';


            } else {
                echo "No question for this course.";
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

</body>
</html>
