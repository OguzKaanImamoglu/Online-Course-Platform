<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

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
                <a class="nav-link" href="my-courses.php">My Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add-money.php">Add Money</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Q&A/myQuestions.php">My Questions</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
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
							<th scope='col'>Course Id</th>
							<th scope='col'>Course Name</th>
							<th scope='col'>Instructor Name</th>
                            <th scope='col'>Progress</th>
                            <th scope='col'></th>
							</thead>
							<tbody>
							";

                while ($q_result = mysqli_fetch_array($result)) {
                    echo "<tr><th scope='row'>" . $q_result["course_id"] .
                        "</th><td>" . $q_result["course_name"] .
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
                                echo " " . $link -> error;;
                                die();
                            }

                            $total_row = mysqli_fetch_array($result3, MYSQLI_ASSOC);

                            if (!is_null($total_row)) {
                                $total_lecture_count = $total_row["total_lecture_count"];
                            }

                            echo $total_lecture_count . " " . $watched_lecture_count;

                            $progress_percentage = $watched_lecture_count * 100 / $total_lecture_count;

                            echo "<td>" . number_format($progress_percentage) . "%";
                        }
                    }
                    echo /** @lang text */
                        "<td>
                            <a href='course-page.php?cid=" . $q_result["course_id"] . 
                            "'class='mt-2 text-center btn btn-success'>Course Page</a></td>";
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
</html>

