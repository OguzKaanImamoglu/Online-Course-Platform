<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$course_id = $_SESSION["course_id"];

$sql1 =  "SELECT course_name FROM course WHERE course_id = $course_id ";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);

$cname = $row1['course_name'];

$percentage = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
            </ul>
        </div>
    </nav>


    <div class="row">
        <div class="col-md-3" style="padding-left: 70px; margin-top: 50px;">
            <h3 class="display-5 mb-4">Announcements</h3>
            <?php
            $sql1 = "SELECT date, text FROM announcement WHERE course_id = $course_id  ORDER BY date ";
            $result1 = mysqli_query($link, $sql1);

            if (!$result1) {
                echo "There is no announcements found.";
                echo " " . $link -> error;
            } else {
                $count1 = mysqli_num_rows($result1);

                if ($count1 > 0) {
                    echo /** @lang text */
                    "<table class='table'>
                    <thead>
                    <th scope='col'>Date</th>
                    <th scope='col'>Text</th>
                    </thead>
                    <tbody>
                    ";

                    while ($q_result1 = mysqli_fetch_array($result1)) {
                        echo "<tr><th scope='row'>" . $q_result1["date"] .
                        "</th><td style='word-wrap: break-word; min-width: 10px; max-width: 150px;'> <p>" . $q_result1["text"] ."bmvklfdmklbvdlkmfvblnkmdfvbnmkldfvbnmlkdfnmlvkbnldfjkvbfdsfasdasdfasdfasdfasdfasdf". "</p>";

                        echo "</td></tr>";

                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "There is no announcement found.";
                }
            }

            ?>
        </div>
        <div class="col-md-7" style="margin-top: 50px; padding-left: 25px; padding-right: 25px;">
            <h3 class="display-4 mt-4 text-center">
                <?php echo $cname ?>
            </h3>
            <div class="jumbotron mt-4">
                <h3 class="display-5 mb-4">Lectures</h3>
                <hr class="my-4">
                <?php
                $sql = "SELECT lecture_id, lecture_name, duration, description FROM lecture WHERE course_id = $course_id ";
                $result = mysqli_query($link, $sql);

                if (!$result) {
                    echo "There is no lecture found.";
                    echo " " . $link -> error;
                } else {
                    $count = mysqli_num_rows($result);

                    if ($count > 0) {
                        echo /** @lang text */
                        "<table class='table'>
                        <thead>
                        <th scope='col'>Lecture Id</th>
                        <th scope='col'>Lecture Name</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Duration</th>
                        </thead>
                        <tbody>
                        ";

                        while ($q_result = mysqli_fetch_array($result)) {
                            echo "<tr><th scope='row'>" . $q_result["lecture_id"] .
                            "</th><td>" . $q_result["lecture_name"] .
                            "</th><td>" . $q_result["description"] .
                            "</td><td>" . $q_result["duration"];

                            echo /** @lang text */
                            "<td>
                            <form action='watch-lecture.php' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>
                            <input type='hidden' id='cid' name='lid' value='" . $q_result["lecture_id"] . "' />
                            <button onclick=\"location.href=watch-lecture.php'\" class=\"mt-2 text-center btn btn-success\" >Open Lecture</button>
                            </form></td>";

                            echo "</td></tr>";

                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "There is no course found.";
                    }

                    $sql2 = "SELECT  course_id, student_id, COUNT(lecture_id) as lecture_count
                        FROM    progresses
                        WHERE   student_id = '$person_id' AND course_id='$course_id'
                        GROUP BY course_id, student_id";

                    $result2 = mysqli_query($link,$sql2);

                    if (!$result2) {
                        echo "There is no course found.";
                        echo " " . $link -> error;
                        die();
                    } else {
                        $row = mysqli_fetch_array($result2,MYSQLI_ASSOC);

                        if (is_null($row)) {
                            echo "<div class='text-center'>";
                            echo "<p>Progress</p>";
                            echo "<progress id='file' value='0' max='100'></progress>";
                            echo "</div>";

                        } elseif (is_null($row["lecture_count"]) || $row["lecture_count"] == "" || $row["lecture_count"] == 0) {
                            echo "<div class='text-center'>";
                            echo "<p>Progress</p>";
                            echo "<progress id='file' value='0' max='100'></progress>";
                            echo "</div>";

                        } else {
                            $watched_lecture_count = $row["lecture_count"];

                            $sql3 = "SELECT course_id, COUNT(lecture_id) as total_lecture_count
                                    FROM  lecture
                                    WHERE course_id='$course_id'
                                    GROUP BY    course_id";

                            $result3 = mysqli_query($link, $sql3);

                            if (!$result3) {
                                echo "Failed.";;
                                echo " " . $link -> error;;
                                die();
                            }

                            $total_row = mysqli_fetch_array($result3, MYSQLI_ASSOC);

                            if (!is_null($total_row)) {
                                $total_lecture_count = $total_row["total_lecture_count"];
                            }

                            $progress_percentage = $watched_lecture_count * 100 / $total_lecture_count;
                            $percentage = $progress_percentage;

                            echo "<div class='text-center'>";
                            echo "<p>Progress</p>";
                            echo "<progress id='file' value='" . $progress_percentage . "' max='100'></progress>";
                            echo "</div>";
                        }
                    }
                }
                ?>

                <br></br>

                <?php 
                    if ($percentage != 100) {
                        echo  "<button type='button' disabled class='btn btn-secondary' data-dismiss='modal'>Finish the course to give feedback</button>";
                        echo "<button type='submit' disabled name='send-request' class='btn btn-secondary float-right'>Finish the course to get Certificate</button>";
                    } else {
                        echo  "<button type='button' class='btn btn-success' data-dismiss='modal'>Give Feedback</button>";
                        echo "<button type='submit' onclick=\"location.href='get-certificate.php'\" name='send-request' class='btn btn-success float-right'>Get Certificate</button>";
                    }
                 ?>
            </div>
        </div>

        <div class="col-md-2" style="margin-top: 50px;">
            <p>
                <?php 
                $sql = "SELECT * FROM refund_requests WHERE student_id='$person_id' AND course_id='$course_id'";

                if (!$result = mysqli_query($link, $sql)) {
                    echo $link->error;
                    die();
                } else {
                    $count = mysqli_num_rows($result);

                    if (!$count) {
                        echo "<button type='button' class='btn btn-success btn-md' data-toggle='modal' data-target='#exampleModal'>
                        Request Refund
                        </button>";
                    } else {
                       echo "<button type='button' disabled class='btn btn-success btn-md' data-toggle='modal' data-target='#exampleModal'>
                       Refund Already Requested
                       </button>";
                   }
               }
               ?>
           </p>
           <!-- Modal -->
           <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Request Refund for <?php echo $cname; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>

              <?php 
              if (isset($_POST["send-request"])) {
                $reason = $_POST['requestReason'];
                $sql = "INSERT INTO refund(reason) VALUES('$reason')";

                if (!mysqli_query($link, $sql)) {
                    echo $link -> error;
                    die();
                }

                $latest_id =  mysqli_insert_id($link);

                $sql = "INSERT INTO refund_requests VALUES('$latest_id', '$person_id', '$course_id')";

                if (!mysqli_query($link, $sql)) {
                    echo $link -> error;
                    die();
                } 
            }
            ?>


            <form method="post">
                <div class="modal-body">
                    Why are you requesting a refund?

                    <div class="form-group mt-4">
                        <textarea class="form-control" name="requestReason" rows="7" placeholder="Enter reason..." minlength="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="send-request" class="btn btn-primary">Send Request</button>
                </div>
            </form>


        </div>


    </div>

</div>


<p>
    <a class="btn btn-success btn-md" href="../Q&A/q&aforcourse.php" role="button">Q&A Page</a>
</p>
<p>
    <a class="btn btn-success btn-md" href="assignments.php" role="button">Assignments</a>
</p>
</div>

</div>        


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src='http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.js'></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
