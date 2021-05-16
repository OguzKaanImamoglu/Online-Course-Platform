<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$course_ids = "#";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../student/home.php">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../student/course-market.php">Course Market</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Notifications.php">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/my-courses.php">My Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../student/myCertificates.php">My Certificates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
            </li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron mt-4">
        <h3 class="display-5 mb-4">My Courses</h3>
        <hr class="my-4">
        <?php
        $sql = "SELECT co.course_id, co.course_name, co.course_creator_id, p.name, p.surname FROM course co, enrolls e, person p WHERE co.course_id = e. course_id 
                AND p.person_id = co.course_creator_id AND e.student_id='$person_id'";
        //$sql = "SELECT * FROM course";
        $result = mysqli_query($link, $sql);



        if (!$result) {
            echo "There is no course found.";
            echo " " . $link -> error;
        } else {
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                echo /** @lang text */
                "<table class='table'>
							<thead>
						
							<th scope='col'>Course Name</th>
							<th scope='col'>Instructor Name</th>
                            <th scope='col'>Progress</th>
                            <th scope='col'></th>
							</thead>
							<tbody>
							";

                while ($q_result = mysqli_fetch_array($result)) {
                    echo "<tr><td>" . $q_result["course_name"] .
                        "</td><td>" . $q_result["name"]. " " . $q_result["surname"];


                    $student_id = $person_id;
                    $course_id = $q_result["course_id"];

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
                            echo "<td>0";
                        } elseif (is_null($row["lecture_count"]) || $row["lecture_count"] == "" || $row["lecture_count"] == 0) {
                            echo "<td>0";
                        } else {
                            $watched_lecture_count = $row["lecture_count"];

                            $sql3 = "SELECT course_id, COUNT(lecture_id) as total_lecture_count
                                    FROM  lecture
                                    WHERE course_id='$course_id'
                                    GROUP BY    course_id";

                            $result3 = mysqli_query($link, $sql3);

                            if (!$result3) {
                                echo "Failed.";;
                                echo " " . $link->error;;
                                die();
                            }

                            $total_row = mysqli_fetch_array($result3, MYSQLI_ASSOC);

                            if (!is_null($total_row)) {
                                $total_lecture_count = $total_row["total_lecture_count"];


                                //echo $total_lecture_count . " " . $watched_lecture_count;

                                $progress_percentage = $watched_lecture_count * 100 / $total_lecture_count;

                                echo "<td>" . number_format($progress_percentage) . "%";
                            }
                        }
                    }
                    $search = $q_result["course_id"];
                    if($course_ids == "#")     $course_ids = $course_ids . $search;
                    else        $course_ids = $course_ids. ",#" . $search;

                    echo "<td>
                        <form action='' method='post' id='formHiddenInputValue' name='formHiddenInputValue'>
                            <button type='button' class='btn btn-success' data-toggle='modal' id='" . $q_result["course_id"] . "' name='" . $q_result["course_id"] . "' value='" . $q_result["course_id"] . "'>Course Page</button>
                                                </form></td>";
                    echo "</td></tr>";

                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "There is no course found.";
            }
        }
        ?>
        <br></br>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>


<script>
    var total_id = "<?php Print( $course_ids); ?>";

    $(total_id).click(function(e) {
        $id = $(this).val();
        //alert(document.getElementById($text).value);
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "saveCourseid.php",
            data: {
                course_id: $id
            },
            success: function(result) {
                //alert('Approved');
                window.location.replace("course-page.php");
            },
            error: function(result) {
                alert("Open course page error");
            }
        });
    });

</script>

</html>