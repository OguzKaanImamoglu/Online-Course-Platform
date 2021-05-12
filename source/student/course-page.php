<?php
session_start();
include('../sign-up/database.php');

$person_id = $_SESSION['person_id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];

$cid = $_POST['cid'];



$sql1 =  "SELECT course_name FROM course WHERE course_id = $cid ";
$result1 = mysqli_query($link, $sql1);
$row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
$cname = $row1['course_name'];

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
        </ul>
    </div>
</nav>

<div class="container">
    <button onclick="location.href='request-refund.php'" class="mt-2 text-center btn btn-primary">Request Refund</button>
    <button onclick="location.href='question-answers.php'" class="mt-2 text-center btn btn-primary">Q&A Page</button>
    <button onclick="location.href='assignments.php'" class="mt-2 text-center btn btn-primary">Assignments</button>
    <button onclick="location.href='rate.php'" class="mt-2 text-center btn btn-primary">Rate</button>
    <div class="jumbotron mt-4">
        <h3 class="display-2 mb-1"><?php echo $cname ?></h3>

        <hr class="my-4">
        <h3 class="display-5 mb-4">Announcements</h3>
        <?php
        $sql1 = "SELECT date, text FROM announcement WHERE course_id = $cid  ORDER BY date ";
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
                        "</th><td>" . $q_result1["text"] ;


                    echo "</td></tr>";

                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "There is no announcement found.";
            }
        }

        ?>
        <br>


        <h3 class="display-5 mb-4">Lectures</h3>
        <hr class="my-4">

        <?php
        $sql = "SELECT lecture_id, lecture_name, duration, description FROM lecture WHERE course_id = $cid ";
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
        }
        ?>
        <br></br>
    </div>


</div>
</html>
